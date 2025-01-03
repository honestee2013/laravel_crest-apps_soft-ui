<?php

return [
    'model' => App\Modules\Production\Models\ProductionOrderItem::class,
    'fieldDefinitions' => [



        'production_order_request_id' => [
            'field_type' => 'select',
            'options' => app('App\Modules\Production\Models\ProductionOrderRequest')->pluck('order_number', 'id'),
            'relationship' => [
                'model' => 'App\Modules\Production\Models\ProductionOrder',
                'type' => 'belongsTo',
                'display_field' => 'order_number',
                'dynamic_property' => 'productionOrder',
                'foreign_key' => 'production_order_request_id',
            ],
            'label' => 'Production Order',
            'display' => 'block',
            'multiSelect' => false,
            'validation' => 'required|int'

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
            'label' => 'Allocated Resource',
            'display' => 'block',
            'multiSelect' => false,
            'validation' => 'required|int'
        ],




        'quantity' => [
            'field_type' => 'number',
            'validation' => 'required|decimal:2'
        ],



        'note' => [
            'field_type' => 'textarea',
            'validation' => 'nullable|string'
        ],


    ],



    "hiddenFields" => [
        'onTable' => [],
        'onDetail' => [],
        'onEditForm' => [
            'order_number',

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
