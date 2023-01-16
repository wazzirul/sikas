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
      <div class="nav-item">
        <div class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);">
          <div class="avatar avatar-online">
            <div class="avatar-image">
              <div class="avatar-wrap">
                <p class="color-white">{{ Session::get('nama')[0] }}</p>
              </div>
            </div>
            <div class="avatar-content">
              <p class="text-primary">Selamat Datang</p>
              <p class="text-black text-bold">{{ Session::get('nama') }}</p>
            </div>
          </div>
        </div>
      </div>
      <!--/ User -->
    </div>
  </div>
</header>
<!--/ Header-->
