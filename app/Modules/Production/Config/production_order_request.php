<?php

return [
    'model' => App\Modules\Production\Models\ProductionOrderRequest::class,
    'fieldDefinitions' => [



        'order_number' => [
            'field_type' => 'text',
            'label' => 'Order Number',
            'validation' => 'nullable|unique:production_orders,order_number',
        ],


        'items' => [
            'field_type' => 'select',
            'options' => App\Modules\Item\Models\Item::pluck('name', 'id')->toArray(),
            'relationship' => [
                'model' => 'App\Modules\Item\Models\Item',
                'type' => 'belongsToMany',
                'display_field' => 'name',
                'dynamic_property' => 'requestedItems',
                'foreign_key' => 'item_id',
                'inlineAdd' => false,
            ],
            'display' => 'inline',
            'label' => 'Requested Items (Products)',
            'multiSelect' => true,
        ],


        'resources' => [
            'field_type' => 'select',
            'options' => App\Modules\Item\Models\Item::pluck('name', 'id')->toArray(),
            'relationship' => [
                'model' => 'App\Modules\Item\Models\Item',
                'type' => 'belongsToMany',
                'display_field' => 'name',
                'dynamic_property' => 'allocatedResources',
                'foreign_key' => 'item_id',
                'inlineAdd' => false,
            ],
            'display' => 'inline',
            'label' => 'Allocated Resources',
            'multiSelect' => true,
        ],



        'due_date' => [
            'field_type' => 'datetime',
            'validation' => 'nullable|string',
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
            'validation' => 'nullable|int'
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
            'validation' => 'nullable|int'
        ],


        'remarks' => [
            'field_type' => 'textarea',
            'validation' => 'nullable|string'
        ],





    ],



    "hiddenFields" => [
        'onTable' => [
            'supervisor_id',
        ],
        'onDetail' => [],
        'onEditForm' => [
            'order_number',
            'status_id',
            'items',
            'item_id',
            'resources',

        ],
        'onNewForm' => [
            'order_number',
            'status_id',
            'items',
            'resources',
        ],
        'onQuery' => [],
    ],

    "simpleActions" => ['show', 'edit', 'delete'],


    "controls" => "all"



];
