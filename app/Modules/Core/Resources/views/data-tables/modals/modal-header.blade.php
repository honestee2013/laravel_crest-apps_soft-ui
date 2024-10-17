
        <div wire:ignore.self class="modal fade" id="{{$modalId?? 'addEditModal'}}" tabindex="-1"
            role="dialog"aria-labelledby="addEditModalLabel" aria-hidden="true" wire:key='"{{$modalId}}'>

            <div class="modal-dialog modal-dialog-centered {{ $modalClass?? 'modal-lg' }} " role="document">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-left">
                                <h4 class="font-weight-bolder text-info text-gradient">
                                    {{ $isEditMode ? 'Edit Record' : 'New Record' }}</h4>
                            </div>
