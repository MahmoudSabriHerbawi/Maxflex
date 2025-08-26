<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
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
      </ul>

      <ul class="navbar-nav ms-auto align-items-lg-center">
        @auth
          @php $role = auth()->user()->role; $unread = auth()->user()->unreadNotifications()->count(); @endphp
          <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('notifications.index') }}">
              Notifications @if($unread)<span class="badge bg-danger">{{ $unread }}</span>@endif
            </a>
          </li>

          @if($role === 'admin')
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="adminMenu" role="button" data-bs-toggle="dropdown">Admin</a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminMenu">
                <li><a class="dropdown-item" href="{{ route('admin.series.index') }}">Manage Series</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.episodes.index') }}">Manage Episodes</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}">Manage Categories</a></li>
              </ul>
            </li>
          @elseif($role === 'employee')
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.episodes.index') }}">Manage Episodes</a></li>
          @endif

          <li class="nav-item">
            <span class="nav-link">Hi, {{ auth()->user()->name }}</span>
          </li>
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}" class="ms-lg-2">@csrf
              <button class="btn btn-outline-danger btn-sm">Logout</button>
            </form>
          </li>
        @endauth

        @guest
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
          <li class="nav-item"><a class="btn btn-primary btn-sm ms-lg-2" href="{{ route('register') }}">Register</a></li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
