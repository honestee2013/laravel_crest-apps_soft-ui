<x-core.views::layouts.app>
    <x-slot name="sidebar">
        <x-layouts.navbars.auth.sidebar moduleName="production">
            <x-production.views::layouts.navbars.auth.sidebar-links />
        </x-layouts.navbars.auth.sidebar>
    </x-slot>
    <livewire:core.livewire.data-tables.data-table-manager model="App\\Modules\\Production\\Models\\ProductionOrder"
    pageTitle="Manage Production Orders"
    queryFilters=[] :hiddenFields="[
            'onTable' => [],
        ]" :queryFilters="[]" />
</x-core.views::layouts.app>
