
<x-core.views::layouts.app>

    <x-slot name="sidebar">
        <x-layouts.navbars.auth.sidebar moduleName="inventory">
            <x-inventory.views::layouts.navbars.auth.sidebar-links />
        </x-layouts.navbars.auth.sidebar>
    </x-slot>
    <livewire:core.livewire.data-tables.data-table-manager
        model="App\\Modules\\Inventory\\Models\\InventoryTransaction"
        queryFilters=[]
        pageTitle="Items Given Out"
        :hiddenFields="[
            'onTable'=> [

            ],

        ]"

        :queryFilters="[
            ['transaction_type_id.storage_direction', '=', 'OUT']
        ]"
    />
</x-core.views::layouts.app>
