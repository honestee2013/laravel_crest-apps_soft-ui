<?php

return [

        "model"=>"App\\Modules\\CRM\\Models\\Customer",
        "fieldDefinitions"=>[
            'image' => 'file',
            'name' => [ 'field_type' => 'text', 'validation' => 'required|string'],
            'address' =>'textarea',

            'email' => [ 'field_type' => 'email', 'validation' => 'required|string'],
            'phone' => [ 'field_type' => 'tel', 'validation' => 'required|string'],

            'city' => [ 'field_type' => 'text', 'validation' => 'required|string'],
            'state' => [ 'field_type' => 'text', 'validation' => 'required|string'],
            'zip_code' => [ 'field_type' => 'text', 'validation' => 'required|string'],
            'country' => [ 'field_type' => 'text', 'validation' => 'required|string'],
            'contact_person' => [ 'field_type' => 'text', 'validation' => 'required|string'],

            'customer_type_id' => [
                'field_type' => 'select',
                'options' => App\Modules\CRM\Models\CustomerType::pluck('display_name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\CRM\Models\CustomerType',
                    'type' => 'belongsTo',
                    'display_field' => 'display_name',
                    'dynamic_property' => 'customerType',
                    'foreign_key' => 'customer_type_id',
                    'inlineAdd' => true,

                ],
                'label' => 'Customer Type',
                'display' => 'inline',
            ],








        ],

        "simpleActions"=>['show', 'edit', 'delete'],


        "hiddenFields"=>[
            'onTable' => [],
        ],

        "controls"=>"all",


];
