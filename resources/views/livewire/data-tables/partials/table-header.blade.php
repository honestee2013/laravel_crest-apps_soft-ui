<div class="container ms-0 mt-4 mb-0">
    <!-- Export, Import & Print Data -->
    <div class="row">

        <!-- Files -->
        <div class="dropdown col-12 w-100 col-sm-auto w-sm-auto " x->
            <a href="#"
                class="btn bg-gradient-primary dropdown-toggle mb-2 bt-sm pt-2  rounded-pill w-100 px-5"
                data-bs-toggle="dropdown" id="navbarDropdownMenuLink2" style=" height: 3em; ">
                <span class="btn-inner--icon"><i
                        class="fa-solid fa-file text-sm me-1 text-white"></i></span>
                <span class="btn-inner--text">File</span>
            </a>

            <ul class="dropdown-menu p-3 pt-4" aria-labelledby="navbarDropdownMenuLink2">
                <!-- Export Section -->
                <pan class="m-2 text-uppercase text-xs fw-bolder">Export</pan>
                <hr class="m-2 p-0 bg-gray-500" />

                <li>
                    <a wire:click="export('xlsx')" class="dropdown-item" href="#">
                        <span class="btn-inner--icon me-1"><i
                                class="fas fa-file-excel text-sm me-1 text-success"></i></span>
                        <span class="btn-inner--text">XLS</span>
                    </a>
                </li>
                <li>
                    <a wire:click="export('csv')" class="dropdown-item" href="#">
                        <span class="btn-inner--icon me-1"><i
                                class="fa-solid fa-file-csv me-1 text-info"></i></span>
                        <span class="btn-inner--text">CVS</span>
                    </a>
                </li>
                <li>
                    <a wire:click="export('pdf')" class="dropdown-item" href="#">
                        <span class="btn-inner--icon me-1"><i
                                class="fas fa-file-pdf text-sm me-1 text-danger"></i></span>
                        <span class="btn-inner--text">PDF</span>
                    </a>
                </li>
                <li class="mb-3">
                    <a onclick="printTable()" class="dropdown-item" href="#">
                        <span class="btn-inner--icon me-1"><i
                                class="fa-solid fa-print text-sm me-1"></i></span>
                        <span class="btn-inner--text">Print</span>
                    </a>
                </li>

                <!-- Export Section -->
                <pan class="m-2 text-uppercase text-xs fw-bolder">Import</pan>
                <hr class="m-2 p-0 bg-gray-500" />
                <li>
                    <form wire:submit.prevent="import">
                        <input type="file" wire:model="file" class="p-4 pb-4 mb-1" />

                        @error('file')
                            <span class="text-danger"> {{ str_replace('fields.', ' ', $message) }} </span>
                        @enderror

                        <span x-show="$wire.file">
                            <hr class="m-0 p-0 mt-2 bg-gray-500" />
                            <button type="submit" class="btn btn-sm btn-secondary w-100 mt-4"
                                style="border-radius: 2em">Import</button>
                        </span>
                    </form>
                </li>
            </ul>
        </div>

        <!-- Bulk Action -->
        <div class="input-group col-12 w-100 col-sm-auto w-sm-auto" x-show="$wire.selectedRows.length">
            <select wire:model="bulkAction" class="form-select p-1 ps-3 pe-sm-5 px-sm-4 m-0"
                style = "height: 2.6em;
                        border-top-left-radius: 1.3em;
                        border-bottom-left-radius: 1.3em;

                    ">
                <option value="" style="display: none"> Action... </option>
                <option value="exportXLSX">Export XLS</option>
                <option value="exportCSV">Export CSV</option>
                <option value="exportPDF">Export PDF</option>
                <option value="delete">Delete</option>
            </select>
            <button wire:click="applyBulkAction" class="btn btn-sm btn-outline-primary p-0"
                style="height: 3em;
                        width: 4.7em;
                            border-top-right-radius: 1.3em;
                            border-bottom-right-radius: 1.3em;
                        "
                type="button" id="button-addon2">OK
            </button>
        </div>


        <!-- Rows Per Page, Search & Hide Columns Section -->
        <!-- Rows Per Page -->
        <div class="input-group col-12 w-100 col-sm-auto w-sm-auto ">
            <label class="input-group-text" for="recordsPerPage"
                style = "
                    height: 2.6em;
                    padding: 0em 1em;
                    border-top-left-radius: 1.3em;
                    border-bottom-left-radius: 1.3em;">Rows</label>
            <select id="recordsPerPage" wire:model.live.500ms="perPage"
                class="form-select form-control ps-sm-2 pe-sm-5"
                style="
                        height: 2.6em;
                        border-top-right-radius: 1.3em;
                        border-bottom-right-radius: 1.3em;">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
                <option value="500">500</option>
            </select>
        </div>

        <!-- Search Box -->
        <div class="input-group mb-2 col-12 w-100 col-sm-auto w-sm-auto">
            <span class="input-group-text"
                style="
                    height: 2.6em;
                    border-top-left-radius: 1.3em;
                    border-bottom-left-radius: 1.3em;"><i
                    class="fas fa-search"></i></span>
            <input wire:model.live.500ms="search" class="form-control" type="search"
                id="search_box" placeholder="Search..."
                style="
                    height: 2.6em;
                    border-top-right-radius: 1.3em;
                    border-bottom-right-radius: 1.3em;">
        </div>

        <!-- Show / Hide Columns -->
        <div class="dropdown col-12 w-100 col-sm-auto w-sm-auto">
            <a href="#" class="btn bg-gradient-primary dropdown-toggle bt-sm pt-2 me-2 w-100"
                data-bs-toggle="dropdown" id="navbarDropdownMenuLink2"
                style="border-radius: 3em; height: 3em">
                <span class="btn-inner--icon"><i
                        class="fa-solid fa-list text-sm me-1 text-white"></i></span>
                <span class="btn-inner--text">Columns</span>
            </a>

            <ul class="dropdown-menu p-3 pt-4" aria-labelledby="navbarDropdownMenuLink2">
                <span class="m-2 text-uppercase text-xs fw-bolder">Show/Hide</span>
                <hr class="m-2 p-0 bg-gray-500" />
                @foreach ($columns as $column)
                    @if (!in_array($column, $hiddenFields['onTable']))
                        <div class="dropdown-item">
                            <div class="form-check">
                                <input class="form-check-input " type="checkbox"
                                    wire:model.defer="selectedColumns" value="{{ $column }}"
                                    class="form-check-input" style="width: 1.2em; height:1.2em"
                                    @if (in_array($column, $visibleColumns)) checked @endif>
                                <span class="ms-2">{{ ucfirst($column) }}</span>
                                </input>
                            </div>
                        </div>
                    @endif
                @endforeach
                <hr class="m-2 p-0 bg-gray-500" />
                <button class="btn btn-sm btn-secondary w-100 mt-2" wire:click="applyColumnChanges"
                    style="border-radius: 2em">OK</button>
            </ul>
        </div>

    </div>
</div>
