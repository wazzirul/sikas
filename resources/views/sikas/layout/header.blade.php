<!-- Header -->
<header class="header content-header">
  <div class="container">
    <div class="header-wrapper">
      <div class="header-logo">
        <i class="fa-solid fa-money-bill-wave header-logo__icon"></i>
        <div class="header-logo__content">
          <h2 class="text-primary">Sikas</h2>
          <p>Sistem pembayaran dan kas sekolah</p>
        </div>
      </div>
      <!-- User -->
      <div class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
          <div class="avatar avatar-online">
            <div class="avatar-image">
              <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle">
            </div>
            <div class="avatar-content">
              <p class="text-primary">Selamat Datang</p>
              <p class="text-black text-bold">Livityani</p>
            </div>
            <i class="fa-solid fa-caret-down avatar-down"></i>
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item" href="javascript:void(0);">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                  <div class="avatar avatar-online">
                    <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle">
                  </div>
                </div>
                <div class="flex-grow-1">
                  <span class="fw-semibold d-block">John Doe</span>
                  <small class="text-muted">Admin</small>
                </div>
              </div>
            </a>
          </li>
          <li>
            <div class="dropdown-divider"></div>
          </li>
          <li>
            <a class="dropdown-item" href="javascript:void(0);">
              <i class="bx bx-user me-2"></i>
              <span class="align-middle">My Profile</span>
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="javascript:void(0);">
              <i class='bx bx-cog me-2'></i>
              <span class="align-middle">Settings</span>
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="javascript:void(0);">
              <span class="d-flex align-items-center align-middle">
                <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                <span class="flex-grow-1 align-middle">Billing</span>
                <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
              </span>
            </a>
          </li>
          <li>
            <div class="dropdown-divider"></div>
          </li>
          <li>
            <a class="dropdown-item" href="javascript:void(0);">
              <i class='bx bx-power-off me-2'></i>
              <span class="align-middle">Log Out</span>
            </a>
          </li>
        </ul>
      </div>
      <!--/ User -->
    </div>
  </div>
</header>
<!--/ Header-->
