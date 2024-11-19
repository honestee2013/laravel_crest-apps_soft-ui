<?php

return [

        "model"=>"App\\Modules\\Inventory\\Models\\Storage",
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
                'validation' => 'required|int'
            ],



            'storage_type' => [
                'field_type' => 'select',
                'options' => ["Store" => "Store", "Warehouse" => "Warehouse"],
                'validation' => 'required|string',
            ],

            'opening_hours' =>'time',
            'closing_hours' =>'time',
        ],


        "simpleActions"=>['show', 'edit', 'delete'],


        "hiddenFields"=>[
            'onTable' => [ "description"],
        ],

        "controls"=>"all",


];
