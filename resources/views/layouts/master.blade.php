<!doctype html>
<html lang="en" dir="ltr">
@include('partials.head')
<body class="bg-light">
    @include('partials.navbar')

    <main class="container py-4">
        @if(session('ok'))
            <div class="alert alert-success">{{ session('ok') }}</div>
        @endif
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>
