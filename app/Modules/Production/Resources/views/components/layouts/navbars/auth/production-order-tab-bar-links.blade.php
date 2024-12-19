

<x-core.views::layouts.navbars.sidebar-link-item
    iconClasses="fas fa-list "
    url="production/production-order-requests"
    title="Requests"
    anchorClasses="{{ ($active == 'request')? 'active': ''}}"
/>


<x-core.views::layouts.navbars.sidebar-link-item
    iconClasses="fas fa-box "
    url="production/production-order-items"
    title="Request Items"
    anchorClasses="{{ ($active == 'items')? 'active': ''}}"
/>

<x-core.views::layouts.navbars.sidebar-link-item
    iconClasses="fas fa-cube "
    url="production/production-order-resources"
    title="Resource Allocations"
    anchorClasses="{{ ($active == 'resource')? 'active': ''}}"
/>



<x-core.views::layouts.navbars.sidebar-link-item
    iconClasses="fas fa-check"
    url="production/production-order-approvals"
    title="Approvals"
    anchorClasses="{{ ($active == 'approval')? 'active': ''}}"
/>











{{--<x-core.views::layouts.navbars.sidebar-link-item
    iconClasses="fas fa-cube "
    url="production/production-order-resources"
    title="Production Items"
    anchorClasses="{{ ($active == 'resource')? 'active': ''}}"
/>
--}}


