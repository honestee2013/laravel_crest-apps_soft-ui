@extends('layouts.app')

@section('auth-soft-ui')

<div class="card text-bg-theme pb-0 p-3">

    <div class="card-header pb-0 p-3">
        <div class="row">
            <div class="col-md-8 d-flex align-items-center">
              <h5 class="m-0">{{ isset($team->name) ? $team->name : 'Team' }}</h5>
            </div>

            <div class="col-md-4 text-end">
                <form id="delete-form-{{ $team->id }}" method="POST" action="{!! route('teams.team.destroy', $team->id) !!}" accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}

                    <a href="{{ route('teams.team.edit', $team->id ) }}" class="btn  bg-gradient-primary btn-sm text-white" title="Edit Team">
                        <i class="fas fa-edit text-sm text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Team"></i>
                    </a>

                    <button type="button" class="btn bg-gradient-warning btn-sm text-white delete-button" data-form-id="delete-form-{{ $team->id }}"  title="Delete Team" >
                        <i class="fas fa-trash  text-sm text-white" data-bs-toggle="tooltip" data-bs-placement="top" title=Delete Team"></i>
                    </button>

                    <a href="{{ route('teams.team.index') }}" class="btn bg-gradient-info btn-sm text-white" title="Show All Team">
                        <i class="fas fa-list  text-sm text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Show All Team"></i>
                    </a>

                    <a href="{{ route('teams.team.create') }}" class="btn bg-gradient-secondary btn-sm text-white" title="Create New Team">
                        <i class="fa fa-plus text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Create New Team"></i>
                    </a>

                </form>
            </div>
        </div>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Name</dt>
            <dd class="col-lg-10 col-xl-9">{{ $team->name }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Description</dt>
            <dd class="col-lg-10 col-xl-9">{{ $team->description }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Created At</dt>
            <dd class="col-lg-10 col-xl-9">{{ $team->created_at }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Updated At</dt>
            <dd class="col-lg-10 col-xl-9">{{ $team->updated_at }}</dd>

        </dl>

    </div>
</div>

@endsection
