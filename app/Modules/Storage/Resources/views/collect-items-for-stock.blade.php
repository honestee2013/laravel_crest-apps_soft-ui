
<x-core.views::layouts.app>

    <x-slot name="sidebar">
        <x-layouts.navbars.auth.sidebar moduleName="storage">
            <x-storage.views::layouts.navbars.auth.sidebar-links />
        </x-layouts.navbars.auth.sidebar>
    </x-slot>
    <livewire:core.livewire.data-tables.data-table-manager
        model="App\\Modules\\Storage\\Models\\CollectItem"
        queryFilters=[]
        pageTitle="Collected Items Overview"
        :hiddenFields="[
            'onTable'=> [

            ],

        ]"

        :queryFilters="[
            ['transaction_type_id.storage_direction', '=', 'IN']
        ]"
    />
</x-core.views::layouts.app>

