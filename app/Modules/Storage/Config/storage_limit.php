<?php

return [

        "model"=>"App\\Modules\\Storage\\Models\\StorageLimit",
        "fieldDefinitions"=>[


            'storage_id' => [
                'field_type' => 'select',
                'options' => App\Modules\Storage\Models\Storage::pluck('name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\Storage\Models\Storage',
                    'type' => 'belongsTo',
                    'display_field' => 'name',
                    'dynamic_property' => 'storage',
                    'foreign_key' => 'storage_id',
                    'inlineAdd' => true,
                ],
                'label' => 'Storages',
                'validation' => 'required'
            ],



            'item_id' => [
                'field_type' => 'select',
                'options' => App\Modules\Item\Models\Item::pluck('name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\Item\Models\Item',
                    'type' => 'belongsTo',
                    'display_field' => 'name',
                    'dynamic_property' => 'item',
                    'foreign_key' => 'item_id',
                    'inlineAdd' => true,
                ],
                'label' => 'Item',
                'validation' => 'required'
            ],


            'min_allowed' => [ 'field_type' => 'number', 'validation' => 'required|integer'],
            'max_allowed' => [ 'field_type' => 'number', 'validation' => 'required|integer'],


        ],


        "simpleActions"=>['show', 'edit', 'delete'],




        "controls"=>"all",


];
