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
            'validation' => 'required|int'

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



        'inputs' => [
            'field_type' => 'select',
            'options' => App\Modules\Item\Models\Item::pluck('name', 'id')->toArray(),
            'relationship' => [
                'model' => 'App\Modules\Item\Models\Item',
                'type' => 'belongsToMany',
                'display_field' => 'name',
                'dynamic_property' => 'inputItems',
                'foreign_key' => 'item_id',
                'inlineAdd' => false,
            ],
            'display' => 'inline',
            'label' => 'Input Items (Resources)',
            'multiSelect' => true,
        ],



        'outputs' => [
            'field_type' => 'select',
            'options' => App\Modules\Item\Models\Item::pluck('name', 'id')->toArray(),
            'relationship' => [
                'model' => 'App\Modules\Item\Models\Item',
                'type' => 'belongsToMany',
                'display_field' => 'name',
                'dynamic_property' => 'outputItems',
                'foreign_key' => 'item_id',
                'inlineAdd' => false,
            ],
            'display' => 'inline',
            'label' => 'Output Items (Products)',
            'multiSelect' => true,
        ],








    ],



    "hiddenFields" => [
        'onTable' => [],
        'onDetail' => [],
        'onEditForm' => [
            'batch_number',
            'status_id',
            'inputs',
            'outputs',
        ],
        'onNewForm' => [
            'batch_number',
            'status_id',
            'inputs',
            'outputs',

        ],
        'onQuery' => [],
    ],

    "simpleActions" => ['show', 'edit', 'delete'],


    "controls" => "all"



];
