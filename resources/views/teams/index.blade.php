@extends('layouts.app')

@section('auth-soft-ui')

    @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
            <span class="alert-icon"><i class="fas fa-thumbs-up" style="font-size:2em"></i></span>
            <span class="alert-text">&nbsp;<strong >Success!</strong> {!! session('success_message') !!}

            </span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card text-bg-theme p-3">


        <div class="card-header pb-0">
            <div class="d-flex flex-row justify-content-between">
                <div>
                    <h5 class="mb-0">Teams</h5>
                </div>
                <a href="{{ route('teams.team.create') }}" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; Create New Team</a>
            </div>
        </div>


        @if(count($teams) == 0)
            <div class="card-body text-center">
                <h4>No Teams Available.</h4>
            </div>
        @else
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">

                <div class="d-flex justify-content-between ms-0 mt-4 mb-0">
                    <div class="d-flex justify-content-start ms-2" >
                        <button onclick="exportToExcel('data_table', 'teams')" class="btn bg-gradient-success bt-sm py-0 me-2" style="border-radius: 3em; height: 2.6em " type="button">
                            <span class="btn-inner--icon"><i class="fas fa-file-excel text-sm me-1 text-white"></i></span>
                            <span class="btn-inner--text">XLS</span>
                        </button>
                        <button onclick="exportTableToCSV('data_table', 'teams')" class="btn bg-gradient-info  bt-sm py-0 me-2" style="border-radius: 3em; height: 2.6em " type="button">
                            <span class="btn-inner--icon"><i class="fas fa-file-csv text-sm  me-1  text-white"></i></span>
                            <span class="btn-inner--text">CSV</span>
                        </button>
                        <button onclick="exportTableToPDF('data_table', 'teams')" class="btn bg-gradient-warning  bt-sm py-0 me-2" style="border-radius: 3em; height: 2.6em " type="button">
                            <span class="btn-inner--icon"><i class="fas fa-file-pdf text-sm  me-1  text-white"></i></span>
                            <span class="btn-inner--text">PDF</span>
                        </button>


                        <!-- Bulk Delete Form -->
                        <form id="bulk-delete-form" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE') <!-- Ensure this is present for DELETE requests -->
                        </form>

                        <button id="bulk-delete-btn" class="btn bg-gradient-danger bt-sm py-0 ms-2" type="button" style="display:none; border-radius: 3em; height: 2.6em" onclick="bulkDelete('teams')">
                            <span class="btn-inner--icon"><i class="fas fa-trash text-sm me-1 text-white"></i></span>
                            <span class="btn-inner--text">Delete Selected</span>
                        </button>


                        <script>
                            window.appUrls = {
                                bulkDelete: "{{ route('bulkDelete') }}"
                            };
                        </script>

                    </div>


                    <div class="d-flex justify-content-start ms-2">
                        <div class="input-group mb-0" style="width: 7.8em;">
                            <label class="input-group-text" for="recordsPerPage">Rows</label>
                            <select class="form-select form-control form-control-sm" style=" height: 2.9em;" id="records-per-page" onchange="changeRecordsPerPage()">

                                <option  value="25" {{ request()->input('records_per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option  value="50" {{ request()->input('records_per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option  value="100" {{ request()->input('records_per_page') == 100 ? 'selected' : '' }}>100</option>
                                <option  value="200" {{ request()->input('records_per_page') == 200 ? 'selected' : '' }}>200</option>
                                <option  value="500" {{ request()->input('records_per_page') == 500 ? 'selected' : '' }}>500</option>

                            </select>
                        </div>

                        <div class="me-4 ms-2" style="width: 12.4em">
                            <div class="input-group mb-0">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input class="form-control"  type="search" id="search_box" onkeyup="searchFilter()" placeholder="Search for names..">
                            </div>
                        </div>
                    </div>


                </div>


                <table id="data_table" class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-center"><input type="checkbox" id="select-all"></th>

                            

<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-start" style="cursor: pointer">
    <div class="d-flex flex-row justify-content-between">
        Name
        <i class="fas fa-sort  text-sm text-secondary" data-bs-placement="top" ></i>
   </div>
</th>






<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-start" style="cursor: pointer">
    <div class="d-flex flex-row justify-content-between">
        Description
        <i class="fas fa-sort  text-sm text-secondary" data-bs-placement="top" ></i>
   </div>
</th>






                            <th></th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">
                                <div class="mx-4">
                                    Actions
                                </div>
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                    @foreach($teams as $team)
                        <tr>

                            <td class="align-middle text-center">
                                <input type="checkbox" class="row-checkbox" data-id="{{ $team->id }}">
                            </td>

                            
                            <td class="text-start">
                                <p class="text-xs font-weight-bold mb-0 text-wrap">{{ $team->name }}</p>
                            </td>


                            <td class="text-start">
                                <p class="text-xs font-weight-bold mb-0 text-wrap">{{ $team->description }}</p>
                            </td>



                            <td class="text-end">

                                <form id="delete-form-{{ $team->id }}" method="POST" action="{!! route('teams.team.destroy', $team->id) !!}" accept-charset="UTF-8">

                                <input name="_method" value="DELETE" type="hidden">
                                    {{ csrf_field() }}


                                    <td class="text-end">
                                        <a href="{{ route('teams.team.show', $team->id ) }}" class="" data-bs-toggle="tooltip" title="Show team" data-bs-original-title="Show team">
                                            <i class="fas fa-eye  text-sm text-info" data-bs-placement="top" ></i>
                                        </a>

                                        &nbsp;&nbsp;&nbsp;

                                        <a href="{{ route('teams.team.edit', $team->id ) }}" class="" data-bs-toggle="tooltip" title="Edit team" data-bs-original-title="Edit team">
                                            <i class="fas fa-edit text-sm text-primary"  data-bs-placement="top"></i>
                                        </a>

                                        &nbsp;&nbsp;&nbsp;

                                        <button type="button" class="btn text-white delete-button" style="height: 0.2em; width:1em; padding:0em" data-form-id="delete-form-{{ $team->id }}" title="Delete team">
                                            <i class="fas fa-trash text-sm text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete team"></i>
                                        </button>


                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    </td>


                                </form>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>


            <div class="mt-3 ms-3 me-4 d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-sm text-secondary">
                        Showing {{ $teams->firstItem() }} to {{ $teams->lastItem() }} of {{ $teams->total() }} results
                    </p>
                </div>
                <div>
                    {!! $teams->appends(['records_per_page' => request()->input('records_per_page')])->links('pagination') !!}

                </div>
            </div>



        </div>

        @endif

    </div>
@endsection