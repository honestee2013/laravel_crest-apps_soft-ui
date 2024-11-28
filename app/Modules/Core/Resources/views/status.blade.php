
<x-core.views::layouts.app>
    <x-slot name="sidebar">
        <x-layouts.navbars.auth.sidebar moduleName="core">
            <x-core.views::layouts.navbars.auth.sidebar-links />
        </x-layouts.navbars.auth.sidebar>
    </x-slot>

    <livewire:core.livewire.data-tables.data-table-manager model="App\\Modules\\Core\\Models\\Status" />

    <x-slot name="pageFooter">
        <x-core.views::layouts.footers.auth.footer />
    </x-slot>
</x-core.views::layouts.app>

