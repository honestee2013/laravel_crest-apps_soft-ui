@extends('layouts.app')

@section('auth-soft-ui')

    <div class="card text-bg-theme">

        <div class="card-header pb-0">
            <div class="d-flex flex-row justify-content-between">
                <div>
                    <h5 class="mb-0">{{ __('Create New Permission') }}</h5>
                </div>

                <a href="{{ route('permissions.permission.index') }}" class="btn bg-gradient-info btn-sm text-white" title="Show All Permission">
                    <i class="fas fa-list  text-sm text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Show All Permission"></i>
                </a>

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

            <form method="POST" class="needs-validation" novalidate action="{{ route('permissions.permission.store') }}" accept-charset="UTF-8" id="create_permission_form" name="create_permission_form" >
            {{ csrf_field() }}
            @include ('permissions.form', [
                                        'permission' => null,
                                      ])


                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-md  bg-primary mt-4 mb-4 text-white" value="Add">{{ 'Add' }}</button>
                </div>



            </form>

        </div>
    </div>

@endsection


