<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom navbar-glass">
  <div class="container">
    {{-- Brand --}}
    <a class="navbar-brand brand-gradient fw-bold" href="{{ route('front.series.index') }}">
      Max Flex
    </a>

    {{-- Toggler --}}
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
            aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    {{-- Collapse --}}
    <div class="collapse navbar-collapse" id="mainNav">
      {{-- Left: primary links --}}
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('front.series.*') ? 'active' : '' }}"
             href="{{ route('front.series.index') }}">Home</a>
        </li>

        @auth
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('favorites.*') ? 'active' : '' }}"
               href="{{ route('favorites.index') }}">My Favorites</a>
          </li>
        @endauth
      </ul>

      {{-- Middle: quick search (md+) --}}
      <form class="d-none d-md-flex me-lg-3" action="{{ route('front.series.index') }}" method="GET" role="search">
        <div class="input-group">
          <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
          <input type="text" name="q" value="{{ request('q') }}" class="form-control border-start-0"
                 placeholder="Search series...">
        </div>
      </form>

      {{-- Right: actions --}}
      <ul class="navbar-nav ms-auto align-items-lg-center">
        @auth
          @php
            $role   = auth()->user()->role;
            $name   = auth()->user()->name;
            $ini    = strtoupper(mb_substr($name,0,1));
            $unread = isset($unreadCount) ? $unreadCount : auth()->user()->unreadNotifications()->count();
            $latest = isset($headerNotifications) ? $headerNotifications : auth()->user()->notifications()->latest()->limit(5)->get();
          @endphp

          {{-- Dashboard --}}
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
               href="{{ route('dashboard') }}">Dashboard</a>
          </li>

          {{-- Notifications dropdown --}}
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle position-relative {{ request()->routeIs('notifications.*') ? 'active' : '' }}"
               href="#" id="notifMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="{{ $unread ? 'notif-pulse' : '' }}"><i class="bi bi-bell"></i></span>
              @if($unread)<span class="badge bg-danger ms-1">{{ $unread }}</span>@endif
            </a>
            <div class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="notifMenu" style="min-width: 340px;">
              <div class="border-bottom px-3 py-2 d-flex justify-content-between align-items-center">
                <strong>Notifications</strong>
                <form method="POST" action="{{ route('notifications.readAll') }}">@csrf
                  <button class="btn btn-link btn-sm p-0">Mark all as read</button>
                </form>
              </div>

              @forelse($latest as $n)
                @php $data = $n->data; $type = $data['type'] ?? 'info'; @endphp
                <div class="dropdown-item d-flex align-items-start gap-2" style="white-space: normal;">
                  <div class="pt-1">
                    @if($type === 'series') <i class="bi bi-collection-play"></i>
                    @elseif($type === 'episode') <i class="bi bi-film"></i>
                    @else <i class="bi bi-bell"></i> @endif
                  </div>
                  <div class="flex-fill">
                    <div class="d-flex justify-content-between">
                      <div class="fw-semibold">
                        @if($type === 'series')
                          New series: {{ $data['title'] ?? 'Untitled' }}
                        @elseif($type === 'episode')
                          New episode: {{ $data['title'] ?? 'Untitled' }}
                        @else
                          Notification
                        @endif
                        @if(is_null($n->read_at)) <span class="badge bg-primary ms-1">new</span> @endif
                      </div>
                      <div class="small text-muted">{{ $n->created_at->diffForHumans() }}</div>
                    </div>

                    <div class="mt-1 d-flex gap-2 flex-wrap">
                      @if($type === 'series' && isset($data['id']))
                        <a class="btn btn-sm btn-outline-dark" href="{{ route('front.series.show', $data['id']) }}">View</a>
                      @elseif($type === 'episode')
                        @if(isset($data['video_url']))
                          <a class="btn btn-sm btn-outline-dark" target="_blank" href="{{ $data['video_url'] }}">Watch</a>
                        @endif
                        @if(isset($data['series_id']))
                          <a class="btn btn-sm btn-outline-secondary" href="{{ route('front.series.show', $data['series_id']) }}">Series</a>
                        @endif
                      @endif

                      @if(is_null($n->read_at))
                        <form method="POST" action="{{ route('notifications.readOne', $n->id) }}">@csrf
                          <button class="btn btn-sm btn-link p-0">Mark as read</button>
                        </form>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="dropdown-divider m-0"></div>
              @empty
                <div class="px-3 py-3 small text-muted">No notifications yet.</div>
              @endforelse

              <div class="px-3 py-2">
                <a class="btn btn-outline-dark w-100 btn-sm" href="{{ route('notifications.index') }}">View all</a>
              </div>
            </div>
          </li>

          {{-- Admin / Employee --}}
          @if($role === 'admin')
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.series.*') || request()->routeIs('admin.categories.*') || request()->routeIs('admin.episodes.*') ? 'active' : '' }}"
                 href="#" id="adminMenu" role="button" data-bs-toggle="dropdown">Admin</a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminMenu">
                <li><a class="dropdown-item" href="{{ route('admin.series.index') }}">Manage Series</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.episodes.index') }}">Manage Episodes</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}">Manage Categories</a></li>
              </ul>
            </li>
          @elseif($role === 'employee')
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('admin.episodes.*') ? 'active' : '' }}"
                 href="{{ route('admin.episodes.index') }}">Manage Episodes</a>
            </li>
          @endif

          {{-- Profile dropdown --}}
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="d-inline-flex justify-content-center align-items-center rounded-circle"
                    style="width:28px;height:28px;background:#eef2ff;color:#3730a3;font-weight:700;">
                {{ $ini }}
              </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
              <li class="px-3 py-2 small text-muted">Hi, {{ $name }}</li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
              <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
              <li>
                <form method="POST" action="{{ route('logout') }}" class="px-3 mt-1">@csrf
                  <button class="btn btn-outline-danger btn-sm w-100">Logout</button>
                </form>
              </li>
            </ul>
          </li>
        @endauth

        @guest
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a></li>
          <li class="nav-item"><a class="btn btn-primary btn-sm ms-lg-2" href="{{ route('register') }}">Register</a></li>
        @endguest
      </ul>

      {{-- Mobile search (sm only) --}}
      <form class="d-md-none mt-2" action="{{ route('front.series.index') }}" method="GET" role="search">
        <div class="input-group">
          <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
          <input type="text" name="q" value="{{ request('q') }}" class="form-control border-start-0"
                 placeholder="Search series...">
        </div>
      </form>
    </div>
  </div>
</nav>
