<?php

return [

        "model"=>"App\\Modules\\Enterprise\\Models\\Location",
        "fieldDefinitions"=>[
            'name' => [
                'field_type' => 'text',
                'validation' => 'required|string'
            ],
            'description' =>'textarea',
        ],
        "simpleActions"=>['show', 'edit', 'delete'],


        "hiddenFields"=>[
            'onTable' => [],
        ],

        "controls"=>"all",

];
