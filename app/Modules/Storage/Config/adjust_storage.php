<?php

return [

        "model"=>"App\\Modules\\Inventory\\Models\\InventoryAdjustment",
        "fieldDefinitions"=>[

            'uuid' => '',




            'transaction_id' => [
                'field_type' => 'select',
                'options' => App\Modules\Inventory\Models\InventoryTransaction::pluck('transaction_id', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\Inventory\Models\InventoryTransaction',
                    'type' => 'belongsTo',
                    'display_field' => 'transaction_id',
                    'dynamic_property' => 'transaction',
                    'foreign_key' => 'transaction_id',
                    'inlineAdd' => false,
                ],
                'label' => 'Transaction ID',
                'validation' => 'required'
            ],


            'adjustment_type' => [
                'field_type' => 'radio',
                'display' => 'inline',
                'options' => ['Addition' => 'Addition', 'Subtraction' => 'Subtraction'],
                'label' => 'Adjustment Type',
                'validation' => 'required|string'
            ],



            'adjusted_quantity' => [ 'field_type' => 'number', 'validation' => 'required|integer'],

            'adjustment_reason' =>[
                'field_type' => 'textarea',
                'label' => 'Reason for adjustment',
                'validation' => 'required|string'
            ],


            'adjusted_by' => [
                'field_type' => 'select',
                'options' => App\Models\User::pluck('name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Models\User',
                    'type' => 'belongsTo',
                    'display_field' => 'name',
                    'dynamic_property' => 'adjustedBy',
                    'foreign_key' => 'adjusted_by',
                    'inlineAdd' => false,
                ],
                'label' => 'Adjusted By',
                'validation' => 'required'
            ],

            'adjustment_date' => [ 'field_type' => 'datetime', 'validation' => 'required|string'],

        ],


        "isTransaction"=>true,
        "dispatchEvents"=>true,


        "simpleActions"=>['show'],


        "hiddenFields"=>[
            'onTable' => [
                'uuid'
            ],
            'onNewForm' => [
                'id',
                'uuid',
                'storage_location',
            ],
            'onEditForm' => [
                'id',
                'uuid',
                'storage_location',
            ],
        ],

        "controls" => [
            'addButton',

            'files' => [
                'export' => ['xls', 'csv', 'pdf'],
                'print',
            ],
            'perPage' => [5, 10, 25, 50, 100, 200, 500],

            'bulkActions' => [
                'export' => ['xls', 'csv', 'pdf'],
            ],
            'search',
            'showHideColumns',
        ],

];
