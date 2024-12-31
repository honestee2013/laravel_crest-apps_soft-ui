

<x-core.views::layouts.navbars.sidebar-link-item
    iconClasses="fas fa-list "
    url="production/production-logs"
    title="Production Logs"
    anchorClasses="{{ ($active == 'production-logs')? 'active': ''}}"
/>


<x-core.views::layouts.navbars.sidebar-link-item
    iconClasses="fas fa-box "
    url="production/production-log-inputs"
    title="Production Log Inputs"
    anchorClasses="{{ ($active == 'production-log-inputs')? 'active': ''}}"
/>


<x-core.views::layouts.navbars.sidebar-link-item
    iconClasses="fas fa-box "
    url="production/production-log-outputs"
    title="Production Log Outputs"
    anchorClasses="{{ ($active == 'production-log-outputs')? 'active': ''}}"
/>



<x-core.views::layouts.navbars.sidebar-link-item
    iconClasses="fas fa-box "
    url="production/production-log-downtimes"
    title="Production Log Downtimes"
    anchorClasses="{{ ($active == 'production-log-downtimes')? 'active': ''}}"
/>












{{--<x-core.views::layouts.navbars.sidebar-link-item
    iconClasses="fas fa-cube "
    url="production/production-order-resources"
    title="Production Items"
    anchorClasses="{{ ($active == 'resource')? 'active': ''}}"
/>
--}}


