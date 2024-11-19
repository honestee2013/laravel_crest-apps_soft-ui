<?php

return [


        "model"=>"App\\Modules\\Inventory\\Models\\Item",
        "fieldDefinitions"=>[

            'image' => 'file',
            'name' => [ 'field_type' => 'text', 'validation' => 'required|string'],
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
                'validation' => 'required',
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
                    'multiSelect' => true,
                    'dynamic_property' => 'categories',
                    'foreign_key' => 'category_id',
                    'inlineAdd' => true,

                ],
                'label' => 'categories',
                'display' => 'inline',
                'multiSelect' => true,
            ],



            'tags' => [
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
                'multiSelect' => true,
            ],

            'item_type' => [
                'field_type' => 'select',
                'validation' => 'required|string',
                'options' => [
                    'Resource' => 'Resource',
                    'Finished Product' => 'Finished Product',
                    'Raw Materials' => 'Raw Materials',
                    'Spare Parts' => 'Spare Parts',
                ]
            ],

            'status' => [
                'field_type' => 'select',
                'validation' => 'required|string',
                'options' => [
                    'Available' => 'Available',
                    'Out Of Stock' => 'Out Of Stock',
                    'Discontinued' => 'Discontinued',
                ]
            ],

            'unit_cost_price' => [
                'field_type' => 'number',
                'validation' => 'required|string',
            ],

            'unit_selling_price' => [
                'field_type' => 'number',
                'validation' => 'required|string',
            ],


            'weight' =>'number',
            'dimensions' =>'text',
            'sku' =>'text',
            'barcode' =>'text',
        ],

        "simpleActions"=>['show', 'edit', 'delete'],


        "hiddenFields"=>[
            'onTable' => [
                'sku',
                'barcode',
                'dimensions',
                'weight',
                'description',
                'item_type',
                'status',
                'tags',
                'unit_id',
            ],
        ],

        "controls"=>"all",


];
