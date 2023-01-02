<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  <!-- ! Hide app brand if navbar-full -->
  <div class="app-brand demo">
    <a href="{{url('/')}}" class="app-brand-link">
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
        <img src="{{asset('assets/img/icons/home.svg')}}" alt="">
        <div>Dashboard</div>
      </a>
    </li>

    <!--Logout OF MENU SIDEBAR (LAST ITEM)-->
    <li class="menu-item mt-auto mb-3">
      <a href="{{url('/logout')}}" class="menu-link">
        <img src="{{asset('assets/img/icons/power-off.png')}}" alt="">
        <div>Logout</div>
      </a>
    </li>
    <!--END OF MENU SIDEBAR-->
  </ul>
</aside>
