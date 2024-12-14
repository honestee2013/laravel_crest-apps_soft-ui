<?php

return [
    'model' => App\Modules\Production\Models\ProductionProcessLog::class,
    'fieldDefinitions' => [


        'batch_id' => [
            'field_type' => 'select',
            'options' => \App\Modules\Production\Models\Batch::pluck('batch_number', 'id')->toArray(),

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
