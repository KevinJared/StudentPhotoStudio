<?php

declare(strict_types=1);
require __DIR__ . '/db.php';

function json_out(array $data, int $status = 200): never
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}
function clean_adm(string $adm): string
{
    $adm = trim($adm);
    if ($adm === '' || mb_strlen($adm) > 100) json_out(['error' => 'Invalid admission number.'], 422);
    return $adm;
}
$action = $_GET['action'] ?? '';
$photoDir = __DIR__ . '/storage/photos';
if (!is_dir($photoDir)) mkdir($photoDir, 0770, true);

try {
    if ($action === 'list' && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $students = $pdo->query("
            SELECT s.admno AS adm, s.student_name AS name,
                   CASE WHEN p.admno IS NULL THEN 0 ELSE 1 END AS done
            FROM students s LEFT JOIN student_photos p ON p.admno=s.admno
            ORDER BY s.admno
        ")->fetchAll();
        foreach ($students as &$s) $s['done'] = (bool)$s['done'];
        unset($s);
        $photos = $pdo->query("SELECT admno AS adm, file_name AS name, updated_at AS updated FROM student_photos ORDER BY admno")->fetchAll();
        json_out(['students' => $students, 'photos' => $photos]);
    }

    if ($action === 'import' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $body = json_decode(file_get_contents('php://input'), true);
        $records = $body['students'] ?? null;
        if (!is_array($records)) json_out(['error' => 'No student records were received.'], 422);
        $pdo->beginTransaction();
        $stmt = $pdo->prepare("INSERT INTO students (admno, student_name) VALUES (?, ?) ON DUPLICATE KEY UPDATE student_name=VALUES(student_name)");
        foreach ($records as $row) {
            $adm = clean_adm((string)($row['adm'] ?? ''));
            $name = trim((string)($row['name'] ?? ''));
            if (mb_strlen($name) > 255) $name = mb_substr($name, 0, 255);
            $stmt->execute([$adm, $name]);
        }
        $pdo->commit();
        json_out(['ok' => true, 'count' => count($records)]);
    }

    if ($action === 'clear_roster' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        // Keep photographs; only remove the student register.
        $pdo->exec("DELETE FROM students");
        json_out(['ok' => true]);
    }

    if ($action === 'save_photo' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $adm = clean_adm((string)($_POST['adm'] ?? ''));
        if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) json_out(['error' => 'Photo upload failed.'], 422);
        $max = (int)($config['max_upload_bytes'] ?? 12582912);
        if ($_FILES['photo']['size'] > $max) json_out(['error' => 'Photo is too large. Maximum upload size is 12 MB.'], 413);
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($_FILES['photo']['tmp_name']);
        if ($mime !== 'image/jpeg') json_out(['error' => 'Only processed JPEG photographs are accepted.'], 415);
        // Use the admission number as the physical photo filename. URL-encoding
        // keeps unusual characters (such as / or spaces) from creating unsafe paths.
        $safe = rawurlencode($adm) . '.jpg';
        $target = $photoDir . '/' . $safe;
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target)) json_out(['error' => 'Could not save the photograph on the server.'], 500);
        $displayName = basename((string)($_POST['name'] ?? 'photo.jpg'));
        $stmt = $pdo->prepare("INSERT INTO student_photos (admno, file_name, storage_name, updated_at) VALUES (?, ?, ?, NOW()) ON DUPLICATE KEY UPDATE file_name=VALUES(file_name), storage_name=VALUES(storage_name), updated_at=NOW()");
        $stmt->execute([$adm, $displayName, $safe]);
        json_out(['ok' => true, 'file_name' => $displayName, 'storage_name' => $safe]);
    }

    if ($action === 'photo' && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $adm = clean_adm((string)($_GET['adm'] ?? ''));
        $stmt = $pdo->prepare("SELECT storage_name FROM student_photos WHERE admno=?");
        $stmt->execute([$adm]);
        $row = $stmt->fetch();
        if (!$row) {
            http_response_code(404);
            exit('Photo not found');
        }
        $path = $photoDir . '/' . basename($row['storage_name']);
        if (!is_file($path)) {
            http_response_code(404);
            exit('Photo file missing');
        }
        header('Content-Type: image/jpeg');
        header('Content-Length: ' . filesize($path));
        header('Content-Disposition: attachment; filename*=UTF-8\'\'' . rawurlencode(basename($row['storage_name'])));
        header('X-Content-Type-Options: nosniff');
        readfile($path);
        exit;
    }

    json_out(['error' => 'Unknown API action.'], 404);
} catch (Throwable $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    json_out(['error' => 'The server could not complete the request. Check PHP logs for details.'], 500);
}
