<x-core.views::layouts.app>

    <x-slot name="sidebar">
        <x-layouts.navbars.auth.sidebar moduleName="item">
            <x-item.views::layouts.navbars.auth.sidebar-links />
        </x-layouts.navbars.auth.sidebar>
    </x-slot>
    <livewire:core.livewire.data-tables.data-table-manager model="App\\Modules\\Item\\Models\\Item"
        queryFilters=[] :hiddenFields="[
            'onTable' => [],
        ]" :queryFilters="[]" />
</x-core.views::layouts.app>
