<?php

header("HTTP/1.0 500 Internal Server Error");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 Internal Server Error</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .error-container {
            text-align: center;
        }

        .error-container h1 {
            font-size: 5rem;
            margin: 0;
        }

        .error-container p {
            font-size: 1.5rem;
            margin: 10px 0;
        }

        .error-container i {
            font-size: 5rem;
            color: #dc3545;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <i class="fas fa-exclamation-triangle"></i>
        <h1>500</h1>
        <p>Internal Server Error</p>
    </div>
</body>

</html>
';
