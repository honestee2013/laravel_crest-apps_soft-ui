




@extends('layouts.app')

@section('auth-soft-ui')



    <livewire:core.livewire.data-tables.data-table
        model="App\Modules\Inventory\Models\Item"
        :fieldDefinitions="[
            'name' => 'text',
            'description' =>'textarea',


            'categories' => [
                'field_type' => 'checkbox',
                'options' => App\Modules\Inventory\Models\Category::pluck('name', 'id')->toArray(),
                'relationship' => [
                    'model' => 'App\Modules\Inventory\Models\Category',
                    'type' => 'belongsToMany',
                    'display_field' => 'name',
                    'dynamic_property' => 'categories',
                    'foreign_key' => 'location_id'

                ],
                'label' => 'categories',
                'display' => 'inline',
                'multiSelect' => true,

            ],

        ]"
        :simpleActions="['show', 'edit', 'delete']"


        :hiddenFields="[
            'onTable' => [],
        ]"

        :controls="'all'"

    />





@endsection

