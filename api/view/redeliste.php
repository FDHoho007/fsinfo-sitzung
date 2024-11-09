<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Redeliste</title>
    <meta name="author" content="Fabian Dietrich">
    <script src="https://unpkg.com/htmx.org@2.0.3" integrity="sha384-0895/pl2MU10Hqc6jd4RvrthNlDiE9U1tWmX7WRESftEDRosgxNsQG/Ze9YMRzHq" crossorigin="anonymous"></script>
    <style>
        html {
            font-family: sans-serif;
            margin: 0 1rem;
        }
        #redeliste {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <h1>Redeliste</h1>
    <div id="redeliste" hx-get="/api/redeliste.php" hx-trigger="every 1s"></div>
</body>
</html>