<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  <!-- ! Hide app brand if navbar-full -->
  <div class="app-brand demo">
    <a href="{{url('/')}}" class="app-brand-link d-flex align-items-start justify-content-start flex-column gap-3">
      <img src="{{asset('assets/img/sikas/logo-sikas.png')}}" class="app-brand-logo"></img>
      <p class="color-neutral-80">Sistem pembayaran dan kas sekolah</p>
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
        <li class="menu-item {{ Route::is('sikas-transaksi--biaya-penunjang-pendidikan*') == true ? 'active' : '' }}" id="sidebar-bpp">
          <a href="{{route('sikas-transaksi--biaya-penunjang-pendidikan')}}" class="menu-link">
            <div>Biaya Penunjang Pendidikan</div>
          </a>
        </li>
        <li class="menu-item {{ Route::is('sikas-transaksi--tabungan*') == true ? 'active' : '' }}">
          <a href="{{route('sikas-transaksi--tabungan')}}" class="menu-link">
            <div>Tabungan</div>
          </a>
        </li>
        <li class="menu-item {{ Route::is('sikas-transaksi--bpp-alumni*') == true ? 'active' : '' }}" id="sidebar-bpp">
          <a href="{{route('sikas-transaksi--bpp-alumni')}}" class="menu-link">
            <div>BPP Alumni</div>
          </a>
        </li>
        <li class="menu-item {{ Route::is('sikas-transaksi--pengeluaran') == true ? 'active' : '' }}">
          <a href="{{route('sikas-transaksi--pengeluaran')}}" class="menu-link">
            <div>Pengeluaran</div>
          </a>
        </li>
      </ul> 
    </li>

    @if(Session::get('tipe_user') == 1)
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
    @endif
    
    <li class="menu-item {{ Route::is('sikas-laporan*') == true ? 'active' : '' }}">
      <a href="{{route('sikas-laporan')}}" class="menu-link">
        <i class="fa-regular fa-file-lines menu-item__icon"></i>
        <p class="menu-item__text">laporan</p>
      </a>
    </li>

    @if(Session::get('tipe_user') == 1)
    <li class="menu-item {{ Route::is('sikas-jenis-pembayaran') == true ? 'active' : '' }}">
      <a href="{{route('sikas-jenis-pembayaran')}}" class="menu-link">
        <i class="fa-solid fa-cash-register menu-item__icon"></i>
        <p class="menu-item__text">Jenis Transaksi</p>
      </a>
    </li>
    <li class="menu-item {{ Route::is('sikas-master-jabatan') == true ? 'active' : '' }}">
      <a href="{{route('sikas-master-jabatan')}}" class="menu-link">
        <i class="fa-solid fa-users menu-item__icon"></i>
        <p class="menu-item__text">Master Jabatan</p>
      </a>
    </li>
    <li class="menu-item {{ Route::is('sikas-master-jurusan') == true ? 'active' : '' }}">
      <a href="{{route('sikas-master-jurusan')}}" class="menu-link">
        <i class="fa-regular fa-address-book menu-item__icon"></i>
        <p class="menu-item__text">Master Jurusan</p>
      </a>
    </li>
    <li class="menu-item">
      <a href="{{route('sikas-reset-tahun-ajar')}}" class="menu-link">
        <i class="fa-solid fa-power-off menu-item__icon"></i>
        <div>Reset Tahun Ajar</div>
      </a>
    </li>
    @endif
    <div class="menu-line my-4">
      <div class="line"></div>
    </div>
    @if(Session::get('tipe_user') == 1)
    <li class="menu-item {{ Route::is('sikas-pengaturan') == true ? 'active' : '' }}">
      <a href="{{route('sikas-pengaturan')}}" class="menu-link">
        <i class="fa-solid fa-gear menu-item__icon"></i>
        <p class="menu-item__text">pengaturan</p>
      </a>
    </li>
    @endif

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
