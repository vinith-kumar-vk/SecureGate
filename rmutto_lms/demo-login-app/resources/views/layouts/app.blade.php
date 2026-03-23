<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Application')</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">

    @if (request()->is('dashboard-1'))
        <style>
            {!! file_get_contents(public_path('css/style.css')) !!}
        </style>
    @endif

    @stack('styles')
</head>
<body>
    <!-- Navbar Included -->
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- JavaScript -->
    @include('partials.translations')
    <script src="{{ asset('js/script.js') }}?v={{ time() }}"></script>
    @stack('scripts')
</body>
</html>
