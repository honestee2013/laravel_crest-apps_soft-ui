<?php

return [

        "model"=>"App\\Modules\\Inventory\\Models\\InventoryTransaction",
        "fieldDefinitions"=>[

            'readable_id' =>[
                'field_type' => 'id',
                'label' => 'Transaction ID',
            ],

            'uuid' => '',

            'transaction_date' => [ 'field_type' => 'datetime-local', 'validation' => 'required|string'],


            'reference_number' => [ 'field_type' => 'text'],



            'transaction_type_id' => [
                'field_type' => 'select',
                'options' => app('App\Modules\Inventory\Models\TransactionType')->optionList('storage_direction'),

                'relationship' => [
                    'model' => 'App\Modules\Inventory\Models\TransactionType',
                    'type' => 'belongsTo',
                    'display_field' => 'display_name',
                    'dynamic_property' => 'transactionType',
                    'foreign_key' => 'transaction_type_id',
                    'inlineAdd' => true,
                ],
                'label' => 'Transaction Type',
                'validation' => 'required|int'
            ],



            'storage_id' => [
                'field_type' => 'select',
                'options' => App\Modules\Inventory\Models\Storage::pluck('name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\Inventory\Models\Storage',
                    'type' => 'belongsTo',
                    'display_field' => 'name',
                    'dynamic_property' => 'storage',
                    'foreign_key' => 'storage_id',
                    'inlineAdd' => true,
                ],
                'label' => 'Storage',
                'validation' => 'required'
            ],



            'item_id' => [
                'field_type' => 'select',
                'options' => App\Modules\Inventory\Models\Item::pluck('name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\Inventory\Models\Item',
                    'type' => 'belongsTo',
                    'display_field' => 'name',
                    'dynamic_property' => 'item',
                    'foreign_key' => 'item_id',
                    'inlineAdd' => true,
                ],
                'label' => 'Item',
                'validation' => 'required'
            ],


            'quantity' => [ 'field_type' => 'number', 'validation' => 'required|integer'],

            'truck_number' => [ 'field_type' => 'text', 'validation' => 'required|string'],





            'recorded_by' => [
                'field_type' => 'select',
                'options' => App\Models\User::pluck('name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Models\User',
                    'type' => 'belongsTo',
                    'display_field' => 'name',
                    'dynamic_property' => 'recordedBy',
                    'foreign_key' => 'recorded_by',
                    'inlineAdd' => false,
                ],
                'label' => 'Recorded By',
                'validation' => 'required'
            ],


            'released_by' => [
                'field_type' => 'select',
                'options' => App\Models\User::pluck('name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Models\User',
                    'type' => 'belongsTo',
                    'display_field' => 'name',
                    'dynamic_property' => 'releasedBy',
                    'foreign_key' => 'released_by',
                    'inlineAdd' => false,
                ],
                'label' => 'Released By',
                'validation' => 'required'
            ],


            'collected_by' => [
                'field_type' => 'select',
                'options' => App\Models\User::pluck('name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Models\User',
                    'type' => 'belongsTo',
                    'display_field' => 'name',
                    'dynamic_property' => 'collectedBy',
                    'foreign_key' => 'collected_by',
                    'inlineAdd' => false,
                ],
                'label' => 'Collected By',
                'validation' => 'required'
            ],


            'customer_id' => [
                'field_type' => 'select',
                'options' => App\Modules\CRM\Models\Customer::pluck('name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\CRM\Models\Customer',
                    'type' => 'belongsTo',
                    'display_field' => 'name',
                    'dynamic_property' => 'customer',
                    'foreign_key' => 'customer_id',
                    'inlineAdd' => true,
                ],
                'label' => 'Customer',
                'validation' => 'required'
            ],


            'supplier_id' => [
                'field_type' => 'select',
                'options' => App\Modules\Procurement\Models\Supplier::pluck('name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\Procurement\Models\Supplier',
                    'type' => 'belongsTo',
                    'display_field' => 'name',
                    'dynamic_property' => 'supplier',
                    'foreign_key' => 'supplier_id',
                    'inlineAdd' => true,
                ],
                'label' => 'Supplier',
                'validation' => 'required'
            ],

            'invoice' => 'file',
            'note' =>'textarea',



        ],



        "hiddenFields"=>[
            'onTable' => [
                'uuid'
            ],
            'onNewForm' => [
                'id',
                'uuid',
                'readable_id',
            ],
            'onEditForm' => [
                'id',
                'uuid',
                'readable_id',
            ],
        ],


        "simpleActions"=>['show', 'edit'],


        "isTransaction"=>true,
        "dispatchEvents"=>true,

        "controls" => [
            'addButton',

            'files' => [
                'export' => ['xls', 'csv', 'pdf'],
                'import' => ['xls', 'csv'],
                'print',
            ],
            'bulkActions' => [
                'export' => ['xls', 'csv', 'pdf'],
            ],
            'search',
            'showHideColumns',
        ],

];