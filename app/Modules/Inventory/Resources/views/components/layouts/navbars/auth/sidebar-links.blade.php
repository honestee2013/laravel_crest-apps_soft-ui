

<li class="nav-inventory mt-4">
    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Inventory Management</h6>
</li>


<x-core.views::layouts.navbars.sidebar-link-item
    iconClasses="fas fa-cubes sidebar-icon"
    url="inventory/inventories"
    title="Inventory Overview"
/>

<x-core.views::layouts.navbars.sidebar-link-item
    iconClasses="fas fa-exchange-alt sidebar-icon"
    url="inventory/inventory-transactions"
    title="Manage Transactions"
/>


<x-core.views::layouts.navbars.sidebar-link-item
    iconClasses="fas fa-sync-alt sidebar-icon"
    url="inventory/inventory-adjustments"
    title="Adjust Transactions"
/>

<x-core.views::layouts.navbars.sidebar-link-item
    iconClasses="fas fa-stream sidebar-icon"
    url="inventory/transaction-types"
    title="Manage Transaction Types"
/>



