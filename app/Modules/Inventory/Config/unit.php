<?php

return [

        "model"=>"App\\Modules\\Inventory\\Models\\Unit",
        "fieldDefinitions"=>[
            'name' => 'text',
            'symbol' =>'text',
            'description' =>'textarea',




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
