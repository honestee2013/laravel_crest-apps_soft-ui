






@extends('layouts.app')

@section('auth-soft-ui')



    <livewire:data-tables.data-table
        model="App\Modules\Inventory\Models\Category"
        :fieldDefinitions="[
            'name' => 'text',

            'description' =>'textarea',
        ]"
        :simpleActions="['show', 'edit', 'delete']"


        :hiddenFields="[
            'onTable' => [],
        ]"
    />





@endsection

