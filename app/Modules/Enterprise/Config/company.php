<?php

return [

        "model"=>"App\\Modules\\Enterprise\\Models\\Company",
        "fieldDefinitions"=>[
            'logo' => 'file',
            'name' => [ 'field_type' => 'text', 'validation' => 'required|string'],
            'description' =>'textarea',

            'location' => [
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

                'validation' => 'required|string'
            ],

            'phone' => [ 'field_type' => 'tel', 'validation' => 'required|string'],
            'email' => 'email',
            'website' => 'website',
            'address' => 'textarea',
            'postal_code' => 'number',
            'status' => [
                'field_type' => 'select',
                'options' => ['Active' => 'Active', 'Inactive' => 'Inactive', 'Dissolved' => 'Dissolved'],
                'validation' => 'required|string'
            ],
            'date_established' => 'date',
        ],


        "simpleActions"=>['show', 'edit', 'delete'],

        "hiddenFields"=>[
            'onTable' => [
                'description',
                'email',
                'website',
                'address',
                'postal_code',
                'date_established'
            ],
        ],

        "controls"=>"all",

];
