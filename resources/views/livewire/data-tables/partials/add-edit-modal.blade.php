        <!-- Add/Edit Modal -->
        <div wire:ignore.self class="modal fade" id="addEditModal" tabindex="-1"
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

                                <form role="form text-left">
                                    @foreach (array_keys($fieldDefinitions) as $field)
                                        @if ((($isEditMode && !in_array($field, $hiddenFields['onEditForm']))) || (!$isEditMode && !in_array($field, $hiddenFields['onNewForm'])))
                                            @php

                                                $type = $fieldDefinitions[$field];

                                                if (is_array($type) && isset($type['field_type'])) {

                                                    if(isset($type['options']))
                                                        $options = $type['options']; // Get option before updating '$type'

                                                    if(isset($type['selected']))
                                                        $selected = $type['selected']; // Get selected before updating '$type'
                                                    if(isset($type['display']))
                                                        $display = $type['display']; // Get display before updating '$type'

                                                    $type = $type['field_type'];

                                                    // Handle multi definition fields eg select, chckbox, radio
                                                } elseif (is_array($type)) {
                                                    // Extracting only the 'fieldName' from the array.
                                                    // THIS MAY NEED MODIFICATION WHEN OTHER ARRAY INFO ARE NEEDED
                                                    $type = $type['field_type'];
                                                }

                                            @endphp
                                            <div class="form-group">
                                                @if(isset($fieldDefinitions[$field]['label']))
                                                    <label for="{{ $field }}">{{ ucwords($fieldDefinitions[$field]['label']) }}</label>
                                                @else
                                                    <label for="{{ $field }}">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                                                @endif

                                                @if ($type === 'textarea')
                                                    <textarea wire:model.defer="fields.{{ $field }}" id="{{ $field }}" class="form-control"
                                                            name = "{{$field}}" value= "{{$field}}"
                                                        rows="3">{{ $fields[$field] ?? '' }}</textarea>
                                                @elseif ($type === 'select')
                                                    <!--------- Opening the Select Element -------->

                                                    @if ($field && $multiSelectFormFields && in_array($field, array_keys($multiSelectFormFields)))
                                                        <select multiple
                                                            wire:model.defer="multiSelectFormFields.{{ $field }}"
                                                             name = "{{$field}}" value= "{{$field}}"
                                                            id="{{ $field }}" class="form-control">
                                                    @else
                                                            <select wire:model.defer="fields.{{ $field }}"
                                                                name = "{{$field}}" value= "{{$field}}"
                                                                id="{{ $field }}" class="form-control">
                                                    @endif

                                                    @if(isset($fieldDefinitions[$field]['label']))
                                                        <option style="display:none" value="">Select {{ $fieldDefinitions[$field]['label'] }}</option>
                                                    @else
                                                        <option style="display:none" value="">Select {{ $field }}</option>
                                                    @endif

                                                    @foreach ($options as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                    @endforeach
                                                    </select> <!--------- Closing the Select Element -------->
                                                @elseif ($type === 'radio')
                                                    @if ($display == 'inline')
                                                        <div>
                                                    @endif

                                                    @foreach ($options as $key => $value)
                                                        <div class="form-check"
                                                            @if ($display == 'inline') style="display:inline-flex;" @endif>
                                                            <input class="form-check-input"
                                                                type="{{ $type }}" id="{{ $key }}"
                                                                wire:model.defer="fields.{{ $field }}"
                                                                value="{{ $value }}">
                                                            <label class="custom-control-label"
                                                                for="{{ $key }}"
                                                                @if ($display == 'inline') style="margin: 0.25em 2em 1em 0.5em" @endif>
                                                                {{ $value }}
                                                            </label>
                                                        </div>
                                                    @endforeach

                                                    @if ($display == 'inline')
                                            </div>
                                        @endif
                                        @elseif ($type === 'checkbox')
                                            @if (isset($display) && $display == 'inline')
                                                <div>
                                            @endif
                                            @foreach ($options as $key => $value)
                                                <div class="form-check"
                                                    @if (isset($display) && $display == 'inline') style="display:inline-flex;" @endif>




                                                    @if ($field && $multiSelectFormFields && in_array($field, array_keys($multiSelectFormFields)))
                                                        <input class="form-check-input" type="{{ $type }}"
                                                            id="{{ $key }}"
                                                            wire:model.defer="multiSelectFormFields.{{ $field }}"
                                                            value="{{ $key }}" {{-- The key should match the saved values --}}




                                                            name="{{ $field }}">
                                                    @else
                                                        <input class="form-check-input" type="{{ $type }}"
                                                            id="{{ $key }}"
                                                            wire:model.defer="fields.{{ $field }}"
                                                            value="{{ $key }}" {{-- Again, using $key to match the saved values --}}
                                                            @if(in_array($key, $fields[$field] ?? [])) checked @endif
                                                            name="{{ $field }}">
                                                    @endif

                                                    <label class="custom-control-label" for="{{ $key }}"
                                                        @if (isset($display) && $display == 'inline') style="margin: 0.25em 2em 1em 0.5em" @endif>{{ $value }}
                                                    </label>
                                                </div>
                                            @endforeach
                                            @if (isset($display) && $display == 'inline')
                                            </div>
                                            @endif
                                        @elseif ($type === 'file' && ($field == 'image' || $field == 'photo' || $field == 'picture'))
                                            <!----------- IMAGE INPUT ------------->
                                            <div class="row border rounded-3 m-1 p-3">
                                                <div class="col-9">
                                                    <input type="{{ $type }}" wire:model.defer="fields.{{ $field }}" accept="image/*"
                                                        id="{{ $field }}" class="form-control rounded-pill"
                                                        value="{{ $fields[$field] ?? '' }}">
                                                    @if (isset($fields[$field]) && is_object($fields[$field]) && $fields[$field]->temporaryUrl())
                                                        <span class="text-xs">This is the <strong>Selected Image</strong></span>
                                                    @elseif(!empty($fields[$field]))
                                                        <span class="text-xs">This is the <strong> Current Image</strong></span>
                                                    @endif
                                                </div>
                                                <div class="col-2 rounded border border-red p-1 ms-3 image-container"
                                                    id="image-container-{{ $field }}">
                                                    @if (isset($fields[$field]) && is_object($fields[$field]) && $fields[$field]->temporaryUrl())
                                                        <img id="image-preview-{{ $field }}"
                                                            src="{{ $fields[$field]->temporaryUrl() }}" alt="Image Preview"
                                                            style="width: 100%;">
                                                        <span
                                                            wire:click="showCropImageModal('{{ $field }}', '{{ $fields[$field]->temporaryUrl() }}')"
                                                            class="mx-2" style="" data-bs-toggle="tooltip"
                                                            data-bs-original-title="Crop">
                                                            <span style="cursor: pointer;"><i class="fas fa-edit text-primary"></i>
                                                                <span class="text-xs">Crop</span></span>
                                                        </span>
                                                    @elseif(isset($fields[$field]) && $isEditMode)
                                                        <img id="image-preview-{{ $field }}"
                                                            src="{{ asset('storage/' . $fields[$field]) }}" alt="Current Image"
                                                            style="width: 100%;">
                                                        <span
                                                            wire:click="showCropImageModal('{{ $field }}', 'storage/{{ $fields[$field] }}')"
                                                            class="mx-2" style="" data-bs-toggle="tooltip"
                                                            data-bs-original-title="Crop">
                                                            <span style="cursor: pointer;"><i class="fas fa-edit text-primary"></i>
                                                                <span class="text-xs">Crop</span></span>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <!----------- SHOW CROP IMAGE MODAL - FOR EACH IMAGE INPUT ------------->
                                            <div class="modal fade" id="crop-modal-{{ $field }}"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                                    <div class="modal-content p-4">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title font-weight-bolder text-info text-gradient"
                                                                id="exampleModalLabel">
                                                                Crop Image
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body my-2  p-2 border rounded-3">
                                                            <div id="cropper-container-{{ $field }}"
                                                                style="width: 100%; height: 70vh;" wire:ignore>
                                                                <img id="image-to-crop-{{ $field }}" src=""
                                                                    alt="Image to Crop" style="width: 100%;" />
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button id="save-croped-image-{{ $field }}" type="button"
                                                                class="btn btn-primary">OK</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <input type="{{ $type }}" wire:model.defer="fields.{{ $field }}"
                                                id="{{ $field }}" class="form-control rounded-pill"
                                                value="{{ $fields[$field] ?? '' }}" name="{{ $field }}">
                                            @endif

                                            @error('fields.' . $field)
                                                <span class="text-danger text-sm mb-0">  {{ str_replace('fields.', ' ', $message) }} </span>
                                            @enderror
                                            @error('multiSelectFormFields.' . $field)
                                                @php $message = str_replace('characters.', '', $message) @endphp
                                                @php $message = str_replace('id', ' ', $message) @endphp
                                                <span class="text-danger text-sm mb-0"> {{ str_replace('multi select form fields.', ' ', $message) }} </span>
                                            @enderror
                                        </div>
                                        @endif
                                    @endforeach
                                </form>

                            </div>

                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary rounded-pill"
                            data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn bg-gradient-primary rounded-pill"
                            wire:click="saveRecord">{{ $isEditMode ? 'Save Changes' : 'Add Record' }}</button>
                    </div>
                </div>
            </div>
        </div>
