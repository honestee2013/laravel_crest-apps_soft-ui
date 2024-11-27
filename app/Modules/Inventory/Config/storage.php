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



            'storage_type_id' => [
                'field_type' => 'select',
                'options' => App\Modules\Inventory\Models\StorageType::pluck('display_name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\Inventory\Models\StorageType',
                    'type' => 'belongsTo',
                    'display_field' => 'display_name',
                    'dynamic_property' => 'storageType',
                    'foreign_key' => 'storage_type_id',
                    'inlineAdd' => true,
                ],
                'label' => 'Storage Type',
                'validation' => 'required|int'
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
