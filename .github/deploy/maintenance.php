<?php
// -----------------------------------------------------------------------------
// Standalone Wartungsseite für Deployment
// -----------------------------------------------------------------------------
// Diese Datei wird während des Deployments temporär hochgeladen.
// Sie funktioniert OHNE Laravel-Framework und OHNE Vendor-Ordner.
// Laravel's public/index.php erkennt diese Datei automatisch und bricht
// den Request ab, bevor der Autoloader startet.
// -----------------------------------------------------------------------------

// 1. Sende korrekten HTTP Status Code für Suchmaschinen (SEO Safe)
http_response_code(503);

// 2. Sage Clients, sie sollen es in 60 Sekunden erneut versuchen
header('Retry-After: 60');
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wartungsarbeiten | Wir sind gleich zurück</title>
    <style>
        /* Alles Inline-CSS, damit keine externen Assets geladen werden müssen */
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f9fafb;
            color: #374151;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .card {
            background: white;
            padding: 3rem 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            max-width: 450px;
            width: 90%;
            border-top: 6px solid #3b82f6; /* Laravel Blue */
        }
        h1 {
            margin-top: 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
        }
        p {
            margin-bottom: 1.5rem;
            line-height: 1.6;
            color: #6b7280;
        }
        .spinner {
            margin: 0 auto 1.5rem;
            width: 40px;
            height: 40px;
            border: 4px solid #e5e7eb;
            border-top-color: #3b82f6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .timer {
            font-size: 0.875rem;
            color: #9ca3af;
        }
    </style>
    <script>
        // Automatischer Reload der Seite nach 60 Sekunden
        setTimeout(function() {
            window.location.reload();
        }, 60000);
    </script>
</head>
<body>
<div class="card">
    <div class="spinner"></div>
    <h1>System-Update</h1>
    <p>Wir aktualisieren gerade unsere Anwendung, um Ihnen neue Funktionen bereitzustellen. Dies dauert normalerweise weniger als eine Minute.</p>
    <div class="timer">Seite lädt automatisch neu...</div>
</div>
</body>
</html>
