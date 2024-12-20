<?php

return [

        "model"=>"App\\Modules\\Storage\\Models\\StorageType",
        "fieldDefinitions"=>[
            'name' => [ 'field_type' => 'text', 'validation' => 'required|string'],
            'display_name' => [ 'field_type' => 'text', 'validation' => 'required|string'],

            'description' =>'textarea',

        ],


        "simpleActions"=>['show', 'edit', 'delete'],


        "hiddenFields"=>[
            'onTable' => [ "name"],
        ],

        "controls"=>"all",


];
