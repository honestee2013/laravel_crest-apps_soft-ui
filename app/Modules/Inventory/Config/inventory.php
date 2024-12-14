<?php

return [

        "model"=>"App\\Modules\\Inventory\\Models\\Inventory",
        "fieldDefinitions"=>[



            'storage_id' => [
                'field_type' => 'select',
                'options' => App\Modules\Storage\Models\Storage::pluck('name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\Storage\Models\Storage',
                    'type' => 'belongsTo',
                    'display_field' => 'name',
                    'dynamic_property' => 'storage',
                    'foreign_key' => 'storage_id',
                    'inlineAdd' => true,
                ],
                'validation' => 'required',
                'label' => 'Storage',

            ],

            'storage_location' => [ 'field_type' => 'text'],




            'item_id' => [
                'field_type' => 'select',
                'options' => App\Modules\Item\Models\Item::pluck('name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\Item\Models\Item',
                    'type' => 'belongsTo',
                    'display_field' => 'name',
                    'dynamic_property' => 'item',
                    'foreign_key' => 'item_id',
                    'inlineAdd' => true,
                ],
                'label' => 'Item',
                'validation' => 'required'
            ],
            'available_quantity_unit' => [ 'field_type' => 'text', 'validation' => 'required|integer'],






        ],



        "hiddenFields"=>[
            'onTable' => [
                'uuid'
            ],
            'onNewForm' => [
                'id',
                'uuid',
                'transaction_id',
            ],
            'onEditForm' => [
                'id',
                'uuid',
                'transaction_id',
            ],

            'onQuery' => [
                'storage_location',
                'available_quantity_unit'
            ],
        ],


        "simpleActions"=>['show'],



        "controls" => [

            'files' => [
                'export' => ['xls', 'csv', 'pdf'],
                'print',
            ],
            'perPage' => [5, 10, 25, 50, 100, 200, 500],

            'bulkActions' => [
                'export' => ['xls', 'csv', 'pdf'],
            ],
            'search',
            'showHideColumns',
        ],

];
