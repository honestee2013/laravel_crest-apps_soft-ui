<?php

return [
    'model' => App\Modules\Production\Models\ProductionProcessDowntime::class,
    'fieldDefinitions' => [



        'production_process_log_id' => [
            'field_type' => 'select',
            'options' => \App\Modules\Production\Models\ProductionProcessLog::pluck('display_name', 'id')->toArray(),

            'relationship' => [
                'model' => 'App\Modules\Production\Models\ProductionProcessLog',
                'type' => 'belongsTo',
                'display_field' => 'display_name',
                'dynamic_property' => 'productionProcessLog',
                'foreign_key' => 'production_process_log_id',
            ],
            'label' => 'Production Log',
            'display' => 'block',
            'multiSelect' => false,
            'validation' => 'required|int'

        ],


        'start_time' => [
            'field_type' => 'datetime',
        ],

        'end_time' => [
            'field_type' => 'datetime',
        ],

        'duration' => [
            'field_type' => 'text',
            'label' => 'Duration (Min)',
        ],


        'reason' => [
            'field_type' => 'text',
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
            'batch_number',
            'status_id',

        ],
        'onQuery' => [],
    ],

    "simpleActions" => ['show', 'edit', 'delete'],


    "controls" => "all"



];
