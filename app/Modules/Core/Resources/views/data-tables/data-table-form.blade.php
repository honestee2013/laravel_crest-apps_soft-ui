<div >

    {{--<form role="form text-left" wire:submit.prevent="$dispatch('submitDatatableFormEvent')">--}}
    <form role="form text-left" class="p-4 modal-form">
            @foreach (array_keys($fieldDefinitions) as $field)
            <!----  CHECKING IF SHOULD BE DISPLAYED ON FORM    ---->
            @if (($isEditMode && !in_array($field, $hiddenFields['onEditForm'])) ||
                    (!$isEditMode && !in_array($field, $hiddenFields['onNewForm'])))

                    @php

                        $type = $fieldDefinitions[$field];

                        if (is_array($type) && isset($type['field_type'])) {
                            if (isset($type['options'])) {
                                $options = $type['options'];
                            } // Get option before updating '$type'

                            if (isset($type['selected'])) {
                                $selected = $type['selected'];
                            } // Get selected before updating '$type'
                            if (isset($type['display'])) {
                                $display = $type['display'];
                            } // Get display before updating '$type'

                            $type = $type['field_type'];

                            // Handle multi definition fields eg select, chckbox, radio
                        } elseif (is_array($type)) {
                            // Extracting only the 'fieldName' from the array.
                            // THIS MAY NEED MODIFICATION WHEN OTHER ARRAY INFO ARE NEEDED
                            $type = $type['field_type'];
                        }

                    @endphp
                <!----  FORM FIELDS    ---->
                <div class="form-group">
                        {{-------- LABEL --------}}
                        @if (isset($fieldDefinitions[$field]['label']))
                            <label for="{{ $field }}">{{ ucwords($fieldDefinitions[$field]['label']) }}</label>
                        @else
                            <label for="{{ $field }}">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                        @endif


                        <!---- Add  item ---->
                        @if (isset($fieldDefinitions[$field]['relationship'])
                                && isset($fieldDefinitions[$field]['relationship']['inlineAdd'])
                                && $fieldDefinitions[$field]['relationship']['inlineAdd']
                            )
                                <!-- Button to open the secondary modal to add new items -->
                                <span role="button" class="badge rounded-pill bg-primary text-xxs"
                                    onclick="Livewire.dispatch('openAddRelationshipItemModalEvent',
                                        [{{ json_encode($fieldDefinitions[$field]['relationship']['model']) }}
                                        ] )">
                                    Add
                                </span>
                        @endif


                        @if ($type === 'textarea')
                            <textarea wire:model.defer="fields.{{ $field }}" id="{{ $field }}" class="form-control"
                                name = "{{ $field }}" value= "{{ $field }}" rows="3">{{ $fields[$field] ?? '' }}</textarea>

                        @elseif ($type === 'select')
                            <!--------- Opening the Select Element -------->

                            @if ($field && $multiSelectFormFields && in_array($field, array_keys($multiSelectFormFields)))
                                <select multiple wire:model.defer="multiSelectFormFields.{{ $field }}"
                                    name = "{{ $field }}" value= "{{ $field }}" id="{{ $field }}"
                                    class="form-control">
                                @else
                                    <select wire:model.defer="fields.{{ $field }}" name = "{{ $field }}"
                                        value= "{{ $field }}" id="{{ $field }}" class="form-control">
                            @endif

                            @if (isset($fieldDefinitions[$field]['label']))
                                <option style="display:none" value="">Select {{ $fieldDefinitions[$field]['label'] }}...
                                </option>
                            @else
                                <option style="display:none" value="">Select {{ strtolower(str_replace('_', ' ', $field)) }}...</option>
                            @endif

                            @foreach ($options as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach

                            </select>
                            <!--------- Closing the Select Element -------->

                        @elseif ($type === 'checkbox')

                            <!--------- Checkbox on a horizontal line -------->
                            @if (isset($display) && $display == 'inline')<div>@endif
                            @foreach ($options as $key => $value)
                                <div class="form-check"
                                    @if (isset($display) && $display == 'inline') style="display:inline-flex;" @endif>

                                    <!----- Multi-form field selection handled by the Livewire Automatically------>
                                    @if ($field && $multiSelectFormFields && in_array($field, array_keys($multiSelectFormFields)))
                                        <input class="form-check-input" type="{{ $type }}"
                                            id="{{ $key }}"
                                            wire:model.defer="multiSelectFormFields.{{ $field }}"
                                            value="{{ $key }}" {{-- The key should match the saved values --}} name="{{ $field }}">

                                        <!----- Normal field selection handled manually------>
                                    @else
                                        <input class="form-check-input" type="{{ $type }}"
                                            id="{{ $key }}" wire:model.defer="fields.{{ $field }}"
                                            value="{{ $key }}" {{-- Again, using $key to match the saved values --}}
                                            @if (in_array($key, $fields[$field] ?? [])) checked @endif name="{{ $field }}">
                                    @endif

                                    <label class="custom-control-label" for="{{ $key }}"
                                        @if (isset($display) && $display == 'inline') style="margin: 0.25em 2em 1em 0.5em" @endif>{{ $value }}
                                    </label>
                                </div>
                            @endforeach
                            @if (isset($display) && $display == 'inline')</div>@endif
                            <!--------- End Checkbox on a horizontal line -------->

                        @elseif ($type === 'radio')
                            <!--------- Radio button on a horizontal line -------->
                            @if ($display == 'inline')<div>@endif
                            @foreach ($options as $key => $value)
                                <div class="form-check" @if ($display == 'inline') style="display:inline-flex;" @endif>
                                    <input class="form-check-input" type="{{ $type }}" id="{{ $key }}"
                                        wire:model.defer="fields.{{ $field }}" value="{{ $value }}">
                                    <label class="custom-control-label" for="{{ $key }}"
                                        @if ($display == 'inline') style="margin: 0.25em 2em 1em 0.5em" @endif>
                                        {{ $value }}
                                    </label>
                                </div>
                            @endforeach
                            @if ($display == 'inline')</div> @endif
                            <!--------- End button on a horizontal line -------->

                        @elseif ($type === 'file' && in_array($field, $this->getSupportedImageColumnNames()))
                            <!----------- IMAGE INPUT ------------->
                            <div class="row border rounded-3 m-1 p-3">

                                <div class="col-9">
                                    <!--- INPUT Field ---->
                                    <input type="{{ $type }}" wire:model.defer="fields.{{ $field }}" accept="image/*"
                                        id="{{ $field }}" class="form-control rounded-pill" value="{{ $fields[$field] ?? '' }}">

                                    <!--- INPUT Info ---->
                                    @if (isset($fields[$field]) && is_object($fields[$field]) && $fields[$field]->temporaryUrl())
                                        <span class="text-xs">This is the <strong>Selected Image</strong></span>
                                    @elseif(!empty($fields[$field]))
                                        <span class="text-xs">This is the <strong> Current Image</strong></span>
                                    @endif
                                </div>

                                <div class="col-2 rounded border border-red p-1 ms-3 image-container" id="image-container-{{ $field }}">

                                    <!--- IMAGE PREVIEW THUBMNAIL ---->
                                    @if (isset($fields[$field]))
                                        <!------ Crop Thubnail -------->
                                        <img id="image-preview-{{ $field }}" {{-- --------  Selected on the Client side  ---------- --}}
                                            @if (is_object($fields[$field]) && $fields[$field]->temporaryUrl()) src="{{ $fields[$field]->temporaryUrl() }}"

                                                                    {{-- --------  Already exist on the Server side  ---------- --}}
                                                                    @elseif (isset($fields[$field]))
                                                                        src="{{ asset('storage/' . $fields[$field]) }}" @endif
                                            alt="Image Preview" style="width: 100%;" />

                                        <!------ Crop Icon-------->
                                        <span
                                            @if (is_object($fields[$field]) && $fields[$field]->temporaryUrl()) onclick="Livewire.dispatch('openCropImageModalEvent', ['{{ $field }}', '{{ $fields[$field]->temporaryUrl() }}', '{{ $this->getId() }}'])"
                                                                    @else
                                                                        onclick="Livewire.dispatch('openCropImageModalEvent', ['{{ $field }}', '{{ asset('storage/' . $fields[$field]) }}', '{{ $this->getId() }}'])" @endif
                                            class="mx-2" style="" data-bs-toggle="tooltip" data-bs-original-title="Crop">
                                            <span style="cursor: pointer;">
                                                <i class="fas fa-edit text-primary"></i>
                                                <span class="text-xs">Crop</span>
                                            </span>
                                        </span>
                                    @endif

                                </div>
                            </div>
                        @else
                            <!----------- ANY OTHER INPUT ------------->
                            <input type="{{ $type }}" wire:model.defer="fields.{{ $field }}" id="{{ $field }}"
                                class="form-control rounded-pill" value="{{ $fields[$field] ?? '' }}" name="{{ $field }}">
                        @endif

                        <!----------- Validation Error  ------------->
                        @error('fields.' . $field)
                            @php $message = str_replace('characters.', '', $message) @endphp
                            @php $message = str_replace('id', ' ', $message) @endphp
                            <span class="text-danger text-sm mb-0"> {{ str_replace('fields.', ' ', $message) }} </span>
                        @enderror

                        @error('multiSelectFormFields.' . $field)
                            @php $message = str_replace('characters.', '', $message) @endphp
                            @php $message = str_replace('id', ' ', $message) @endphp
                            <span class="text-danger text-sm mb-0"> {{ str_replace('multi select form fields.', ' ', $message) }} </span>
                        @enderror
                </div>

            <!----  END CHECKING IF SHOULD BE DISPLAYED ON FORM    ---->
            @endif
        @endforeach
    </form>

    @include('core.views::data-tables.partials.form-footer', [
        'modalId' => $modalId,
    ])

</div>
