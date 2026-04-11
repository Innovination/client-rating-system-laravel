<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ trans('panel.site_title') }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <style>
        body { background: #f4f7f9; }
        .topbar { background: #0f766e; color: #fff; }
        .topbar a { color: #fff; text-decoration: none; }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="topbar py-2">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="{{ route('landing') }}"><strong>{{ trans('panel.site_title') }}</strong></a>
            <div>
                <a href="{{ route('clients.index') }}" class="mr-3">Client Directory</a>
                <a href="{{ route('login') }}" class="mr-3">Login</a>
                <a href="{{ route('agency.register') }}">Register</a>
            </div>
        </div>
    </nav>
    @yield('content')
</body>
</html>
