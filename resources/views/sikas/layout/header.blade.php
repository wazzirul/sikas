<!-- Header -->
<header class="header content-header">
  <div class="container">
    <div class="header-wrapper">
      <div class="header-logo">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0  d-xl-none ">
          <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
          </a>
        </div>
        <h2 class="text-primary text-bold">
          @yield('current-pages-title')
        </h2>
      </div>
      <!-- User -->
      <div class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
          <div class="avatar avatar-online">
            <div class="avatar-image">
              <div class="avatar-wrap">
                <p class="color-white">L</p>
              </div>
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
                    <div class="avatar-image">
                      <div class="avatar-wrap">
                        <p class="color-white">L</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="flex-grow-1">
                  <span class="fw-semibold d-block">Livityani</span>
                  <small class="text-muted">Admin</small>
                </div>
              </div>
            </a>
          </li>
          <li>
            <div class="dropdown-divider"></div>
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2" href="{{route('sikas-pengaturan')}}">
              <i class="fa-solid fa-gear menu-item__icon"></i>
              <span class="align-middle">Pengaturan</span>
            </a>
          </li>
          <li>
            <div class="dropdown-divider"></div>
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2" href="{{route('sikas-logout')}}">
              <i class="fa-solid fa-right-from-bracket menu-item__icon"></i>
              <span class="align-middle">Logout</span>
            </a>
          </li>
        </ul>
      </div>
      <!--/ User -->
    </div>
  </div>
</header>
<!--/ Header-->
