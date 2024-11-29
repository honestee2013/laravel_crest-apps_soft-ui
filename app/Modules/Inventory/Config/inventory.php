<?php

return [

        "model"=>"App\\Modules\\Inventory\\Models\\Inventory",
        "fieldDefinitions"=>[









            'storage_id' => [
                'field_type' => 'select',
                'options' => App\Modules\Inventory\Models\Storage::pluck('name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\Inventory\Models\Storage',
                    'type' => 'belongsTo',
                    'display_field' => 'name',
                    'dynamic_property' => 'storage',
                    'foreign_key' => 'storage_id',
                    'inlineAdd' => true,
                ],
                'validation' => 'required'
            ],



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
                'readable_id',
            ],
            'onEditForm' => [
                'id',
                'uuid',
                'readable_id',
            ],
        ],


        "simpleActions"=>['show'],



        "controls" => [

            'files' => [
                'export' => ['xls', 'csv', 'pdf'],
                'print',
            ],
            'bulkActions' => [
                'export' => ['xls', 'csv', 'pdf'],
            ],
            'search',
            'showHideColumns',
        ],

];
