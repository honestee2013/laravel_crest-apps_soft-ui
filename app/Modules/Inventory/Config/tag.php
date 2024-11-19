<?php

return [


    "model" => "App\\Modules\\Inventory\\Models\\Tag",
    "fieldDefinitions" => [
        'name' => [ 'field_type' => 'text', 'validation' => 'required|string'],
        'description' =>'textarea',

        'items' => [
            'field_type' => 'select',
            'options' => App\Modules\Inventory\Models\Item::pluck('name', 'id')->toArray(),
            'relationship' => [
                'model' => 'App\Modules\Inventory\Models\Item',
                'type' => 'belongsToMany',
                'display_field' => 'name',
                'dynamic_property' => 'items',
                'foreign_key' => 'item_id'

            ],
            'label' => 'items assigned',
            'display' => 'inline',
            'multiSelect' => true,

        ],

    ],

    "simpleActions" => ['show', 'edit', 'delete'],


    "hiddenFields" => [
        'onTable' => [],
    ],

    "controls"=>"all",


];
