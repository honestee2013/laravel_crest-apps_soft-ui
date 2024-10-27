<?php

namespace App\Modules\Core\Livewire\DataTables;

use Livewire\Form;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Modules\Core\Traits\DataTable\DataTableFieldsConfigTrait;


class DataTableForm extends Component
{

    use WithFileUploads, DataTableFieldsConfigTrait;

    //////  EVENT LISTENERS  //////
    protected $listeners = [
        'openEditModalEvent' => 'openEditModal',
        'openAddModalEvent' => 'openAddModal',
        'openDetailModalEvent' => 'openDetailModal',

        'openCropImageModalEvent' => 'openCropImageModal',
        'saveCroppedImageEvent' => 'saveCroppedImage',

        'deleteSelectedEvent' => 'deleteSelected',
        'confirmDeleteEvent' => 'confirmDelete',

        'resetFormFieldsEvent' => 'resetFields',
        'submitDatatableFormEvent' => 'saveRecord',

        'refreshFieldsEvent' => 'refreshFields'
    ];


    ///////// DEFINED AND PASSED IN BY THE PARENT CLASS /////////
    public $multiSelectFormFields;
    public $fieldDefinitions;
    public $hiddenFields;
    public $columns;
    public $fields;
    public $model;
    public $modalId;



    ////// DEFINE BY THIS CLASS //////
    public $selectedItem;
    public $isEditMode;
    public $messages = [];
    public $selectedItemId;
    public $selectedRows = [];
    //public $modalStack;



    public function mount()
    {

        $this->dispatch("addModalFormComponentStackEvent", $this->getId()); // Close the model

        Log::info("DataTableForm->mount(): ".$this->getId());

        // Initialize fields with keys from fieldDefinitions
        foreach ($this->fieldDefinitions as $field => $type) {
            $this->fields[$field] = null; // Default values (null or empty)
        }
    }


    public function refreshFields() {
        Log::info("DataTableForm->refreshFields(): ".$this->getId());

        $modelName = class_basename($this->model);
        $moduleName = $this->extractModuleNameFromModel($this->model);

        $moduleName = strtolower($moduleName);
        $modelName = strtolower($modelName);
        $data = $this->configTableFields($moduleName, $modelName);
        $this->fieldDefinitions = $data["fieldDefinitions"];
    }


    // Save Record Method (Add or Edit)
    public function saveRecord($modalId)
    {

        Log::info("DataTableForm->saveRecord(): ".$this->getId());


        // Retrieve dynamic validation rules
        $validationData = $this->getDynamicValidationRules();
        $validationMsgs = []; // ///To be implemented later


        // Validate inputs, including any custom messages
        if ($validationData)
            $this->validate($validationData, [...$this->messages, ...$validationMsgs]);

        // Handle file uploads for image, photo & picture fields
        foreach ($this->getSupportedImageColumnNames() as $imageField) {
            if (isset($this->fields[$imageField]) && is_object($this->fields[$imageField])) {
                // Validate file type (e.g., ensure it's an image)
                if (!$this->fields[$imageField]->isValid()) {
                    throw new \Exception('Invalid file upload.');
                }

                $path = $this->fields[$imageField]->store('uploads', 'public'); // Use Laravel's Storage system
                $this->fields[$imageField] = $path; // Add the file path to the fields array
            }
        }


        // Handle simple (No Relationship involved) multi-select form fields (convert them to JSON for storage)
        if ($this->multiSelectFormFields) {
            foreach ($this->multiSelectFormFields as $fieldName => $value) {
                // Json_encode returns "['item1', 'item2']"
                $this->fields[$fieldName] = json_encode($value); // Store multi-select fields as JSON
            }
        }


        // Ensure only allowed fields are saved (whitelisting)
        //$allowedFields = ['name', 'email', 'location', 'photo']; // Define which fields are allowed to be updated/created
        $allowedFields = $this->columns;
        if ($this->isEditMode)
            $allowedFields = array_diff($allowedFields, $this->hiddenFields['onEditForm']);
        else
            $allowedFields = array_diff($allowedFields, $this->hiddenFields['onNewForm']);

        $sanitizedFields = array_filter(
            $this->fields,
            fn($key) => in_array($key, $allowedFields),
            ARRAY_FILTER_USE_KEY
        );


        // Now create or update the model using the sanitized fields array
        $record = null;
        if ($this->isEditMode) {
            $record = $this->model::find($this->selectedItemId);
            $record->update($sanitizedFields); // Update the record with sanitized fields
        } else {
            $record = $this->model::create($sanitizedFields); // Create a new record with sanitized fields
        }


        // Handle complex (Relationship involved) multi-select form fields
        //if ($this->multiSelectFormFields && $record) {
        foreach ($this->fieldDefinitions as $fieldName => $value) {

            // Handle the array of company IDs and bulk update the location_id for all companies at once
            if (
                isset($this->fieldDefinitions[$fieldName]['relationship'])
                && isset($this->fieldDefinitions[$fieldName]['relationship']['type'])
                && isset($this->fieldDefinitions[$fieldName]['relationship']['model'])
                && isset($this->fieldDefinitions[$fieldName]['relationship']['dynamic_property'])
            ) {

                // many-to-one & one-to-many
                if (isset($this->fieldDefinitions[$fieldName]['relationship']['foreign_key'])) {

                    $foreign_key = $this->fieldDefinitions[$fieldName]['relationship']['foreign_key'];
                    // one-to-many
                    if ($this->fieldDefinitions[$fieldName]['relationship']['type'] == 'hasMany') {
                        if (is_array($this->multiSelectFormFields[$fieldName])) {
                            // Clean up the previous links
                            $record->{$this->fieldDefinitions[$fieldName]['relationship']['dynamic_property']}()
                                ->update([$foreign_key => null]);
                            // Attach new links
                            $this->fieldDefinitions[$fieldName]['relationship']['model']
                                ::whereIn('id', $this->multiSelectFormFields[$fieldName])->update([$foreign_key => $record->id]);
                        }

                    }
                    // many-to-one
                    else if ($this->fieldDefinitions[$fieldName]['relationship']['type'] == 'belongsTo') {
                        $record->update([$foreign_key => $this->fields[$fieldName]]);
                    }
                }
                // many-to-many
                else if ($this->fieldDefinitions[$fieldName]['relationship']['type'] == 'belongsToMany') {
                    if (is_array($this->multiSelectFormFields[$fieldName])) {
                        $record->{$this->fieldDefinitions[$fieldName]['relationship']['dynamic_property']}()
                            ->sync($this->multiSelectFormFields[$fieldName]);
                    }
                }

            }

        }


        // Display saving success message
        $this->dispatch('swal:success', [
            'title' => 'Success!',
            'text' => 'Record saved successfully.',
            'icon' => 'success',
        ]);



        // Close the modal, reset fields and refresh the table after saving
        $this->resetFields(); // Next new form should be blank
        $this->dispatch("recordSavedEvent"); // Table refresh
        $this->dispatch('close-modal-event', ["modalId" => $modalId]);  // To show modal
        $this->dispatch('close-modal-event', ["modalId" => $modalId]);  // To show modal
        $this->dispatch('refreshFieldsEvent');  // To show modal

    }





    // Get Dynamic Validation Rules
    public function getDynamicValidationRules()
    {
        $rules = [];
        foreach ($this->fieldDefinitions as $field => $type) {

            // Check if  the field is not hidden only then validate
            if (
                (!in_array($field, $this->hiddenFields['onEditForm']))
                || (!in_array($field, $this->hiddenFields['onNewForm']))
            ) {

                // Handle multi-select form field validation and messages
                if (!empty($this->multiSelectFormFields)) {
                    foreach (array_keys($this->multiSelectFormFields) as $fieldName) {
                        $validationFiedName = 'multiSelectFormFields.' . $fieldName;
                        if (isset($this->fieldDefinitions[$fieldName]) && isset($this->fieldDefinitions[$fieldName]['validation'])) {
                            $rules[$validationFiedName] = $this->fieldDefinitions[$fieldName]['validation'];
                        }
                    }

                } else {

                    // Check if validation exists in fieldDefinitions  not on multiselect
                    if (isset($this->fieldDefinitions[$field]['validation'])) {
                        // Apply validation directly for non-image fields only

                        if (!in_array($field, $this->getSupportedImageColumnNames())) {
                            // Handle the multiSelectFormFields outside this loop
                            //if (is_array($this->multiSelectFormFields) && !in_array($field, array_keys($this->multiSelectFormFields)))
                            $rules["fields.$field"] = $this->fieldDefinitions[$field]['validation'];
                        }
                        // Apply validation for image fields only if the image is an object (i.e., uploaded)
                        else if (is_object($this->fields[$field])) {
                            $rules["fields.$field"] = $this->fieldDefinitions[$field]['validation'];
                        }
                    }
                }
            }
        }


        return $rules;
    }


    // Method to open the Edit Modal
    public function openEditModal($id, $model)
    {
        Log::info("DataTableForm->openEditModal(): Id: ".$id." this->model: ".$this->model);
        Log::info("DataTableForm->openEditModal(): Id: ".$id." model: ".$model);
        Log::info("DataTableForm->openEditModal(): ".$this->getId());

        // Reset multiple opend modal component to release space
        $this->dispatch('checkPageRefreshTimeEvent');

        // Reset all the form fields and make new ones
        $this->resetFields();

        $record = $model::find($id);
        $this->selectedItemId = $record->id;

        foreach ($this->fieldDefinitions as $field => $type) {
            $this->fields[$field] = $record->$field;
        }
        // handle multi-selection form field
        if ($this->multiSelectFormFields) {
            foreach (array_keys($this->multiSelectFormFields) as $fieldName) {
                // Handle hasMany relationship different
                if (
                    isset($this->fieldDefinitions[$fieldName]['relationship'])
                    && isset($this->fieldDefinitions[$fieldName]['relationship']['type'])
                ) {
                    if (
                        $this->fieldDefinitions[$fieldName]['relationship']['type'] == 'hasMany'
                        || $this->fieldDefinitions[$fieldName]['relationship']['type'] == 'belongsToMany'
                    ) {
                        if (isset($this->fieldDefinitions[$fieldName]['relationship']['dynamic_property']))
                            $this->multiSelectFormFields[$fieldName]
                                = $record->{$this->fieldDefinitions[$fieldName]['relationship']['dynamic_property']}
                                    ->pluck('id')->toArray();
                    }


                }
                // Handle other: multiSelect & hasOne relationship same
                else {
                    // Initialise the $multiSelectFormFields array with record values
                    //if ($record->$fieldName) // for empty record, Empty array '[]' is needed instead of NULL
                    $this->multiSelectFormFields[$fieldName] = json_decode($record->$fieldName) ?? [];
                }
            }
        }


        $this->isEditMode = true;
        //$this->dispatch('open-add-edit-modal' );
        //$this->dispatch('show-modal-main' );
        $this->dispatch('open-modal-event', ["modalId" => "addEditModal"]);  // To show modal

        $this->dispatch('changeFormModeEvent', ['mode' => 'edit']);
    }



    //////////////////// CROPPING IMAGE  /////////////////////
    public function showCropImageModal($field, $imgUrl)
    {
        $this->dispatch('show-crop-image-modal', ['field' => $field, 'imgUrl' => $imgUrl, 'id' => $this->getId()]);
    }



    public function saveCroppedImage($field, $croppedImageBase64, $id)
    {
        // Validate the Base64 string format
        if (!preg_match('/^data:image\/(jpg|jpeg|png);base64,/', $croppedImageBase64, $matches)) {
            // Handle invalid image format
            throw new \Exception('Invalid image format.');
        }

        // Extract the file extension from the Base64 string
        $extension = $matches[1] == 'jpeg' ? 'jpg' : $matches[1];

        // Decode the Base64 string to binary data
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $croppedImageBase64));

        // Generate a unique file name
        $fileName = 'cropped_image_' . time() . '.' . $extension;

        // Use Laravel's Storage facade to save the file in a secure way
        $filePath = 'uploads/' . $fileName;


        // Save the file to the disk (public disk)
        Storage::disk('public')->put($filePath, $imageData);

        // Update the field with the relative file path
        $this->fields[$field] = $filePath;

        // Dispatch success notification
        $this->dispatch('swal:success', [
            'title' => 'Success!',
            'text' => 'Image was cropped successfully!',
            'icon' => 'success',
        ]);
    }



    // Reset the form fields
    public function resetFields()
    {
        // Handle multi selection form fields
        foreach ($this->fieldDefinitions as $field => $type) {
            $this->fields[$field] = null; // Reset each field
            if (isset($this->multiSelectFormFields[$field]))
                $this->multiSelectFormFields[$field] = [];
        }
        $this->selectedItemId = null;
    }



    ////////////////////// ADD EDIT MODAL ///////////////////
    // Method to open the Add Modal
    public function openAddModal()
    {
        // Reset multiple opend modal component to release space
        $this->dispatch('checkPageRefreshTimeEvent');

        $this->resetFields();
        $this->isEditMode = false;
        //$this->dispatch('open-add-edit-modal');
        $this->dispatch('open-modal-event', ["modalId" => "addEditModal"]);  // To show modal

        $this->dispatch('changeFormModeEvent', ['mode' => 'new']);
    }


    ////////////////////// CONFIRM DELETE /////////////////////
    public function confirmDelete($ids)
    {

        // Sanitize the input
        if (is_array($ids)) {
            $ids = array_filter(
                $ids,
                fn($index) => intval($ids[$index]),
                ARRAY_FILTER_USE_KEY
            );
        } else {
            $ids = [intval($ids)];
        }

        $this->selectedRows = $ids;
        // Emit an event to trigger SweetAlert
        $this->dispatch('confirm-delete');
    }


    public function deleteSelected()
    {
        $this->model::whereIn('id', $this->selectedRows)->delete();
        $this->resetSelection();
        $this->dispatch('swal:success', [
            'title' => 'Success!',
            'text' => 'Record deleted successfully.',
            'icon' => 'success',
        ]);
        $this->dispatch("recordDeletedEvent");
    }


    private function resetSelection()
    {
        $this->selectedRows = [];
        $this->selectedItem = '';
        $this->selectedItemId = '';
    }


    ///////////////////// SHOW DETAIL MODAL //////////////////
    public function openDetailModal($id, $model)
    {
        // Load the selected item details from the database
        $this->selectedItem = $model::findOrFail($id);
        // Emit event to trigger the modal
        $this->dispatch('changeSelectedItemEvent', $id);
        //$this->dispatch('open-show-item-detail-modal');
        $this->dispatch('open-modal-event', ["modalId" => "detail", "modalClass" => "childModal"]);
    }


    public function render()
    {
        return view('core::data-tables.data-table-form');
    }

}
