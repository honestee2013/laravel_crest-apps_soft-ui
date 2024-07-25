@extends('layouts.app')

@section('auth-soft-ui')

    <div class="card text-bg-theme">

        <div class="card-header pb-0 p-3">
            <div class="row">
                <div class="col-md-8 d-flex align-items-center">
                  <h5 class="m-0">{{ isset($permission->name) ? $permission->name : 'Permission' }}</h5>
                </div>

                <div class="col-md-4 text-end">
                    <form method="POST" action="{!! route('permissions.permission.destroy', $permission->id) !!}" accept-charset="UTF-8">
                        <input name="_method" value="DELETE" type="hidden">
                        {{ csrf_field() }}

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
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                    <span class="alert-icon"><i class="fas fa-exclamation-triangle" style="font-size:2em"></i></span>
                    <span class="alert-text">&nbsp;<strong >Error!</strong>
                        <ul class="list-unstyled mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form method="POST" class="needs-validation" novalidate action="{{ route('permissions.permission.update', $permission->id) }}" id="edit_permission_form" name="edit_permission_form" accept-charset="UTF-8" >
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('permissions.form', [
                                        'permission' => $permission,
                                      ])



                <div class="d-flex justify-content-end">
                    <input class="btn btn-primary mt-4 mb-4" type="submit" value="Update">
                </div>


            </form>

        </div>
    </div>

@endsection
