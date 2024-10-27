<?php

return [


    "model" => "App\\Modules\\Inventory\\Models\\Tag",
    "fieldDefinitions" => [
        'name' => 'text',
        'description' =>'textarea',
        'slug' => 'text',

        'items' => [
            'field_type' => 'checkbox',
            'options' => App\Modules\Inventory\Models\Item::pluck('name', 'id')->toArray(),
            'relationship' => [
                'model' => 'App\Modules\Inventory\Models\Item',
                'type' => 'belongsToMany',
                'display_field' => 'name',
                'dynamic_property' => 'items',
                'foreign_key' => 'item_id'

            ],
            'label' => 'categories',
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
