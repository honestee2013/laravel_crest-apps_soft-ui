<?php

return [

        "model"=>"App\\Modules\\Inventory\\Models\\Category",
        "fieldDefinitions"=>[
            'image' => 'file',
            'name' => [ 'field_type' => 'text', 'validation' => 'required|string'],
            'description' =>'textarea',

            'parent_id' => [
                'field_type' => 'select',
                'options' => App\Modules\Inventory\Models\Category::pluck('name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\Inventory\Models\Category',
                    'type' => 'belongsTo',
                    'display_field' => 'name',
                    'dynamic_property' => 'parent',
                    'foreign_key' => 'parent_id',
                ],
                'label' => 'Parent Category',

            ],

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
        "simpleActions"=>['show', 'edit', 'delete'],


        "hiddenFields"=>[
            'onTable' => [],
        ],

        "controls"=>"all",


];
