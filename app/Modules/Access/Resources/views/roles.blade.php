<x-core.views::layouts.app>
    <x-slot name="sidebar">
        <x-layouts.navbars.auth.sidebar moduleName="access">
            <x-access.views::layouts.navbars.auth.sidebar-links />
        </x-layouts.navbars.auth.sidebar>
    </x-slot>
    <livewire:core.livewire.data-tables.data-table-manager model="App\\Modules\\Access\\Models\\Role"
    pageTitle="Manage User Roles"
    queryFilters=[] :hiddenFields="[
            'onTable' => [],
        ]" :queryFilters="[]" />
</x-core.views::layouts.app>
