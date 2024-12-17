
<x-core.views::layouts.app>
    <x-slot name="sidebar">
        <x-layouts.navbars.auth.sidebar moduleName="production">
            <x-production.views::layouts.navbars.auth.sidebar-links />
        </x-layouts.navbars.auth.sidebar>
    </x-slot>

    <x-slot name="pageHeader">
        @include('core.views::components.layouts.navbars.auth.content-header', [ "pageTitile" => "Manage Production Orders"])
    </x-slot>

    <x-core.views::tab-bar>
        <x-production.views::layouts.navbars.auth.production-order-tab-bar-links active='resource'  />
    </x-core.views::tab-bar>

    <livewire:core.livewire.data-tables.data-table-manager model="App\\Modules\\Production\\Models\\ProductionOrderItem"
        pageTitle="Manage Item  Categories"
        queryFilters=[]
        :hiddenFields="[
            'onTable' => [],
        ]"
        :queryFilters="[]"
    />

    <x-slot name="pageFooter">
        @include('core.views::components.layouts.navbars.auth.content-footer', [ ])
    </x-slot>
</x-core.views::layouts.app>


