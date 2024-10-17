<div wire:ignore.self class="modal fade" id="addEditModal{{ $modalId ?? '' }}" tabindex="-1"
    role="dialog"aria-labelledby="addEditModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header pb-0 text-left">
                        <h4 class="font-weight-bolder text-info text-gradient">
                            {{ $isEditMode ? 'Edit Record' : 'Add New Record' }}</h4>
                        <!--<p class="mb-0">Enter your email and password to sign in</p>-->
                    </div>

                    <div class="card-body">
                        @include('core::data-tables.partials.data-table-form')
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary rounded-pill"
                            data-bs-dismiss="modal">Close</button>
                        <button type="button" data-bs-dismiss="modal" class="btn bg-gradient-primary rounded-pill"
                            wire:click="saveRecord">{{ $isEditMode ? 'Save Changes' : 'Add Record' }}</button>
                    </div>
                </div>
            </div>
        </div>


    {{--</div> THIS WILL BE ADDED BY THE MODAL FOOTER

</div>--}}
