<?php

return [
    'model' => ProductionOrder::class,
    'table' => 'production_orders',
    'fields' => [
        'id' => [
            'type' => 'integer',
            'nullable' => false,
            'default' => null,
        ],
        'order_number' => [
            'type' => 'string',
            'nullable' => false,
            'default' => null,
            'label' => 'Order Number',
            'validation' => 'required|string|max:255',
        ],
        'batch_id' => [
            'type' => 'integer',
            'nullable' => true,
            'default' => null,
            'field_type' => 'select',
            'options' => app('App\Modules\Production\Models\Batch')->optionList(),

            'relationship' => [
                'model' => 'App\Modules\Production\Models\Batch',
                'type' => 'belongsTo',
                'display_field' => 'batch_number',
                'dynamic_property' => 'batch',
                'foreign_key' => 'batch_id',
                'inlineAdd' => true,
            ],
            'label' => 'Batch',
            'validation' => 'nullable|int|exists:batches,id',
        ],
        'created_at' => [
            'type' => 'timestamp',
            'nullable' => true,
            'default' => null,
        ],
        'updated_at' => [
            'type' => 'timestamp',
            'nullable' => true,
            'default' => null,
        ],
    ],
];
