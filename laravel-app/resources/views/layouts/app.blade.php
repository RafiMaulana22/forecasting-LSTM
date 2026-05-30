<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forecasting Warung</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #f5f6fa;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background: #212529;
            color: white;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px;
        }

        .sidebar a:hover {
            background: #343a40;
        }
    </style>
</head>

<body>

    @include('layouts.sidebar')

    <div class="content">

        @include('layouts.navbar')

        @yield('content')

    </div>

</body>

</html>
