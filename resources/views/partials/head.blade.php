<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Max Flex')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, "Helvetica Neue"; }
        .navbar-brand { font-weight: 700; }
        .card-img-top { object-fit: cover; height: 220px; }
    </style>
    @stack('styles')
</head>
