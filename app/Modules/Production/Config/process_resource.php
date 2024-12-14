<?php

return [
    'model' => App\Modules\Production\Models\ProcessResource::class,
    'fieldDefinitions' => [


        'production_process_log_id' => [
            'field_type' => 'select',
            'options' => App\Modules\Production\Models\ProductionProcessLog::pluck('display_name', 'id'),
            'relationship' => [
                'model' => 'App\Modules\Production\Models\ProcessResource',
                'type' => 'belongsTo',
                'display_field' => 'display_name',
                'dynamic_property' => 'productionProcessLog',
                'foreign_key' => 'production_process_log_id',
            ],
            'label' => 'production process log',
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



        'quantity_used' => [
            'field_type' => 'number',
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
