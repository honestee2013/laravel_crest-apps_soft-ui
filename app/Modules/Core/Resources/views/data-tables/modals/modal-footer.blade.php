
        </div> {{--modal-body  ends --}}

        <div>
            <hr class="horizontal dark my-0" />
        </div>

        <!-- Form Buttons -->
        <div class="d-flex justify-content-end m-4">
            <button type="button" class="btn bg-gradient-secondary rounded-pill me-2"
            {{--click="$dispatch('close-modal{{ $modalId }}')"--}}
            onclick="Livewire.dispatch('close-modal-event', [{'modalId': '{{$modalId}}' }])">Close</button>
            @if ($modalId !== "detail") {{--Only show on form--}}
                <button type="button" class="btn bg-gradient-primary rounded-pill"
                    onclick="Livewire.dispatch('submitDatatableFormEvent', ['{{$modalId}}'])">
                    {{ $isEditMode ? 'Save Changes' : 'Add Record' }}
                </button>
            @endif
        </div>

    </div>
</div>

