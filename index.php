<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Student Photo Studio</title>
    <style>
        :root {
            --navy: #12345a;
            --blue: #2563eb;
            --bg: #f3f6fb;
            --ink: #172033;
            --muted: #64748b;
            --line: #dce4ef;
            --green: #12804a;
            --red: #b42318
        }

        * {
            box-sizing: border-box
        }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--ink);
            font: 14px/1.5 system-ui, Segoe UI, Arial, sans-serif
        }

        header {
            background: linear-gradient(120deg, #12345a, #2563eb);
            color: white;
            padding: 22px max(18px, calc((100% - 1250px)/2))
        }

        header h1 {
            font-size: 26px;
            margin: 0
        }

        header p {
            margin: 4px 0 0;
            color: #e3edff
        }

        main {
            max-width: 1250px;
            margin: 22px auto;
            padding: 0 16px 40px;
            display: grid;
            gap: 16px
        }

        .card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 18px;
            box-shadow: 0 4px 18px #16345b0a
        }

        h2 {
            font-size: 17px;
            margin: 0 0 13px
        }

        .muted {
            color: var(--muted)
        }

        .small {
            font-size: 12px
        }

        .gridstats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px
        }

        .stat {
            border: 1px solid var(--line);
            border-radius: 11px;
            padding: 14px
        }

        .stat strong {
            display: block;
            font-size: 28px;
            color: var(--navy)
        }

        .stat span {
            color: var(--muted);
            font-size: 12px
        }

        .row {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap
        }

        button,
        .filelabel {
            border: 0;
            border-radius: 8px;
            padding: 9px 13px;
            background: var(--blue);
            color: white;
            font-weight: 650;
            cursor: pointer;
            font-size: 13px
        }

        button.secondary,
        .filelabel.secondary {
            background: #eaf0fa;
            color: #17365e
        }

        button.green {
            background: var(--green)
        }

        button.red {
            background: #fff0ef;
            color: var(--red)
        }

        button:disabled {
            opacity: .45;
            cursor: not-allowed
        }

        input,
        select {
            border: 1px solid #055eca;
            border-radius: 8px;
            padding: 9px 10px;
            font: inherit;
            max-width: 100%
        }

        input[type=file] {
            display: none
        }

        .field {
            display: grid;
            gap: 4px;
            min-width: 150px;
            flex: 1
        }

        .field label {
            font-size: 12px;
            color: var(--muted);
            font-weight: 650
        }

        .status {
            padding: 9px 11px;
            background: #eef4ff;
            color: #21436e;
            border-radius: 8px;
            margin-top: 10px
        }

        .status.good {
            background: #eaf8ef;
            color: #17643c
        }

        .status.error {
            background: #fff0ef;
            color: var(--red)
        }

        .layout {
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(320px, .95fr);
            gap: 16px
        }

        .camera {
            aspect-ratio: 3/4;
            max-height: 460px;
            background: #111827;
            border-radius: 10px;
            overflow: hidden;
            display: grid;
            place-items: center;
            position: relative
        }

        video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none
        }

        #camHint {
            color: #d5e0ee;
            text-align: center;
            padding: 18px
        }

        .photo-preview {
            width: auto;
            max-width: 100%;
            height: 390px;
            aspect-ratio: 3/4;
            object-fit: contain;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 8px;
            display: none
        }

        #editCanvas {
            display: none
        }

        .student-list {
            max-height: 400px;
            overflow: auto;
            border: 1px solid var(--line);
            border-radius: 9px
        }

        .student {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
            padding: 9px 10px;
            border-bottom: 1px solid #edf1f6;
            cursor: pointer
        }

        .student:last-child {
            border: 0
        }

        .student.active {
            background: #eef4ff
        }

        .student.done .sname:after {
            content: " ✓";
            color: var(--green);
            font-weight: 800
        }

        .sname {
            font-weight: 650
        }

        .meta {
            font-size: 11px;
            color: var(--muted)
        }

        .tag {
            font-size: 10px;
            padding: 3px 7px;
            border-radius: 20px;
            background: #edf2f7;
            color: #42536a
        }

        .tag.done {
            background: #e8f7ee;
            color: #17643c
        }

        .progress {
            height: 8px;
            background: #e8edf5;
            border-radius: 20px;
            overflow: hidden
        }

        .progress>div {
            height: 100%;
            background: #16a05d;
            width: 0
        }

        .controls {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 9px;
            margin-top: 12px
        }

        .slider {
            display: grid;
            gap: 2px;
            font-size: 12px;
            color: var(--muted)
        }

        .slider input {
            width: 100%;
            padding: 0
        }

        .warning {
            font-size: 12px;
            color: #805b16;
            background: #fff8e7;
            padding: 9px;
            border-radius: 8px;
            margin-top: 10px
        }

        @media(max-width:820px) {
            .layout {
                grid-template-columns: 1fr
            }

            .gridstats {
                grid-template-columns: 1fr 1fr
            }

            .card {
                padding: 14px
            }
        }

        .photo-record-preview {
            margin-top: 16px;
            padding: 14px;
            border: 1px solid var(--line);
            border-radius: 12px;
            background: #f8fafc
        }

        .photo-record-preview h3 {
            margin: 0 0 10px;
            font-size: 15px;
            color: var(--navy)
        }

        .photo-record-preview .preview-content {
            min-height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap
        }

        .photo-record-preview img {
            display: block;
            max-height: 230px;
            max-width: 180px;
            object-fit: contain;
            border: 1px solid #dce4ef;
            border-radius: 8px;
            background: white
        }

        .photo-record-preview .missing-photo {
            padding: 26px 38px;
            border: 1px dashed #dc8b85;
            border-radius: 10px;
            background: #fff4f2;
            color: #b42318;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 1px
        }

        .photo-record-preview .preview-meta {
            color: var(--muted);
            font-size: 13px
        }
    </style>
</head>

<body>
    <header>
        <h1>CHEBORGE BOYS SENIOR</h1>

    </header>
    <main>
        <section class="card" id="registerCard">
            <h2>Student Photo Studio</h2>

            <div class="row">
                <h3>Import student register</h3><label class="filelabel" for="excelFile">Choose Excel / CSV</label><input id="excelFile" type="file" accept=".xlsx,.xls,.csv">
                <span class="small muted" id="fileName">No file selected</span>
                <button id="clearRoster" class="red">Clear student register</button>
            </div>
            <p class="small muted">The first row must contain headings. Select the columns for ADM number and student name after choosing the file. Existing stored photos are retained when the same ADM numbers are imported again.</p>
            <div class="row" id="mapping" style="display:none">
                <div class="field"><label>Worksheet</label><select id="sheetSelect"></select></div>
                <div class="field"><label>ADM number column</label><select id="admColumn"></select></div>
                <div class="field"><label>Student name column</label><select id="nameColumn"></select></div>
                <button id="loadStudents">Import / update register</button>
            </div>
            <div id="importStatus" class="status">Choose an Excel file to begin.</div>
        </section>

        <section class="layout">
            <div class="card">
                <h2>Student register & missing photos</h2>
                <div class="row" style="margin-bottom:10px">
                    <input id="search" placeholder="Search ADM number or name" style="flex:1">
                    <select id="filter">
                        <option value="all">All students</option>
                        <option value="missing">Missing photos</option>
                        <option value="done">Captured photos</option>
                    </select>
                </div>
                <div class="student-list" id="studentList">
                    <div class="muted" style="padding:20px;text-align:center">No students loaded.</div>
                </div>
                <div class="row" style="margin-top:11px">
                    <button id="previous" class="secondary" disabled>Previous</button><button id="next" class="secondary" disabled>Next student</button>
                </div>
                <div class="photo-record-preview">
                    <h3>Selected student's photograph</h3>
                    <div class="preview-content" id="studentPhotoPreview">
                        <div class="muted">Click a student to view their photograph here.</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <h2>Capture photograph</h2>
                <div class="row" style="justify-content:space-between;margin-bottom:9px">
                    <div><strong id="selectedName">No student selected</strong>
                        <div class="small muted" id="selectedAdm">Import a student register</div>
                    </div>
                    <span class="tag" id="photoState">Not captured</span>
                </div>
                <div class="camera" id="cameraBox">
                    <video id="video" autoplay playsinline muted></video>
                    <div id="camHint">Camera preview<br><span class="small">Start the camera and allow permission</span></div>
                </div>
                <canvas id="sourceCanvas" hidden></canvas><canvas id="editCanvas" width="900" height="1200"></canvas>
                <img id="preview" class="photo-preview" alt="Edited 3 by 4 inch photo preview">
                <div class="row" style="margin-top:10px">
                    <button id="startCamera">Start camera</button><button id="capture" disabled>Capture</button>
                    <button id="editAgain" class="secondary" disabled>Retake</button>
                </div>
                <div class="controls">
                    <label class="slider">Zoom <input id="zoom" type="range" min="1" max="2.5" value="1" step=".05"></label>
                    <label class="slider">Horizontal position <input id="offsetX" type="range" min="-0.5" max=".5" value="0" step=".01"></label>
                    <label class="slider">Vertical position <input id="offsetY" type="range" min="-0.5" max=".5" value="0" step=".01"></label>
                    <label class="slider">Brightness <input id="brightness" type="range" min="70" max="135" value="100"></label>
                </div>
                <div class="row" style="margin-top:12px">
                    <button id="applyEdit" class="secondary" disabled>Apply edits & white background</button>
                    <button id="savePhoto" class="green" disabled>Save photo</button>
                </div>
                <div id="captureStatus" class="status">Select a student, then start the webcam.</div>
                <div class="warning">Photo size is exported at 900 × 1200 pixels (3 × 4 inches at 300 DPI). Automatic background removal works best when the student is clearly separated from the background. Check the preview before saving.</div>
            </div>
        </section>
        <section class="card">
            <div class="gridstats">
                <div class="stat"><strong id="totalCount">0</strong><span>Total students</span></div>
                <div class="stat"><strong id="doneCount">0</strong><span>Photos captured</span></div>
                <div class="stat"><strong id="pendingCount">0</strong><span>Photos missing</span></div>
            </div>
            <div class="progress" style="margin-top:13px">
                <div id="progressBar"></div>
            </div>
            <div class="row" style="justify-content:space-between;margin-top:8px">
                <span class="small muted" id="progressText">Import an Excel register to begin.</span>
                <div class="row"><button id="showMissing" class="secondary" disabled>Show missing photos</button><button id="showRegister" class="secondary" style="display:none">Change / re-import register</button></div>
            </div>
        </section>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jszip@3.10.1/dist/jszip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/selfie_segmentation@0.1.1675465747/selfie_segmentation.js"></script>
    <script>
        const $ = id => document.getElementById(id);
        let workbook, parsedRows = [],
            columns = [],
            students = [],
            currentIndex = -1,
            stream = null,
            rawShot = null,
            finalBlob = null,
            segmentation = null,
            showOnlyMissing = false,
            downloadDirectory = null,
            photosCache = [];
        const cleanName = s => String(s ?? "").trim().replace(/[\\/:*?"<>|]/g, "_").replace(/\s+/g, "_").replace(/[. ]+$/, "");
        const esc = s => String(s).replace(/[&<>"']/g, c => ({
            "&": "&amp;",
            "<": "&lt;",
            ">": "&gt;",
            '"': "&quot;",
            "'": "&#39;"
        } [c]));
        const status = (id, msg, kind = "") => {
            $(id).textContent = msg;
            $(id).className = "status " + kind
        };
        async function api(action, options = {}) {
            const response = await fetch(`api.php?action=${encodeURIComponent(action)}`, options);
            const contentType = response.headers.get("content-type") || "";
            if (!response.ok) {
                let message = `Server error (${response.status})`;
                if (contentType.includes("application/json")) {
                    const e = await response.json();
                    message = e.error || message;
                }
                throw new Error(message);
            }
            if (contentType.includes("application/json")) return response.json();
            return response;
        }
        async function getAll(store) {
            const data = await api("list");
            photosCache = data.photos || [];
            return store === "students" ? (data.students || []) : photosCache;
        }
        async function fetchPhoto(adm) {
            const url = `api.php?action=photo&adm=${encodeURIComponent(adm)}&_=${Date.now()}`;

            const response = await fetch(url, {
                method: 'GET',
                cache: 'no-store'
            });

            if (!response.ok) {
                const error = await response.text();
                throw new Error(`Photo loading failed: ${error}`);
            }

            const blob = await response.blob();

            if (!blob.type.includes('image/')) {
                throw new Error('The server did not return an image.');
            }

            return blob;
        }
        async function savePhotoToServer(adm, name, blob) {
            const form = new FormData();
            form.append("adm", adm);
            form.append("name", name);
            form.append("photo", blob, name);
            await api("save_photo", {
                method: "POST",
                body: form
            });
        }
        async function refresh() {
            students = (await getAll("students")).sort((a, b) => a.adm.localeCompare(b.adm, undefined, {
                numeric: true
            }));
            const photos = await getAll("photos"),
                keys = new Set(photos.map(p => p.adm));
            students.forEach(s => s.done = keys.has(s.adm));
            if (currentIndex >= students.length) currentIndex = students.length - 1;
            render();
            updateStudentPhotoPreview();
        }

        function currentStudent() {
            return students[currentIndex] || null
        }

        function render() {
            const done = students.filter(s => s.done).length,
                missing = students.length - done;
            $("totalCount").textContent = students.length;
            $("doneCount").textContent = done;
            $("pendingCount").textContent = missing;
            $("progressBar").style.width = students.length ? `${done/students.length*100}%` : "0%";
            $("progressText").textContent = students.length ? `${done} of ${students.length} students photographed (${Math.round(done/students.length*100)}%)` : "Import an Excel register to begin.";
            const s = currentStudent();
            $("selectedName").textContent = s?.name || "No student selected";
            $("selectedAdm").textContent = s?.adm || "";
            $("photoState").textContent = s?.done ? "Photo stored" : "Not captured";
            $("photoState").className = "tag " + (s?.done ? "done" : "");
            $("previous").disabled = currentIndex <= 0;
            $("next").disabled = currentIndex < 0 || currentIndex >= students.length - 1;
            const q = $("search").value.toLowerCase().trim(),
                f = $("filter").value;
            const shown = students.map((x, i) => ({
                ...x,
                i
            })).filter(x => (!q || x.adm.toLowerCase().includes(q) || x.name.toLowerCase().includes(q)) && (f === "all" || (f === "missing" && !x.done) || (f === "done" && x.done)));
            $("studentList").innerHTML = shown.length ? shown.map(x => `<div class="student ${x.i===currentIndex?"active":""} ${x.done?"done":""}" data-i="${x.i}"><div><div class="sname">${esc(x.name||"(No name)")}</div><div class="meta">${esc(x.adm)}</div></div><span class="tag ${x.done?"done":""}">${x.done?"Captured":"Missing"}</span></div>`).join("") : '<div class="muted" style="padding:20px;text-align:center">No students match this filter.</div>';
            [...$("studentList").querySelectorAll(".student")].forEach(el => el.onclick = () => selectStudent(+el.dataset.i));
            $("showMissing").disabled = !missing;
        }
        let photoPreviewRequest = 0,
            photoPreviewUrl = null;
        async function updateStudentPhotoPreview() {
            const host = $("studentPhotoPreview"),
                s = currentStudent(),
                request = ++photoPreviewRequest;
            if (photoPreviewUrl) {
                URL.revokeObjectURL(photoPreviewUrl);
                photoPreviewUrl = null
            }
            if (!s) {
                host.innerHTML = '<div class="muted">No student selected.</div>';
                return
            }
            host.innerHTML = `<div class="preview-meta"><strong>${esc(s.name||"(No name)")}</strong><br>ADM: ${esc(s.adm)}</div><div class="missing-photo">MISSING</div>`;
            const photo = photosCache.find(p => p.adm === s.adm);
            if (!photo) return;
            try {
                const blob = await fetchPhoto(s.adm);
                if (request !== photoPreviewRequest || currentStudent()?.adm !== s.adm) return;
                photoPreviewUrl = URL.createObjectURL(blob);
                host.innerHTML = `<div class="preview-meta"><strong>${esc(s.name||"(No name)")}</strong><br>ADM: ${esc(s.adm)}<br><span class="tag done">Photo available</span></div><img src="${photoPreviewUrl}" alt="Photograph of ${esc(s.name||s.adm)}">`;
            } catch (e) {
                console.error('Student photograph error:', e);

                if (request === photoPreviewRequest) {
                    host.innerHTML = `
            <div class="preview-meta">
                <strong>${esc(s.name || "(No name)")}</strong>
                <br>ADM: ${esc(s.adm)}
            </div>
            <div class="missing-photo">
                PHOTO ERROR
            </div> `;
                }
            }
        }

        function selectStudent(i) {
            if (i < 0 || i >= students.length) return;
            currentIndex = i;
            rawShot = null;
            finalBlob = null;
            $("preview").style.display = "none";
            $("applyEdit").disabled = true;
            $("savePhoto").disabled = true;
            $("capture").disabled = !stream;
            render();
            updateStudentPhotoPreview();
            status("captureStatus", `Ready for ${currentStudent().name} (${currentStudent().adm}).`)
        }
        $("excelFile").onchange = async e => {
            const file = e.target.files[0];
            if (!file) return;
            $("fileName").textContent = file.name;
            try {
                if (!window.XLSX) throw Error("Excel reader did not load. Connect to the internet, refresh, and retry.");
                workbook = XLSX.read(await file.arrayBuffer(), {
                    type: "array"
                });
                $("sheetSelect").innerHTML = workbook.SheetNames.map(n => `<option>${esc(n)}</option>`).join("");
                populateCols();
                $("mapping").style.display = "flex";
                status("importStatus", "Workbook loaded. Confirm worksheet and columns.", "good")
            } catch (err) {
                status("importStatus", err.message, "error")
            }
        };

        function populateCols() {
            const ws = workbook.Sheets[$("sheetSelect").value];
            parsedRows = XLSX.utils.sheet_to_json(ws, {
                defval: "",
                raw: false
            });
            columns = parsedRows.length ? Object.keys(parsedRows[0]) : [];
            ["admColumn", "nameColumn"].forEach(id => $(id).innerHTML = columns.map(c => `<option value="${esc(c)}">${esc(c)}</option>`).join(""));
            const norm = s => s.toLowerCase().replace(/[^a-z0-9]/g, "");
            const a = columns.find(c => ["admno", "admnumber", "admissionnumber", "admissionno", "admission"].includes(norm(c)));
            const n = columns.find(c => ["studentname", "name", "fullname", "pupilname"].includes(norm(c)));
            if (a) $("admColumn").value = a;
            if (n) $("nameColumn").value = n
        }
        $("sheetSelect").onchange = populateCols;
        $("loadStudents").onclick = async () => {
            const ac = $("admColumn").value,
                nc = $("nameColumn").value;
            if (!parsedRows.length || !ac) {
                status("importStatus", "No rows or ADM column found.", "error");
                return
            }
            let count = 0,
                dups = 0;
            const seen = new Set(),
                records = [];
            for (const r of parsedRows) {
                const adm = String(r[ac] ?? "").trim(),
                    name = String(r[nc] ?? "").trim();
                if (!adm) continue;
                const key = adm.toLowerCase();
                if (seen.has(key)) {
                    dups++;
                    continue
                }
                seen.add(key);
                records.push({
                    adm,
                    name
                });
                count++
            }
            await api("import", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    students: records
                })
            });
            await refresh();
            currentIndex = students.length ? 0 : -1;
            render();
            status("importStatus", `${count} student records imported or updated. ${dups} duplicate ADM row(s) skipped. Previously saved photos were retained in the database.`, "good");
            $("registerCard").style.display = "none";
            $("showRegister").style.display = "inline-block";
            if (currentIndex >= 0) selectStudent(currentIndex)
        };
        $("clearRoster").onclick = async () => {
            if (!confirm("Remove the entire student register? Stored photographs will NOT be deleted.")) return;
            try {
                await api("clear_roster", {
                    method: "POST"
                });
                currentIndex = -1;
                await refresh();
                status("importStatus", "Student register cleared. Stored photos remain in the photo archive.")
            } catch (e) {
                status("importStatus", e.message, "error")
            }
        };
        $("search").oninput = render;
        $("filter").onchange = render;
        $("showMissing").onclick = () => {
            $("filter").value = "missing";
            render()
        };
        $("showRegister").onclick = () => {
            $("registerCard").style.display = "block";
            $("showRegister").style.display = "none"
        };
        $("startCamera").onclick = async () => {
            try {
                if (!navigator.mediaDevices?.getUserMedia) throw Error("Camera needs a secure context. Run the app at http://localhost as described in README.");
                stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: "user"
                    },
                    audio: false
                });
                $("video").srcObject = stream;
                $("video").style.display = "block";
                $("camHint").style.display = "none";
                $("capture").disabled = !currentStudent();
                status("captureStatus", "Camera ready. Frame the student and capture.", "good")
            } catch (e) {
                status("captureStatus", `Camera error: ${e.message}`, "error")
            }
        };

        function cropToCanvas(source, canvas) {
            const ctx = canvas.getContext("2d"),
                W = canvas.width,
                H = canvas.height;
            const scale = Math.max(W / source.width, H / source.height) * Number($("zoom").value);
            const sw = W / scale,
                sh = H / scale;
            const cx = source.width / 2 + Number($("offsetX").value) * source.width * .45,
                cy = source.height / 2 + Number($("offsetY").value) * source.height * .45;
            const sx = Math.max(0, Math.min(source.width - sw, cx - sw / 2)),
                sy = Math.max(0, Math.min(source.height - sh, cy - sh / 2));
            ctx.clearRect(0, 0, W, H);
            ctx.filter = `brightness(${$("brightness").value}%)`;
            ctx.drawImage(source, sx, sy, Math.min(sw, source.width), Math.min(sh, source.height), 0, 0, W, H);
            ctx.filter = "none"
        }
        $("capture").onclick = () => {
            const v = $("video");
            if (!v.videoWidth || !currentStudent()) return;
            const c = $("sourceCanvas");
            c.width = v.videoWidth;
            c.height = v.videoHeight;
            c.getContext("2d").drawImage(v, 0, 0);
            rawShot = c;
            ["zoom", "offsetX", "offsetY", "brightness"].forEach(id => $(id).value = id === "zoom" ? 1 : id === "brightness" ? 100 : 0);
            cropToCanvas(rawShot, $("editCanvas"));
            $("preview").src = $("editCanvas").toDataURL("image/jpeg");
            $("preview").style.display = "block";
            $("applyEdit").disabled = false;
            $("savePhoto").disabled = true;
            $("capture").disabled = true;
            status("captureStatus", "Photo captured. Adjust crop and brightness, then apply white background.")
        };
        ["zoom", "offsetX", "offsetY", "brightness"].forEach(id => $(id).oninput = () => {
            if (rawShot) {
                cropToCanvas(rawShot, $("editCanvas"));
                $("preview").src = $("editCanvas").toDataURL("image/jpeg")
            }
        });
        $("editAgain").onclick = () => {
            rawShot = null;
            finalBlob = null;
            $("preview").style.display = "none";
            $("capture").disabled = !stream;
            $("applyEdit").disabled = true;
            $("savePhoto").disabled = true;
            status("captureStatus", "Ready to capture another photo.")
        };
        async function removeBackgroundAndExport() {
            const c = $("editCanvas"),
                ctx = c.getContext("2d");
            if (!window.SelfieSegmentation) {
                throw Error("Background-removal model did not load. Check internet connection, reload the app, and retry.")
            }
            if (!segmentation) {
                segmentation = new SelfieSegmentation({
                    locateFile: (file) => `https://cdn.jsdelivr.net/npm/@mediapipe/selfie_segmentation@0.1.1675465747/${file}`
                });
                segmentation.setOptions({
                    modelSelection: 1
                });
            }
            const result = await new Promise(async (resolve, reject) => {
                let timeout = setTimeout(() => reject(Error("Background removal timed out. Please try again.")), 30000);
                segmentation.onResults(r => {
                    clearTimeout(timeout);
                    resolve(r)
                });
                try {
                    await segmentation.send({
                        image: c
                    })
                } catch (e) {
                    clearTimeout(timeout);
                    reject(e)
                }
            });
            // First cut the student out on a transparent canvas. Applying destination-in
            // after painting the white background would mask the white too, leaving
            // transparent pixels that JPEG encodes as black.
            const mask = document.createElement("canvas");
            mask.width = 900;
            mask.height = 1200;
            const maskCtx = mask.getContext("2d", {
                willReadFrequently: true
            });
            maskCtx.drawImage(result.segmentationMask, 0, 0, 900, 1200);
            const subject = document.createElement("canvas");
            subject.width = 900;
            subject.height = 1200;
            const subjectCtx = subject.getContext("2d");
            subjectCtx.drawImage(c, 0, 0);
            subjectCtx.globalCompositeOperation = "destination-in";
            subjectCtx.drawImage(mask, 0, 0);
            subjectCtx.globalCompositeOperation = "source-over";
            // Composite the transparent cut-out over an opaque white canvas last.
            const out = document.createElement("canvas");
            out.width = 900;
            out.height = 1200;
            const o = out.getContext("2d");
            o.fillStyle = "#ffffff";
            o.fillRect(0, 0, 900, 1200);
            o.drawImage(subject, 0, 0);
            return await new Promise((resolve, reject) => out.toBlob(blob => blob ? resolve(blob) : reject(Error("Could not export the white-background photo.")), "image/jpeg", .94));
        }
        $("applyEdit").onclick = async () => {
            try {
                $("applyEdit").disabled = true;
                status("captureStatus", "Removing background and creating 900 × 1200 white-background image. This may take a few seconds…");
                finalBlob = await removeBackgroundAndExport();
                $("preview").src = URL.createObjectURL(finalBlob);
                $("savePhoto").disabled = false;
                status("captureStatus", "Background replaced with white. Review the result, then save.", "good")
            } catch (e) {
                status("captureStatus", `${e.message} You can still save a white-background crop without automatic cut-out by using the fallback button below.`, "error");
                $("savePhoto").disabled = false;
                finalBlob = null
            } finally {
                $("applyEdit").disabled = false
            }
        };
        $("savePhoto").onclick = async () => {
            const s = currentStudent();
            if (!s || !rawShot) return;
            // If segmentation failed, create a white canvas fallback from the edited crop.
            let blob = finalBlob;
            if (!blob) {
                const c = $("editCanvas"),
                    out = document.createElement("canvas");
                out.width = 900;
                out.height = 1200;
                const x = out.getContext("2d");
                x.fillStyle = "#fff";
                x.fillRect(0, 0, 900, 1200);
                x.drawImage(c, 0, 0);
                blob = await new Promise(r => out.toBlob(r, "image/jpeg", .94))
            }
            const photoName = cleanName(s.adm) + ".jpg";
            await savePhotoToServer(s.adm, photoName, blob);
            status("captureStatus", `Saved ${photoName} to the server database.`, "good");
            const next = students.findIndex((x, i) => i > currentIndex && !x.done);
            await refresh();
            if (next >= 0) await selectStudent(next);
            else {
                const first = students.findIndex(x => !x.done);
                if (first >= 0) await selectStudent(first);
                else render()
            }
        };
        $("previous").onclick = () => selectStudent(currentIndex - 1);
        $("next").onclick = () => selectStudent(currentIndex + 1);
        window.addEventListener("beforeunload", () => {
            if (stream) stream.getTracks().forEach(t => t.stop())
        });
        (async () => {
            try {
                await refresh();
                status("importStatus", "Connected to the PHP / MySQL photo database. Existing student records and photographs have been loaded.", "good")
            } catch (e) {
                status("importStatus", "Could not connect to the database: " + e.message + " Check PHP / MySQL setup and config.php.", "error")
            }
        })();
    </script>
</body>

</html>