@extends('layouts.app')

@section('auth-soft-ui')

<div class="card text-bg-theme pb-0 p-3">

    <div class="card-header pb-0 p-3">
        <div class="row">
            <div class="col-md-8 d-flex align-items-center">
              <h5 class="m-0">{{ isset($role->name) ? $role->name : 'Role' }}</h5>
            </div>

            <div class="col-md-4 text-end">
                <form id="delete-form-{{ $role->id }}" method="POST" action="{!! route('roles.role.destroy', $role->id) !!}" accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}

                    <a href="{{ route('roles.role.edit', $role->id ) }}" class="btn  bg-gradient-primary btn-sm text-white" title="Edit Role">
                        <i class="fas fa-edit text-sm text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Role"></i>
                    </a>

                    <button type="button" class="btn bg-gradient-warning btn-sm text-white delete-button" data-form-id="delete-form-{{ $role->id }}"  title="Delete Role" >
                        <i class="fas fa-trash  text-sm text-white" data-bs-toggle="tooltip" data-bs-placement="top" title=Delete Role"></i>
                    </button>

                    <a href="{{ route('roles.role.index') }}" class="btn bg-gradient-info btn-sm text-white" title="Show All Role">
                        <i class="fas fa-list  text-sm text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Show All Role"></i>
                    </a>

                    <a href="{{ route('roles.role.create') }}" class="btn bg-gradient-secondary btn-sm text-white" title="Create New Role">
                        <i class="fa fa-plus text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Create New Role"></i>
                    </a>

                </form>
            </div>
        </div>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Team</dt>
            <dd class="col-lg-10 col-xl-9">{{ optional($role->team)->name }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Name</dt>
            <dd class="col-lg-10 col-xl-9">{{ $role->name }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Description</dt>
            <dd class="col-lg-10 col-xl-9">{{ $role->description }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Created At</dt>
            <dd class="col-lg-10 col-xl-9">{{ $role->created_at }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Updated At</dt>
            <dd class="col-lg-10 col-xl-9">{{ $role->updated_at }}</dd>

        </dl>

    </div>
</div>

@endsection
