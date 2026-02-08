<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mock Router Logon</title>
</head>
<body>
    <h1>Mock Router</h1>

    <p>{{ $message }}</p>

    <hr />

    <h2>Raw Query</h2>
    <pre>{{ json_encode(request()->query(), JSON_PRETTY_PRINT) }}</pre>
</body>
</html>
