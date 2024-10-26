<?php

return [


        "model"=>"App\\Modules\\Inventory\\Models\\Item",
        "fieldDefinitions"=>[
            'name' => 'text',
            'description' =>'textarea',

            'unit_id' => [
                'field_type' => 'select',
                'options' => App\Modules\Inventory\Models\Unit::pluck('name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\Inventory\Models\Unit',
                    'type' => 'belongsTo',
                    'display_field' => 'name',
                    'dynamic_property' => 'unit',
                    'foreign_key' => 'unit_id',
                    'inlineAdd' => true,
                ],
                'label' => 'units',
                'display' => 'block',
                'multiSelect' => false,

            ],



            'categories' => [
                'field_type' => 'checkbox',
                'options' => App\Modules\Inventory\Models\Category::pluck('name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\Inventory\Models\Category',
                    'type' => 'belongsToMany',
                    'display_field' => 'name',
                    'dynamic_property' => 'categories',
                    'foreign_key' => 'category_id',
                    'inlineAdd' => true,

                ],
                'label' => 'categories',
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
