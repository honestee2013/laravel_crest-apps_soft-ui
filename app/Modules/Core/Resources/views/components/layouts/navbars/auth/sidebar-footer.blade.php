
<li class="nav-item mt-4">
    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Security</h6>
</li>



<x-core.views::layouts.navbars.sidebar-link-item
    iconClasses="fas fa-user-lock sidebar-icon"
    url="/access/?module={{$moduleName}}"
    title="Control User Access"
/>



<li class="nav-item mt-4">
    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Configurations</h6>
</li>

<x-core.views::layouts.navbars.sidebar-link-item
    iconClasses="fas fa-tools sidebar-icon"
    url="{{strtolower($moduleName)}}/setup"
    title="Setup"
/>

<x-core.views::layouts.navbars.sidebar-link-item
    iconClasses="fas fa-wrench sidebar-icon"
    url="{{strtolower($moduleName)}}/settings"
    title="Settings"
/>

<x-core.views::layouts.navbars.sidebar-link-item
    iconClasses="fas fa-gear sidebar-icon"
    url="{{strtolower($moduleName)}}/advance"
    title="Advance"
/>
