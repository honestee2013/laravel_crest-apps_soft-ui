<?php

return [

        "model"=>"App\\Modules\\Procurement\\Models\\SupplierType",
        "fieldDefinitions"=>[
            'display_name' => ['field_type' => 'text', 'validation' => 'required|string'],
            'name' => ['field_type' => 'text', 'validation' => 'required|string'],
            'description' => ['field_type' => 'textarea'],

        ],

        "hiddenFields"=>[
            'onTable' => [
                'name'
            ],
            'onNewForm' => [
            ],
            'onEditForm' => [
            ],
        ],


        "simpleActions"=>['show', 'edit', 'delete'],

        "controls"=>"all",


];
