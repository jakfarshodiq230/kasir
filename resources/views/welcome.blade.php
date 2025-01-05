<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Internal Server Error</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .error-container {
            text-align: center;
            max-width: 600px;
        }
        .error-container img {
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <img src="https://demo.wpbeaveraddons.com/wp-content/uploads/2018/02/main-vector.png" alt="maintenance">
        <h1 class="display-4">500 - Internal Server Error</h1>
        <p class="lead">Oops! Something went wrong on our end. Please try again later.</p>
        <div class="mt-4">
            <a href="/" class="btn btn-primary">Go to Homepage</a>
            <button class="btn btn-secondary" onclick="location.reload();">Reload Page</button>
            <a href="mailto:support@example.com" class="btn btn-outline-danger">Contact Support</a>
        </div>
    </div>
</body>

</html>
