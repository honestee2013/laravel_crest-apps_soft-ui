<div class="sidenav-header">
    <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="{{ route('dashboard') }}">
        <img src="../assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="...">
        <span class="ms-3 font-weight-bold">Soft UI Dashboard Laravel</span>
    </a>
</div>

<hr class="horizontal dark mt-0" />


<x-core.views::layouts.navbars.sidebar-link-item
    iconClasses="fas fa-th-large sidebar-icon"
    url="{{strtolower($moduleName)}}/dashboard"
    title="Dashboard"
/>


