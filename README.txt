STUDENT PHOTO STUDIO — PHP + MYSQL EDITION
=============================================

IMPORTANT
- The visual interface is retained: dashboard, Excel/CSV import, webcam capture,
  photo editor, white-background removal, missing-photo list and exports.
- Student records are stored in MySQL.
- Photograph files are stored in storage/photos using the admission number as the filename (for example, 12345.jpg). Characters that are unsafe in filenames are URL-encoded. Their details are
  stored in MySQL.
- The browser's IndexedDB is no longer the main database.
- The "Choose photo folder" feature still exports/copies photos to a folder you
  select on the computer running the browser. The server copy is saved first.

REQUIREMENTS
- PHP 8.1 or later
- MySQL 5.7+ / MariaDB 10.4+
- PHP extensions: pdo_mysql, fileinfo, mbstring
- Apache (XAMPP is a convenient Windows option) or another PHP web server
- Internet access for the existing Excel reader, ZIP library and MediaPipe
  background-removal libraries loaded from CDNs

INSTALLATION ON WINDOWS USING XAMPP
1. Install and open XAMPP.
2. Start Apache and MySQL.
3. Copy the StudentPhotoStudio_PHP folder into:
       C:\xampp\htdocs\
   You may rename it to StudentPhotoStudio.
4. Open phpMyAdmin:
       http://localhost/phpmyadmin
5. Import database.sql using the Import tab. This creates the database and tables.
6. Copy config.sample.php to config.php.
7. Edit config.php and enter your MySQL credentials. A default XAMPP setup
   commonly uses host=localhost, user=root, blank password.
8. Ensure the folder storage/photos is writable by the Apache/PHP process.
9. Open:
       http://localhost/StudentPhotoStudio/

USING THE APPLICATION
1. Import your Excel / CSV student register as before.
2. Select the ADM number and student name columns.
3. Capture, edit and save each student's photograph.
4. Each saved photograph is uploaded to the PHP server and recorded in MySQL.
5. Use the folder picker or export buttons when you also need copies on the
   computer you are using.

DATABASE BACKUP
- Export the student_photo_studio database from phpMyAdmin.
- Back up the complete storage/photos folder.
- Keep both backups together. The database alone does not contain the image bytes.

NETWORK USE
To allow other computers on the same school network to use the system, host it
on a dedicated school computer/server and browse to that computer's LAN address,
for example http://192.168.1.20/StudentPhotoStudio/.
Do not expose this application directly to the public internet without adding
user login, HTTPS, access controls and a backup plan. Student photographs and
admission records are personal information.

NOTES
- Server-side saving is persistent across browsers and computers connecting to
  the same server.
- "Choose photo folder" uses the browser's File System Access API where supported
  (typically current Chrome/Edge). Folder access is local to that browser/device.
- The segmentation model and JavaScript libraries are loaded from public CDNs.
