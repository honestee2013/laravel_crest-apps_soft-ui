
<x-core.views::layouts.app>
    <x-slot name="sidebar">
        <x-layouts.navbars.auth.sidebar moduleName="production">
            <x-production.views::layouts.navbars.auth.sidebar-links />
        </x-layouts.navbars.auth.sidebar>
    </x-slot>

    <x-slot name="pageHeader">
        @include('core.views::components.layouts.navbars.auth.content-header', [ "pageTitile" => "Production Order Management"])
    </x-slot>

    <x-core.views::tab-bar>
        <x-production.views::layouts.navbars.auth.production-order-batches-tab-bar-links active='inputs'  />
    </x-core.views::tab-bar>

    <livewire:core.livewire.data-tables.data-table-manager model="App\\Modules\\Production\\Models\\ProductionBatchInput"
        pageTitle="Production Batch Resource Allocations"
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



