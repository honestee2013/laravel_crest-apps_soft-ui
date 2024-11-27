<?php

return [

        "model"=>"App\\Modules\\Inventory\\Models\\Unit",
        "fieldDefinitions"=>[
            'name' => [ 'field_type' => 'text', 'validation' => 'required|string'],
            'display_name' => [ 'field_type' => 'text', 'validation' => 'required|string'],

            'symbol' => [ 'field_type' => 'text', 'validation' => 'required|string'],
            'description' =>'textarea',


            'items' => [
                'field_type' => 'select',
                'options' => App\Modules\Inventory\Models\Item::pluck('name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\Inventory\Models\Item',
                    'type' => 'hasMany',
                    'display_field' => 'name',
                    'dynamic_property' => 'items',
                    'foreign_key' => 'unit_id',
                    'inlineAdd' => false,
                ],
                'display' => 'inline',
                'label' => 'Items having this unit',
                'multiSelect' => true,
            ],


        ],
        "simpleActions"=>['show', 'edit', 'delete'],


        "hiddenFields"=>[
            'onTable' => [
                'name'
            ],
        ],

        "controls"=>"all",


];
