<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <style>
        /* Add your basic email styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: #ffffff;
            padding: 20px;
            margin: auto;
            width: 100%;
            max-width: 600px;
            border: 1px solid #ddd;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            padding: 20px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1>@yield('title')</h1>

        @yield('content')

        <div class="footer">
            <p>&copy; {{ date('Y') }} Jahankeöde HK. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
