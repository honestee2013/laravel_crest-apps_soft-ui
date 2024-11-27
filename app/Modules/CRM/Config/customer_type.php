<?php

return [

        "model"=>"App\\Modules\\CRM\\Models\\CustomerType",
        "fieldDefinitions"=>[
            'display_name' => [ 'field_type' => 'text', 'validation' => 'required|string'],
            'name' => [ 'field_type' => 'text', 'validation' => 'required|string'],
            'description' =>'textarea',

        ],

        "simpleActions"=>['show', 'edit', 'delete'],


        "hiddenFields"=>[
            'onTable' => ['name'],
        ],

        "controls"=>"all",


];
