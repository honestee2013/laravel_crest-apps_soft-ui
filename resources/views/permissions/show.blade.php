@extends('layouts.app')

@section('auth-soft-ui')

<div class="card text-bg-theme pb-0 p-3">

    <div class="card-header pb-0 p-3">
        <div class="row">
            <div class="col-md-8 d-flex align-items-center">
              <h5 class="m-0">{{ isset($permission->name) ? $permission->name : 'Permission' }}</h5>
            </div>

            <div class="col-md-4 text-end">
                <form id="delete-form-{{ $permission->id }}" method="POST" action="{!! route('permissions.permission.destroy', $permission->id) !!}" accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}

                    <a href="{{ route('permissions.permission.edit', $permission->id ) }}" class="btn  bg-gradient-primary btn-sm text-white" title="Edit Permission">
                        <i class="fas fa-edit text-sm text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Permission"></i>
                    </a>

                    <button type="button" class="btn bg-gradient-warning btn-sm text-white delete-button" data-form-id="delete-form-{{ $permission->id }}"  title="Delete Permission" >
                        <i class="fas fa-trash  text-sm text-white" data-bs-toggle="tooltip" data-bs-placement="top" title=Delete Permission"></i>
                    </button>

                    <a href="{{ route('permissions.permission.index') }}" class="btn bg-gradient-info btn-sm text-white" title="Show All Permission">
                        <i class="fas fa-list  text-sm text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Show All Permission"></i>
                    </a>

                    <a href="{{ route('permissions.permission.create') }}" class="btn bg-gradient-secondary btn-sm text-white" title="Create New Permission">
                        <i class="fa fa-plus text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Create New Permission"></i>
                    </a>

                </form>
            </div>
        </div>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Name</dt>
            <dd class="col-lg-10 col-xl-9">{{ $permission->name }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Description</dt>
            <dd class="col-lg-10 col-xl-9">{{ $permission->description }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Created At</dt>
            <dd class="col-lg-10 col-xl-9">{{ $permission->created_at }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Updated At</dt>
            <dd class="col-lg-10 col-xl-9">{{ $permission->updated_at }}</dd>

        </dl>

    </div>
</div>

@endsection
