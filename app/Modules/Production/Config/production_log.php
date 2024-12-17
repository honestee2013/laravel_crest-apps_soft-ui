<?php

return [
    'model' => App\Modules\Production\Models\ProductionLog::class,
    'fieldDefinitions' => [


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



        'production_batch_id' => [
            'field_type' => 'select',
            'options' => \App\Modules\Production\Models\ProductionBatch::pluck('batch_number', 'id')->toArray(),

            'relationship' => [
                'model' => 'App\Modules\Production\Models\ProductionBatch',
                'type' => 'belongsTo',
                'display_field' => 'batch_number',
                'dynamic_property' => 'batch',
                'foreign_key' => 'production_batch_id',
            ],
            'label' => 'Batch Number',
            'display' => 'block',
            'multiSelect' => false,
        ],


















        'start_time' => [
            'field_type' => 'datetime',
        ],

        'end_time' => [
            'field_type' => 'datetime',
        ],

        'notes' => [
            'field_type' => 'textarea',
        ],









    ],



    "hiddenFields" => [
        'onTable' => [],
        'onDetail' => [],
        'onEditForm' => [],
        'onNewForm' => [


        ],
        'onQuery' => [],
    ],

    "simpleActions" => ['show', 'edit', 'delete'],


    "controls" => "all"



];
