<nav class="navbar navbar-expand navbar-dark bg-primary shadow-sm">
  <div class="container-fluid">
    <button class="btn btn-sm btn-outline-light me-2 d-lg-none" id="sidebarToggle">
      <i class="fas fa-bars"></i>
    </button>

    <form action="{{ route('global.search') }}" method="GET" class="d-none d-md-flex ms-3 w-50 search-form">
      <div class="input-group input-group-sm">
        <input type="text" name="query" class="form-control" placeholder="Cari produk, supplier..." aria-label="Search" value="{{ request('query') }}">
        <button class="btn btn-light" type="submit">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </form>

    <div class="navbar-nav ms-auto align-items-center">
      <button class="btn btn-link text-white d-md-none me-2" id="searchToggle">
        <i class="fas fa-search"></i>
      </button>

      <form action="{{ route('global.search') }}" method="GET" class="mobile-search d-none w-100 px-2 py-1 position-absolute start-0 bg-primary">
        <div class="input-group input-group-sm">
          <input type="text" name="query" class="form-control" placeholder="Cari..." value="{{ request('query') }}">
          <button class="btn btn-light" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </form>

      <!-- Notifications Dropdown -->
      <div class="nav-item dropdown me-2">
        <a class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fas fa-bell fs-5"></i>
          @if($notificationCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
              {{ $notificationCount }}
            </span>
          @endif
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-0" style="width: 300px; max-height: 400px; overflow-y: auto;">
          <li class="p-2 border-bottom bg-light">
            <h6 class="mb-0 fw-bold">Notifikasi</h6>
          </li>
          @forelse($notifications as $notif)
            <li>
              <a class="dropdown-item p-3 border-bottom d-flex align-items-start" href="{{ $notif['link'] }}">
                <div class="bg-{{ $notif['color'] }}-subtle text-{{ $notif['color'] }} rounded-circle p-2 me-3">
                  <i class="{{ $notif['icon'] }}"></i>
                </div>
                <div>
                  <div class="fw-bold small">{{ $notif['title'] }}</div>
                  <div class="text-muted small text-wrap">{{ $notif['message'] }}</div>
                </div>
              </a>
            </li>
          @empty
            <li class="p-4 text-center text-muted">
              <i class="fas fa-check-circle fa-2x mb-2 opacity-25"></i>
              <p class="mb-0 small">Tidak ada notifikasi baru</p>
            </li>
          @endforelse
        </ul>
      </div>

      <div class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown"
          aria-expanded="false">
          <div class="user-info">
            <div class="user-avatar overflow-hidden">
              @if(Auth::user()->image)
                <img src="{{ Storage::url(Auth::user()->image) }}" alt="Avatar" width="36" height="36" style="object-fit: cover;">
              @else
                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
              @endif
            </div>
            <div class="user-details d-none d-md-block">
              <span class="user-name">{{ Auth::user()->name }}</span>
              <span class="user-role">{{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}</span>
            </div>
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
          <li class="px-3 py-2 border-bottom">
            <div class="fw-bold">{{ Auth::user()->name }}</div>
            <div class="small text-muted">{{ Auth::user()->email }}</div>
          </li>
          <li>
            <a class="dropdown-item py-2" href="{{ route('profile.index') }}">
              <i class="fas fa-user-circle me-3 text-primary"></i>Profil Saya
            </a>
          </li>
          <li>
            <a class="dropdown-item py-2" href="{{ route('profile.index') }}#password">
              <i class="fas fa-key me-3 text-warning"></i>Ganti Password
            </a>
          </li>
          @if(Auth::user()->role === 'admin')
          <li>
            <a class="dropdown-item py-2" href="{{ route('settings.users.index') }}">
              <i class="fas fa-users-cog me-3 text-info"></i>Manajemen User
            </a>
          </li>
          @endif
          <li><hr class="dropdown-divider"></li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="dropdown-item py-2 text-danger">
                <i class="fas fa-sign-out-alt me-3"></i>Keluar Aplikasi
              </button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<style>
  /* Profile Styles */
  .user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .user-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background-color: rgba(255, 255, 255, 0.2);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1rem;
  }

  .user-details {
    display: flex;
    flex-direction: column;
    text-align: left;
  }

  .user-name {
    font-weight: 500;
    font-size: 0.9rem;
  }

  .user-role {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.8);
  }

  /* Mobile Search Adjustments */
  @media (max-width: 767.98px) {
    .mobile-search {
      top: 100%;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .user-details {
      display: none !important;
    }

    .search-form {
      display: none !important;
    }
  }
</style>

<script>
  // Toggle mobile search
  document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('searchToggle')) {
      document.getElementById('searchToggle').addEventListener('click', function () {
        const mobileSearch = document.querySelector('.mobile-search');
        mobileSearch.classList.toggle('d-none');
        if (!mobileSearch.classList.contains('d-none')) {
            mobileSearch.querySelector('input').focus();
        }
      });
    }
  });
</script>