<x-core.views::layouts.app>
    <x-slot name="sidebar">
        <x-layouts.navbars.auth.sidebar moduleName="access">
            <x-access.views::layouts.navbars.auth.sidebar-links />
        </x-layouts.navbars.auth.sidebar>
    </x-slot>

    <livewire:access.livewire.access-controls.access-control />

</x-core.views::layouts.app>
