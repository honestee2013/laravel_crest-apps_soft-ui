<?php

return [
    'model' => App\Modules\Production\Models\ProductionProcessInput::class,
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
