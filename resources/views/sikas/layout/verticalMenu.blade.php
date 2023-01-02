<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  <!-- ! Hide app brand if navbar-full -->
  <div class="app-brand demo">
    <a href="{{url('/')}}" class="app-brand-link">
      <i class="fa-solid fa-money-bill-wave app-brand-link__icon"></i>
      <h3 class="text-primary">SIKAS</h3>
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-autod-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <!--START OF MENU SIDEBAR-->
  <ul class="menu-inner py-1">
    <li class="menu-item {{ Route::is('sikas-dashboard') == true ? 'active' : '' }}">
      <a href="{{route('sikas-dashboard')}}" class="menu-link">
        <img class="menu-item__icon" src="{{asset('assets/img/icons/home.svg')}}" alt="">
        <p class="menu-item__text">Dashboard</p>
      </a>
    </li>
    <li class="menu-item {{ Route::is('sikas-transaksi*') == true ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="fa-solid fa-money-bill-transfer menu-item__icon"></i>
        <p class="menu-item__text">Transaksi</p>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ Route::is('sikas-transaksi--pembayaran') == true ? 'active' : '' }}">
          <a href="{{route('sikas-transaksi--pembayaran')}}" class="menu-link">
            <i class="fa-solid fa-cash-register menu-item__icon"></i>
            <div>Pembayaran</div>
          </a>
        </li>
        <li class="menu-item {{ Route::is('sikas-transaksi--tabungan') == true ? 'active' : '' }}">
          <a href="{{route('sikas-transaksi--tabungan')}}" class="menu-link">
            <i class="fa-solid fa-piggy-bank menu-item__icon"></i>
            <div>Tabungan</div>
          </a>
        </li>
      </ul> 
    </li>
    <li class="menu-item {{ Route::is('sikas-laporan') == true ? 'active' : '' }}">
      <a href="{{route('sikas-laporan')}}" class="menu-link">
        <i class="fa-solid fa-file-lines menu-item__icon"></i>
        <p class="menu-item__text">laporan</p>
      </a>
    </li>
    <li class="menu-item {{ Route::is('sikas-pengguna') == true ? 'active' : '' }}">
      <a href="{{route('sikas-pengguna')}}" class="menu-link">
        <i class="fa-solid fa-user-group menu-item__icon"></i>
        <p class="menu-item__text">pengguna</p>
      </a>
    </li>
    <li class="menu-item {{ Route::is('sikas-pengaturan') == true ? 'active' : '' }}">
      <a href="{{route('sikas-pengaturan')}}" class="menu-link">
        <i class="fa-solid fa-gear menu-item__icon"></i>
        <p class="menu-item__text">pengaturan</p>
      </a>
    </li>

    <!--Logout OF MENU SIDEBAR (LAST ITEM)-->
    <li class="menu-item mt-auto mb-3">
      <a href="{{url('/login')}}" class="menu-link">
        <img src="{{asset('assets/img/icons/power-off.png')}}" alt="">
        <div>Logout</div>
      </a>
    </li>
    <!--END OF MENU SIDEBAR-->
  </ul>
</aside>
