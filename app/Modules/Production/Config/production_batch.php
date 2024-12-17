<?php

return [
    'model' => App\Modules\Production\Models\ProductionBatch::class,
    'fieldDefinitions' => [


        'batch_number' => [
            'field_type' => 'text',
            'label' => 'Batch Number',
        ],



        'production_order_request_id' => [
            'field_type' => 'select',
            'options' => \App\Modules\Production\Models\ProductionOrderRequest::where('is_approved', false)->pluck('order_number', 'id')->toArray(),

            'relationship' => [
                'model' => 'App\Modules\Production\Models\ProductionOrderRequest',
                'type' => 'belongsTo',
                'display_field' => 'order_number',
                'dynamic_property' => 'productionOrder',
                'foreign_key' => 'production_order_request_id',
            ],
            'label' => 'Production Order',
            'display' => 'block',
            'multiSelect' => false,
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
        ],








    ],



    "hiddenFields" => [
        'onTable' => [],
        'onDetail' => [],
        'onEditForm' => [],
        'onNewForm' => [
            'batch_number',
            'status_id',

        ],
        'onQuery' => [],
    ],

    "simpleActions" => ['show', 'edit', 'delete'],


    "controls" => "all"



];
