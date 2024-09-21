

<section>
    <!------------------ Content ----------------->
    <!------ Card ---------->
    <div class="card mb-4 mx-4 p-4">
        <!----- Card Header -------->
        <div class="card-header pb-0">
            <div class="d-flex flex-row justify-content-between">
                <div>
                    <h5 class="mb-0">All {{ Str::plural(ucfirst($modelName)) }}</h5>
                </div>
                <button wire:click="openAddModal()" class="btn bg-gradient-secondary btn-icon-only rounded-circle"
                    type="button">
                    <i class="fa-solid fa-plus   text-white"></i>
                </button>
            </div>
        </div>

        @include('livewire.data-tables.partials.spinner')

        <!------------------- CARD BODY CONTENT ------------------->
        <div class="card-body px-0 pt-0 pb-2" style="overflow: scroll">

            @include('livewire.data-tables.partials.feedback-messages')

            <div class="table-responsive p-0">
                @include('livewire.data-tables.partials.table-header')
                @include('livewire.data-tables.partials.table-body')
                @include('livewire.data-tables.partials.table-footer')
            </div>
        </div>

        <!----------- SHOW DETAIL MODAL ------------->
        @include('livewire.data-tables.partials.show-deatial-modal')

        <!------------------- ADD EDIT MODAL ------------------------>
        @include('livewire.data-tables.partials.add-edit-modal')
    </div>

</section>

@include('livewire.data-tables.assets.assets')
@include('livewire.data-tables.assets.scripts')





