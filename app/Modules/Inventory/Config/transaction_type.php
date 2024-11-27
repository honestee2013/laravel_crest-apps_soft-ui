<?php

return [

        "model"=>"App\\Modules\\Inventory\\Models\\Unit",
        "fieldDefinitions"=>[
            'name' => [ 'field_type' => 'text', 'validation' => 'required|string'],
            'display_name' => [ 'field_type' => 'text', 'validation' => 'required|string'],
            'description' =>'textarea',

            'storage_direction' => [
                'field_type' => 'radio',

                'options' => ['IN' => 'IN', 'OUT' => 'OUT'],

                'validation' => 'required',
                'display' => 'block',
            ],




        ],
        "simpleActions"=>['show', 'edit', 'delete'],


        "hiddenFields"=>[
            'onTable' => [
                'name'
            ],
        ],

        "controls"=>"all",


];
