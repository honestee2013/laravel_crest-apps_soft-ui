<?php

return [


        "model"=>"App\\Modules\\Inventory\\Models\\Item",
        "fieldDefinitions"=>[

            'image' => 'file',
            'name' => 'text',
            'description' =>'textarea',

            'categories' => [
                'field_type' => 'checkbox',
                'options' => App\Modules\Inventory\Models\Category::pluck('name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\Inventory\Models\Category',
                    'type' => 'belongsToMany',
                    'display_field' => 'name',
                    'multiSelect' => true,
                    'dynamic_property' => 'categories',
                    'foreign_key' => 'category_id',
                    'inlineAdd' => true,

                ],
                'label' => 'categories',
                'display' => 'inline',
                'multiSelect' => true,
            ],

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

            'tag_id' => [
                'field_type' => 'checkbox',
                'options' => App\Modules\Inventory\Models\Tag::pluck('name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\Inventory\Models\Tag',
                    'type' => 'belongsToMany',
                    'display_field' => 'name',
                    'dynamic_property' => 'tags',
                    'multiSelect' => true,
                    'foreign_key' => 'tag_id',
                    'inlineAdd' => true,
                ],
                'label' => 'Tags',
                'display' => 'block',
                'multiSelect' => false,
            ],

            'item_type' => [
                'field_type' => 'select',
                'options' => ['Resource', 'Finished Product', 'Raw Materials', 'Spare Parts']
            ],

            'status' => [
                'field_type' => 'select',
                'options' => ['Available', 'Out Of Stock', 'Discontinued']
            ],

            'cost_price' =>'number',
            'selling_price' =>'number',
            'weight' =>'number',
            'dimensions' =>'text',

            'sku' =>'text',
            'barcode' =>'text',
        ],

        "simpleActions"=>['show', 'edit', 'delete'],


        "hiddenFields"=>[
            'onTable' => [],
        ],

        "controls"=>"all",


];
