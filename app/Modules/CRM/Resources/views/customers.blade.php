@extends('layouts.app')

@section('auth-soft-ui')
<livewire:core.livewire.data-tables.data-table-manager model="App\\Modules\\CRM\\Models\\Customer" />
@endsection