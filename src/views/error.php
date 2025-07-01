<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Error</h1>
        <h2><?php echo $error_type; ?></h2>
        <p><?php echo $error_message; ?></p>
        <a href="/" class="button">Volver</a>
    </div>
</body>
</html>
