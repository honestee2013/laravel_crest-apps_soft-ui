<?php

return [


    "model" => "App\\Modules\\Item\\Models\\Tag",
    "fieldDefinitions" => [
        'display_name' => [ 'field_type' => 'text', 'validation' => 'required|string'],
        'name' => [ 'field_type' => 'text', 'validation' => 'required|string'],
        'description' =>'textarea',

        'items' => [
            'field_type' => 'select',
            'options' => App\Modules\Item\Models\Item::pluck('name', 'id')->toArray(),
            'relationship' => [
                'model' => 'App\Modules\Item\Models\Item',
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
        'onTable' => [
            'name'
        ],
    ],

    "controls"=>"all",


];
