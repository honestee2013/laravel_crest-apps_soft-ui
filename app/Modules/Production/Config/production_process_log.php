<?php

return [
    'model' => App\Modules\Production\Models\ProductionProcessLog::class,
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





        'production_process_id' => [
            'field_type' => 'select',
            'options' => \App\Modules\Production\Models\ProductionProcess::pluck('name', 'id')->toArray(),

            'relationship' => [
                'model' => 'App\Modules\Production\Models\ProductionProcess',
                'type' => 'belongsTo',
                'display_field' => 'name',
                'dynamic_property' => 'productionProcess',
                'foreign_key' => 'production_process_id',
            ],
            'label' => 'Production Process',
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







        'start_time' => [
            'field_type' => 'datetime',
        ],

        'end_time' => [
            'field_type' => 'datetime',
        ],



        'operator_id' => [
            'field_type' => 'select',
            'options' => App\Models\User::pluck('name', 'id')->toArray(),
            'relationship' => [
                'model' => 'App\Models\User',
                'type' => 'belongsTo',
                'display_field' => 'name',
                'dynamic_property' => 'operator',
                'foreign_key' => 'operator_id',
                'inlineAdd' => false,
            ],
            'label' => 'Operator',
        ],


        'supervisor_id' => [
            'field_type' => 'select',
            'options' => App\Models\User::pluck('name', 'id')->toArray(),
            'relationship' => [
                'model' => 'App\Models\User',
                'type' => 'belongsTo',
                'display_field' => 'name',
                'dynamic_property' => 'supervisor',
                'foreign_key' => 'supervisor_id',
                'inlineAdd' => false,
            ],
            'label' => 'Supervisor',
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
