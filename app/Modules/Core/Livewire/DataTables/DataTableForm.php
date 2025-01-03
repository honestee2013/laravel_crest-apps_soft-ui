<?php

namespace App\Modules\Core\Livewire\DataTables;

use Livewire\Form;
use Livewire\Component;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use App\Modules\Core\Events\DataTableFormEvent;
use App\Modules\Core\Events\DataTableFormAfterUpdateEvent;
use App\Modules\Inventory\Livewire\Inventories\InventoryManager;
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

        'refreshFieldsEvent' => 'refreshFields',

        'updateModelFieldEvent' => 'updateModelField',
    ];


    ///////// DEFINED AND PASSED IN BY THE PARENT CLASS /////////
    public $multiSelectFormFields;
    public $fieldDefinitions;
    public $hiddenFields;
    public $columns;
    public $fields;
    public $model;
    public $moduleName;
    public $modelName;

    public $modalId;



    ////// DEFINE BY THIS CLASS //////
    public $selectedItem;
    public $isEditMode;
    public $messages = [];
    public $selectedItemId;
    public $selectedRows = [];
    //public $modalStack;
    public $pageTitle;
    public $queryFilters = [];


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
        Log::info("DataTableForm->refreshFields: ".$this->model);


        foreach ($this->fieldDefinitions as $fieldName => $type) {

            if( // Options field
                isset($this->fieldDefinitions[$fieldName]['options'])
                && isset($this->fieldDefinitions[$fieldName]['relationship'])
                && isset($this->fieldDefinitions[$fieldName]['relationship']["model"])
            ) {

                /*$model = $this->fieldDefinitions[$fieldName]['relationship']["model"];
                $tableName = app($model)->getTable();
                if(Schema::hasColumn($tableName, 'display_name')) // Try using display_name if it exist
                    $this->fieldDefinitions[$fieldName]['options'] = $model::pluck('display_name', 'id')->toArray();
                else // name is always expected to exist
                    if(Schema::hasColumn($tableName, 'name')) // Try using display_name if it exist
                    $this->fieldDefinitions[$fieldName]['options'] = $model::pluck('name', 'id')->toArray();*/

                $configPath = "$this->moduleName.".Str::snake($this->modelName);
                $configPath = strtolower($configPath);
                $this->fieldDefinitions[$fieldName]['options'] = config("$configPath.fieldDefinitions.$fieldName.options");
            }
        }

        $this->dispatch('$refresh');
    }




    public function updateModelField($modelIds, $fieldName, $fieldValue)
    {

        // Ensure $modelIds is an array of integers
        $modelIds = is_array($modelIds) ? array_map('intval', $modelIds) : [intval($modelIds)];

        // Validation
        if (empty($modelIds) || !is_array($modelIds)) {
            throw new InvalidArgumentException("Model IDs must be a non-empty array.");
        }
        // Validation: Ensure all IDs are integers
        foreach ($modelIds as $id) {
            if (!is_numeric($id)) {
                throw new InvalidArgumentException("All Model IDs must be numeric.");
            }
        }

        // Now create or update the model using the sanitized fields array
        if ($this->getConfigFileField($this->moduleName, $this->modelName, "isTransaction")) {
            DB::beginTransaction();
        }

        try {

            // Fetch old records
            $oldRecords = $this->model::whereIn('id', $modelIds)->get();

            // Ensure $modelIds is an array of integers
            $modelIds = is_array($modelIds) ? array_map('intval', $modelIds) : [intval($modelIds)];
            // Sending [After Update Event]
            $oldRecords = $this->model::whereIn('id', $modelIds)->get();
            // Perform the update
            $this->model::whereIn('id', $modelIds)->update([$fieldName => $fieldValue]);
            // Sending [After Update Event]
            $newRecords = $this->model::whereIn('id', $modelIds)->get();

            // Dispatch events
            $this->dispatchAllEvents("BeforeUpdate", $oldRecords, $newRecords);
            $this->dispatchAllEvents("AfterUpdate", $oldRecords, $newRecords);
            $this->dispatch('recordSavedEvent');

        } catch (\Exception $e) {
            if ($this->getConfigFileField($this->moduleName, $this->modelName, "isTransaction")) {
                DB::rollBack(); // Rollback the transaction
            }

            // Log the error or handle the exception as needed
            throw $e;
        }
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
        if ($this->getConfigFileField($this->moduleName, $this->modelName, "isTransaction")) {
            DB::beginTransaction();
        }

        try {

            $record = null;
            if ($this->isEditMode) {
                $record = $this->model::find($this->selectedItemId);
                $oldRecord = $record->toArray();
                // Sending [After Update Event]
                $this->dispatchAllEvents("BeforeUpdate", $oldRecord, $sanitizedFields);
                // Update the record
                $record?->update($sanitizedFields);
                // Sending [After Update Event]
                $this->dispatchAllEvents("AfterUpdate", $oldRecord, $record->toArray());

            } else {
                // Sending [Before Create Event]
                $this->dispatchAllEvents("BeforeCreate", [], $sanitizedFields);
                // Create a new record
                $record = $this->model::create($sanitizedFields);
                // Sending [After Create Event]
                $this->dispatchAllEvents("AfterCreate", [], $record->toArray());
            }

            if ($this->getConfigFileField($this->moduleName, $this->modelName, "isTransaction")) {
                DB::commit(); // Commit the transaction
            }

        } catch (\Exception $e) {
            if ($this->getConfigFileField($this->moduleName, $this->modelName, "isTransaction")) {
                DB::rollBack(); // Rollback the transaction
            }

            // Log the error or handle the exception as needed
            throw $e;
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
                        $record?->update([$foreign_key => $this->fields[$fieldName]]);
                    }
                    // many-to-many
                    else if ($this->fieldDefinitions[$fieldName]['relationship']['type'] == 'belongsToMany') {

                        if (is_array($this->multiSelectFormFields[$fieldName])) {
                            $record?->{$this->fieldDefinitions[$fieldName]['relationship']['dynamic_property']}()
                                ->sync($this->multiSelectFormFields[$fieldName]);
                        }
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
        if (!$this->isEditMode)
            $this->resetFields(); // Next new form should be blank
        $this->dispatch("recordSavedEvent"); // Table refresh
        $this->dispatch('close-modal-event', ["modalId" => $modalId]);  // To show modal
        $this->dispatch('refreshFieldsEvent');  // To show modal

    }


    private function dispatchAllEvents($eventName, $oldRecord, $newRecord) {
        if (!$this->getConfigFileField($this->moduleName, $this->modelName, "dispatchEvents"))
            return;

        // AVAILABLE FOR IMPLEMENTATION EVENTS:
        // DataTableFormEvent, DataTableFormBeforeCreateEvent,  DataTableFormAfterCreateEvent,
        // DataTableFormBeforeUpdateEvent,  DataTableFormAfterUpdateEvent,
        // {AnyModelName}Event, {AnyModelName}BeforeCreateEvent,  {AnyModelName}AfterCreateEvent,
        // {AnyModelName}BeforeUpdateEvent,  {AnyModelName}AfterUpdateEvent,

        // Sending DtatTableForm Generic event
        DataTableFormEvent::dispatch($eventName, $oldRecord, $newRecord);

        // Sending DtatTableForm Specific event eg. DataTableForm{BeforeUpdate}Event
        $dataTableFormEvent = "DataTableForm{$eventName}Event";
        if(class_exists($dataTableFormEvent))
            $dataTableFormEvent::dispatch($eventName, $oldRecord, $newRecord);


        // Specific Model releted eg. {User}BeforeUpdateEvent
        $specificEvent = $this->getSpecificEventFullName($eventName);
        $event = $this->getEventFullName();
        if (class_exists($specificEvent))
            $specificEvent::dispatch($oldRecord, $newRecord);

        // Generic Model releted eg. {User}Event
        if (class_exists($event))
            $event::dispatch($eventName, $oldRecord, $newRecord);
    }






private function getSpecificEventFullName($eventName) {
    return "\\App\\Modules\\{$this->moduleName}\\Events\\{$eventName}".$this->modelName."Event";
}

private function getEventFullName() {
    return "\\App\\Modules\\{$this->moduleName}\\Events\\".$this->modelName."Event";
}



    // Get Dynamic Validation Rules
    public function getDynamicValidationRules()
    {
//dd($this->fieldDefinitions );
        $rules = [];
        foreach ($this->fieldDefinitions as $field => $type) {

            // Check if  the field is not hidden only then validate
            if (
                (!in_array($field, $this->hiddenFields['onEditForm']))
                || (!in_array($field, $this->hiddenFields['onNewForm']))
            ) {

                // Handle multi-select form field validation and messages
                if (isset($this->multiSelectFormFields[$field])
                        && !empty($this->multiSelectFormFields[$field])
                    ) {

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
        if ($record && $this->multiSelectFormFields) {
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
                        if ($this->fieldDefinitions[$fieldName]['relationship']['dynamic_property']
                            && $record->{$this->fieldDefinitions[$fieldName]['relationship']['dynamic_property']}
                        ) {

                            $this->multiSelectFormFields[$fieldName]
                                = $record->{$this->fieldDefinitions[$fieldName]['relationship']['dynamic_property']}
                                    ->pluck('id')->toArray();
                        }
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
        return view('core.views::data-tables.data-table-form');
    }

}
