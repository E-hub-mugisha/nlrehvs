<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'NLREHVS') }}</title>

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body { background-color: #f8f9fa; }
        .card { border-radius: 0.75rem; }
    </style>
</head>
<body>
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="col-md-6 col-lg-5">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Optional: Include jQuery if using AJAX -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @stack('scripts')
</body>
</html>