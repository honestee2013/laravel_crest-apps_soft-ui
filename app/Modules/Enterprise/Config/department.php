<?php

return [

        "model"=>"App\\Modules\\Enterprise\\Models\\Department",
        "fieldDefinitions"=>[
            'name' => [ 'field_type' => 'text', 'validation' => 'required|string'],
            'description' =>'textarea',

            'company' => [
                'field_type' => 'select',
                'options' => App\Modules\Enterprise\Models\Company::pluck('name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\Enterprise\Models\Company',
                    'type' => 'belongsTo',
                    'display_field' => 'name',
                    'dynamic_property' => 'company',
                    'foreign_key' => 'company_id',
                    'inlineAdd' => true,
                ],

                'validation' => 'required|string'
            ],

        ],


        "simpleActions"=>['show', 'edit', 'delete'],

        "hiddenFields"=>[],

        "controls"=>"all",

];
