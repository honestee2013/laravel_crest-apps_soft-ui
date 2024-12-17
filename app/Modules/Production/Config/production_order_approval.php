<?php

return [
    'model' => App\Modules\Production\Models\ProductionOrderApproval::class,
    'fieldDefinitions' => [



        'order_number' => [
            'field_type' => 'text',
            'label' => 'Order Number',
            'validation' => 'nullable|unique:production_orders,order_number',
        ],


        'item_id' => [
            'field_type' => 'select',
            'options' => app('App\Modules\Production\Models\Product')->pluck('name', 'id'),
            'relationship' => [
                'model' => 'App\Modules\Production\Models\Product',
                'type' => 'belongsTo',
                'display_field' => 'name',
                'dynamic_property' => 'item',
                'foreign_key' => 'item_id',
            ],
            'label' => 'Item (Product)',
            'display' => 'block',
            'multiSelect' => false,
            'validation' => 'required|int'
        ],




        'quantity' => [
            'field_type' => 'number',
            'validation' => 'required|decimal:2'
        ],




        'due_date' => [
            'field_type' => 'datetime',
            'validation' => 'nullable|string',
        ],





        'status_id' => [
            'field_type' => 'radio',
            'options' => app('App\Modules\Core\Models\Status')
            ->where("name", "pending")
            ->orWhere("name", "approved")
            ->orWhere("name", "rejected")
            ->pluck('display_name', 'id'),

            'relationship' => [
                'model' => 'App\Modules\Core\Models\Status',
                'type' => 'belongsTo',
                'display_field' => 'display_name',
                'dynamic_property' => 'status',
                'foreign_key' => 'status_id',
            ],
            'label' => 'Status',
            'display' => 'block',
            'multiSelect' => false,
            'validation' => 'required',
        ],


        'remarks' => [
            'field_type' => 'textarea',
            'validation' => 'nullable|string'
        ],





    ],



    "hiddenFields" => [
        'onTable' => [],
        'onDetail' => [],
        'onEditForm' => [
            'order_number',
            'item_id',
            'due_date',
            'quantity',

        ],
        'onNewForm' => [
            'order_number',
            'status_id',
        ],
        'onQuery' => [

        ],
    ],

    "simpleActions" => ['show', 'edit'],

    "moreActions" => [
        'approve' => [
            'icon' => 'fas fa-check text-sm me-1 text-success',
            'updateModelField' => true,
            'fieldName' => "status_id",
            'fieldValue' => app('App\Modules\Core\Models\Status')->where("name", "approved")->first()->id,
        ],
        'reject' => [
            'icon' => 'fas fa-times text-sm me-1 text-danger',
            'updateModelField' => true,
            'fieldName' => "status_id",
            'fieldValue' => app('App\Modules\Core\Models\Status')->where("name", "rejected")->first()->id,
        ],

    ],


    "controls" => [

        'files' => [
            'export' => ['xls', 'csv', 'pdf'],
            'print',
        ],
        'perPage' => [5, 10, 25, 50, 100, 200, 500],

        'bulkActions' => [
            'export' => ['xls', 'csv', 'pdf'],
            'delete',
            'updateModelFields' => [
                'approve' => [
                    'fieldName' => "status_id",
                    'fieldValue' => app('App\Modules\Core\Models\Status')->where("name", "approved")->first()->id,
                ],
                'reject' => [
                    'fieldName' => "status_id",
                    'fieldValue' => app('App\Modules\Core\Models\Status')->where("name", "rejected")->first()->id,
                ]
            ],

        ],
        'search',
        'showHideColumns',
    ],


];
