<nav class="navbar navbar-expand-lg bg-white border-bottom">
  <div class="container">
    <a class="navbar-brand" href="{{ route('front.series.index') }}">Max Flex</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="{{ route('front.series.index') }}">Home</a></li>
        @auth
          <li class="nav-item"><a class="nav-link" href="{{ route('favorites.index') }}">My Favorites</a></li>
        @endauth
        @auth
        @php $unread = auth()->user()->unreadNotifications()->count(); @endphp
        <li class="nav-item">
            <a class="nav-link" href="{{ route('notifications.index') }}">
            Notifications
            @if($unread) <span class="badge bg-danger">{{ $unread }}</span> @endif
            </a>
        </li>
        @endauth

        @auth
            <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
        @endauth

      </ul>

      <ul class="navbar-nav ms-auto">
        @guest
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
          <li class="nav-item"><a class="btn btn-primary btn-sm" href="{{ route('register') }}">Register</a></li>
        @else
          <li class="nav-item"><span class="nav-link">Hi, {{ auth()->user()->name }}</span></li>
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">@csrf
              <button class="btn btn-outline-danger btn-sm">Logout</button>
            </form>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
