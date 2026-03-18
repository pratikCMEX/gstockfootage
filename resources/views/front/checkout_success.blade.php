<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #0f1117;
            color: #e2e8f0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background: #1a1d2e;
            border: 1px solid #2d3148;
            border-radius: 20px;
            padding: 48px 40px;
            width: 100%;
            max-width: 480px;
            text-align: center;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4);
        }

        .check-wrap {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            animation: pop 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) both;
        }

        @keyframes pop {
            from {
                transform: scale(0);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .check-wrap svg {
            width: 36px;
            height: 36px;
        }

        h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #f8fafc;
            margin-bottom: 8px;
        }

        .subtitle {
            font-size: 0.9rem;
            color: #94a3b8;
            margin-bottom: 32px;
        }

        .status-box {
            background: #252840;
            border: 1px solid #3d4170;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .spinner {
            width: 18px;
            height: 18px;
            border: 2px solid #3d4170;
            border-top-color: #6366f1;
            border-radius: 50%;
            flex-shrink: 0;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .spinner.done {
            border: 2px solid #10b981;
            animation: none;
        }

        #status-text {
            font-size: 0.875rem;
            color: #cbd5e1;
            text-align: left;
        }

        #file-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 24px;
        }

        #file-list li {
            background: #1e2235;
            border: 1px solid #2d3148;
            border-radius: 10px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.85rem;
            color: #94a3b8;
            opacity: 0;
            transform: translateY(8px);
            transition: all 0.3s ease;
        }

        #file-list li.visible {
            opacity: 1;
            transform: translateY(0);
        }

        #file-list li.downloading {
            border-color: #4f46e5;
            color: #a5b4fc;
        }

        #file-list li.done {
            border-color: #10b981;
            color: #6ee7b7;
        }

        .progress-wrap {
            background: #252840;
            border-radius: 999px;
            height: 6px;
            margin-bottom: 24px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            border-radius: 999px;
            width: 0%;
            transition: width 0.6s ease;
        }

        .redirect-note {
            font-size: 0.8rem;
            color: #475569;
        }

        .redirect-note span {
            color: #6366f1;
            font-weight: 600;
        }

        .error-box {
            background: #2d1b1b;
            border: 1px solid #7f1d1d;
            border-radius: 12px;
            padding: 16px;
            font-size: 0.85rem;
            color: #fca5a5;
            display: none;
            margin-bottom: 16px;
        }
    </style>
</head>

<body>

    <div class="card">

        <div class="check-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round"
                stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12" />
            </svg>
        </div>

        <h1>Payment Successful!</h1>
        <p class="subtitle">Your files are being prepared for download.</p>

        <div class="status-box">
            <div class="spinner" id="spinner"></div>
            <div id="status-text">Waiting for payment confirmation...</div>
        </div>

        <div class="error-box" id="error-box">
            Could not load files automatically. Please check your email for download links.
        </div>

        <div class="progress-wrap" id="progress-wrap" style="display:none">
            <div class="progress-bar" id="progress-bar"></div>
        </div>

        <ul id="file-list"></ul>

        <p class="redirect-note" id="redirect-note" style="display:none">
            Redirecting to home in <span id="countdown">5</span>s...
        </p>

    </div>

    <script>
        // SESSION_ID is resolved server-side from the token — never appears in URL
        const SESSION_ID = @json($sessionId);
        const CSRF_TOKEN = "{{ csrf_token() }}";
        const POLL_INTERVAL = 2000;
        const MAX_ATTEMPTS = 20;
        const DOWNLOAD_GAP = 900;
        const REDIRECT_DELAY = 5;

        let attempts = 0;

        const statusText = document.getElementById('status-text');
        const spinner = document.getElementById('spinner');
        const fileList = document.getElementById('file-list');
        const progressWrap = document.getElementById('progress-wrap');
        const progressBar = document.getElementById('progress-bar');
        const redirectNote = document.getElementById('redirect-note');
        const countdown = document.getElementById('countdown');
        const errorBox = document.getElementById('error-box');

        function pollForOrder() {

            if (attempts >= MAX_ATTEMPTS) {
                spinner.classList.add('done');
                statusText.textContent = 'Order confirmed! Check your email for files.';
                errorBox.style.display = 'block';
                setTimeout(goHome, 5000);
                return;
            }

            attempts++;

            if (attempts > 3) {
                statusText.textContent = `Confirming payment... (${attempts}/${MAX_ATTEMPTS})`;
            }

            // session_id sent in POST body — never in URL — avoids ModSecurity
            fetch('/order/status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        session_id: SESSION_ID
                    })
                })
                .then(res => {
                    if (res.status === 401) {
                        window.location.href = '/login';
                        return null;
                    }
                    return res.json();
                })
                .then(data => {
                    if (!data) return;

                    if (data.status === 'pending') {
                        setTimeout(pollForOrder, POLL_INTERVAL);
                    } else if (data.status === 'ready') {
                        handleDownloads(data.files);
                    } else {
                        showError();
                    }
                })
                .catch(err => {
                    console.warn('Poll error:', err);
                    setTimeout(pollForOrder, POLL_INTERVAL);
                });
        }

        function handleDownloads(files) {

            if (!files || files.length === 0) {
                spinner.classList.add('done');
                statusText.textContent = 'Order complete! No files to download.';
                startRedirectCountdown();
                return;
            }

            spinner.classList.add('done');
            statusText.textContent = `Downloading ${files.length} file${files.length > 1 ? 's' : ''}...`;
            progressWrap.style.display = 'block';

            files.forEach((file, i) => {
                const li = document.createElement('li');
                li.id = `file-${i}`;
                li.innerHTML = `<span>📄</span> ${file.file_name}`;
                fileList.appendChild(li);
                setTimeout(() => li.classList.add('visible'), i * 100);
            });

            let completed = 0;

            files.forEach((file, i) => {
                setTimeout(() => {

                    const li = document.getElementById(`file-${i}`);
                    if (li) {
                        li.classList.add('downloading');
                        li.innerHTML = `<span>⬇️</span> ${file.file_name}`;
                    }

                    triggerBrowserDownload(file.download_url, file.file_name);

                    setTimeout(() => {
                        if (li) {
                            li.classList.remove('downloading');
                            li.classList.add('done');
                            li.innerHTML = `<span>✅</span> ${file.file_name}`;
                        }

                        completed++;
                        const pct = Math.round((completed / files.length) * 100);
                        progressBar.style.width = pct + '%';

                        if (completed === files.length) {
                            statusText.textContent = 'All files downloaded successfully!';
                            setTimeout(startRedirectCountdown, 500);
                        }

                    }, 1500);

                }, i * DOWNLOAD_GAP);
            });
        }

        // REPLACE with this:
        function triggerBrowserDownload(url, fileName) {
            const a = document.createElement('a');
            a.href = url;
            a.download = fileName;
            a.target = '_blank';
            a.style.display = 'none';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }

        function startRedirectCountdown() {
            redirectNote.style.display = 'block';
            let secs = REDIRECT_DELAY;
            countdown.textContent = secs;

            const interval = setInterval(() => {
                secs--;
                countdown.textContent = secs;
                if (secs <= 0) {
                    clearInterval(interval);
                    goHome();
                }
            }, 1000);
        }

        function goHome() {
            window.location.href = '/';
        }

        function showError() {
            spinner.classList.add('done');
            statusText.textContent = 'Something went wrong. Check your email.';
            errorBox.style.display = 'block';
            setTimeout(goHome, 6000);
        }

        // Start — if sessionId is null, cache expired or token was invalid
        if (!SESSION_ID) {
            spinner.classList.add('done');
            statusText.textContent = 'Session expired. Check your email for order confirmation.';
            errorBox.style.display = 'block';
            setTimeout(goHome, 5000);
        } else {
            pollForOrder();
        }
    </script>

</body>

</html>
