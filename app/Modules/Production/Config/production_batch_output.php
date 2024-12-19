<?php

return [
    'model' => App\Modules\Production\Models\ProductionBatch::class,
    'fieldDefinitions' => [



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



        'planned_quantity' => [
            'field_type' => 'number',
            'validation' => 'required|decimal:2'
        ],



        'actual_quantity' => [
            'field_type' => 'number',
            'validation' => 'nullable|decimal:2'
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
