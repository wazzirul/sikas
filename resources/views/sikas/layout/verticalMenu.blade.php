<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  <!-- ! Hide app brand if navbar-full -->
  <div class="app-brand demo">
    <a href="{{url('/')}}" class="app-brand-link">
      <img src="{{asset('assets/img/sikas/logo.png')}}" class="app-brand-logo"></img>
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
        <i class="fa-solid fa-house menu-item__icon"></i>
        <p class="menu-item__text">Dashboard</p>
      </a>
    </li>
    <li class="menu-item {{ Route::is('sikas-transaksi*') == true ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="fa-solid fa-chart-simple menu-item__icon"></i>
        <p class="menu-item__text">Transaksi</p>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ Route::is('sikas-transaksi--pembayaran*') == true ? 'active' : '' }}">
          <a href="{{route('sikas-transaksi--pembayaran')}}" class="menu-link">
            <div>Pembayaran</div>
          </a>
        </li>
        <li class="menu-item {{ Route::is('sikas-transaksi--pemasukan') == true ? 'active' : '' }}">
          <a href="{{route('sikas-transaksi--pemasukan')}}" class="menu-link">
            <div>Pemasukan</div>
          </a>
        </li>
        <li class="menu-item {{ Route::is('sikas-transaksi--pengeluaran') == true ? 'active' : '' }}">
          <a href="{{route('sikas-transaksi--pengeluaran')}}" class="menu-link">
            <div>Pengeluaran</div>
          </a>
        </li>
      </ul> 
    </li>
    <li class="menu-item {{ Route::is('sikas-karyawan') == true ? 'active' : '' }}">
      <a href="{{route('sikas-karyawan')}}" class="menu-link">
        <i class="fa-solid fa-user-tie menu-item__icon"></i>
        <p class="menu-item__text">karyawan</p>
      </a>
    </li>
    <li class="menu-item {{ Route::is('sikas-siswa') == true ? 'active' : '' }}">
      <a href="{{route('sikas-siswa')}}" class="menu-link">
        <i class="fa-solid fa-graduation-cap menu-item__icon"></i>
        <p class="menu-item__text">siswa</p>
      </a>
    </li>
    <li class="menu-item {{ Route::is('sikas-teller') == true ? 'active' : '' }}">
      <a href="{{route('sikas-teller')}}" class="menu-link">
        <i class="fa-solid fa-headset menu-item__icon"></i>
        <p class="menu-item__text">teller</p>
      </a>
    </li>
    <li class="menu-item {{ Route::is('sikas-laporan*') == true ? 'active' : '' }}">
      <a href="{{route('sikas-laporan')}}" class="menu-link">
        <i class="fa-regular fa-file-lines menu-item__icon"></i>
        <p class="menu-item__text">laporan</p>
      </a>
    </li>
    <li class="menu-item {{ Route::is('sikas-jenis-pembayaran') == true ? 'active' : '' }}">
      <a href="{{route('sikas-jenis-pembayaran')}}" class="menu-link">
        <i class="fa-solid fa-cash-register menu-item__icon"></i>
        <p class="menu-item__text">Jenis Pembayaran</p>
      </a>
    </li>
    <li class="menu-item {{ Route::is('sikas-master-jabatan') == true ? 'active' : '' }}">
      <a href="{{route('sikas-master-jabatan')}}" class="menu-link">
        <i class="fa-solid fa-users menu-item__icon"></i>
        <p class="menu-item__text">Master Jabatan</p>
      </a>
    </li>
    <li class="menu-item">
      <a href="{{route('sikas-reset-tahun-ajar')}}" class="menu-link">
        <i class="fa-solid fa-power-off menu-item__icon"></i>
        <div>Reset Tahun Ajar</div>
      </a>
    </li>
    <div class="menu-line my-4"></div>
    <li class="menu-item {{ Route::is('sikas-pengaturan') == true ? 'active' : '' }}">
      <a href="{{route('sikas-pengaturan')}}" class="menu-link">
        <i class="fa-solid fa-gear menu-item__icon"></i>
        <p class="menu-item__text">pengaturan</p>
      </a>
    </li>
    <!--Logout OF MENU SIDEBAR (LAST ITEM)-->
    <li class="menu-item">
      <a href="{{route('sikas-logout')}}" class="menu-link">
        <i class="fa-solid fa-right-from-bracket menu-item__icon"></i>
        <div>Logout</div>
      </a>
    </li>
    <!--END OF MENU SIDEBAR-->
  </ul>
</aside>
