<?php

return [


        "model"=>"App\\Modules\\Inventory\\Models\\Item",
        "fieldDefinitions"=>[

            'image' => 'file',
            'name' => [ 'field_type' => 'text', 'validation' => 'required|string'],
            'description' =>'textarea',

            'unit_id' => [
                'field_type' => 'select',
                'options' => app('App\Modules\Inventory\Models\Unit')->optionList('symbol'),
                'relationship' => [
                    'model' => 'App\Modules\Inventory\Models\Unit',
                    'type' => 'belongsTo',
                    'display_field' => 'display_name',
                    'dynamic_property' => 'unit',
                    'foreign_key' => 'unit_id',
                    'inlineAdd' => true,
                ],
                'label' => 'Units',
                'validation' => 'required',
                'display' => 'block',
                'multiSelect' => false,
            ],


            'categories' => [
                'field_type' => 'checkbox',
                'options' => App\Modules\Inventory\Models\Category::pluck('display_name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\Inventory\Models\Category',
                    'type' => 'belongsToMany',
                    'display_field' => 'display_name',
                    'multiSelect' => true,
                    'dynamic_property' => 'categories',
                    'foreign_key' => 'category_id',
                    'inlineAdd' => true,

                ],
                'label' => 'Categories',
                'display' => 'inline',
                'multiSelect' => true,
            ],



            'tags' => [
                'field_type' => 'checkbox',
                'options' => App\Modules\Inventory\Models\Tag::pluck('display_name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\Inventory\Models\Tag',
                    'type' => 'belongsToMany',
                    'display_field' => 'display_name',
                    'dynamic_property' => 'tags',
                    'multiSelect' => true,
                    'foreign_key' => 'tag_id',
                    'inlineAdd' => true,
                ],
                'label' => 'Tags',
                'display' => 'block',
                'multiSelect' => true,
            ],

            'item_type_id' => [
                'field_type' => 'select',
                'options' => App\Modules\Inventory\Models\ItemType::pluck('display_name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\Inventory\Models\ItemType',
                    'type' => 'belongsTo',
                    'display_field' => 'display_name',
                    'dynamic_property' => 'itemType',
                    'foreign_key' => 'item_type_id',
                    'inlineAdd' => true,
                ],
                'label' => 'Item Type',
                'validation' => 'required',
                'display' => 'block',
                'multiSelect' => false,
            ],

            'status_id' => [
                'field_type' => 'select',
                'options' => App\Modules\Core\Models\Status::pluck('display_name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\Core\Models\Status',
                    'type' => 'belongsTo',
                    'display_field' => 'display_name',
                    'dynamic_property' => 'status',
                    'foreign_key' => 'status_id',
                    'inlineAdd' => true,
                ],
                'label' => 'Status',
                'validation' => 'required',
                'display' => 'block',
                'multiSelect' => false,
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
