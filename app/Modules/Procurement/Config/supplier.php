<?php

return [

        "model"=>"App\\Modules\\Procurement\\Models\\Supplier",
        "fieldDefinitions"=>[


            'name' => ['field_type' => 'text', 'validation' => 'required|string'],


            'supplier_type_id' => [
                'field_type' => 'select',
                'options' => App\Modules\Procurement\Models\SupplierType::pluck('display_name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\Procurement\Models\SupplierType',
                    'type' => 'belongsTo',
                    'display_field' => 'display_name',
                    'dynamic_property' => 'supplierType',
                    'foreign_key' => 'supplier_type_id',
                    'inlineAdd' => true,
                ],
                'label' => 'Supplier Type',
                'validation' => 'required|string'
            ],


            'description' => ['field_type' => 'textarea'],

            'company_name' => ['field_type' => 'text'],
            'zip_code' => ['field_type' => 'text'],
            'website' => ['field_type' => 'text'],

            'status' => [
                'field_type' => 'text'

            ],







        ],



        "hiddenFields"=>[
            'onTable' => [
            ],
            'onNewForm' => [
            ],
            'onEditForm' => [
            ],
        ],


        "simpleActions"=>['show', 'edit', 'delete'],




        "controls"=>"all",


];
