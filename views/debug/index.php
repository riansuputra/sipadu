<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Debug Log</h4>

        <a href="/debug/clear"
            class="btn btn-danger btn-sm"
            onclick="return confirm('Clear log?')">
            Clear Log
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <pre style="
                max-height: 700px;
                overflow: auto;
                background: #111;
                color: #0f0;
                padding: 20px;
                font-size: 13px;
                border-radius: 10px;
            "><?= htmlspecialchars($content) ?></pre>

        </div>
    </div>

</div>