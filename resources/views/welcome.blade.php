<!doctype html>
<html lang="en">
<head>
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Header</h1>
<button hx-get="/test" hx-trigger="click" hx-target="#response">Click Me</button>
<div id="response"></div>

</body>
</html>
