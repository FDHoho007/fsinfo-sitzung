<!doctype html>
<html>

<head>

    <meta charset="utf-8">
    <title>Meme</title>
    <meta name="author" content="Fabian Dietrich">
    <script src="https://unpkg.com/htmx.org@2.0.3" integrity="sha384-0895/pl2MU10Hqc6jd4RvrthNlDiE9U1tWmX7WRESftEDRosgxNsQG/Ze9YMRzHq" crossorigin="anonymous"></script>

    <style>
        body {
            margin: 0;
        }
        div {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }
        div img {
            max-width: 100%;
            max-height: 85%;
            object-fit: contain;
        }
    </style>

</head>

<body>

<div hx-get="/api/meme.php" hx-trigger="load" hx-swap="outerHTML"></div>

</body>

</html>