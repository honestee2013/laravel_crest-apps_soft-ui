<?php

return [

        "model"=>"App\\Modules\\Inventory\\Models\\Warehouse",
        "fieldDefinitions"=>[
            'name' => [ 'field_type' => 'text', 'validation' => 'required|string'],
            'description' =>'textarea',


            'location_id' => [
                'field_type' => 'select',
                'options' => App\Modules\Enterprise\Models\Location::pluck('name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\Enterprise\Models\Location',
                    'type' => 'belongsTo',
                    'display_field' => 'name',
                    'dynamic_property' => 'location',
                    'foreign_key' => 'location_id',
                    'inlineAdd' => true,
                ],
                'label' => 'Location',
                'validation' => 'required|string'
            ],


        ],
        "simpleActions"=>['show', 'edit', 'delete'],


        "hiddenFields"=>[
            'onTable' => [],
        ],

        "controls"=>"all",


];
