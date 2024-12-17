<?php

return [
    'model' => App\Modules\Production\Models\ProductionBatch::class,
    'fieldDefinitions' => [



        'batch_id' => [
            'field_type' => 'select',
            'options' => \App\Modules\Production\Models\ProductionBatch::pluck('batch_number', 'id')->toArray(),

            'relationship' => [
                'model' => 'App\Modules\Production\Models\BatchResourceItem',
                'type' => 'belongsTo',
                'display_field' => 'batch_number',
                'dynamic_property' => 'batch',
                'foreign_key' => 'batch_id',
            ],
            'label' => 'Batch Number',
            'display' => 'block',
            'multiSelect' => false,
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
            'label' => 'Product',
            'display' => 'block',
            'multiSelect' => false,
        ],



        'expected_quantity' => [
            'field_type' => 'number',
        ],



        'quantity_produced' => [
            'field_type' => 'number',
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
