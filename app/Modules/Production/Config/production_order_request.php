<?php

return [
    'model' => App\Modules\Production\Models\ProductionOrderRequest::class,
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
            'validation' => 'required|decimal:2|min:0.01'
        ],




        'due_date' => [
            'field_type' => 'datetime',
            'validation' => 'nullable|string',
        ],





        'status_id' => [
            'field_type' => 'select',
            'options' => app('App\Modules\Core\Models\Status')->pluck('display_name', 'id'),
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
            'validation' => 'nullable|int'
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
            'status_id',

        ],
        'onNewForm' => [
            'order_number',
            'status_id',
        ],
        'onQuery' => [],
    ],

    "simpleActions" => ['show', 'edit', 'delete'],


    "controls" => "all"



];
