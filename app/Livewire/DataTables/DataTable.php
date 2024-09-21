<?php

namespace App\Livewire\DataTables;

use Livewire\Component;
use App\Exports\DataExport;

use App\Imports\DataImport;
use Illuminate\Support\Str;
use Livewire\WithPagination;

use Livewire\WithFileUploads;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Validators\ValidationException;
use Illuminate\Database\UniqueConstraintViolationException;




class DataTable extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $messages = [];
    public $file;

    public $search = '';
    public $perPage = 10;
    public $model; // To accept the model class
    public $modelName; // To keep the model user friendly name
    public $columns = []; // Columns to display and search
    public $fields = []; // Dynamically stores the field values
    public $fieldDefinitions; // Field types and labels
    public $sortField = 'id'; // Default sort field
    public $sortDirection = 'asc'; // Default sort direction
    public $visibleColumns = [];
    /*public $hiddenFieldsOnShow = [];
    public $hiddenFieldsOnIndex = [];
    public $hiddenFieldsOnCreate = [];
    public $hiddenFieldsOnUpdate = [];
    public $hiddenFieldsOnExport = [];*/
    public $hiddenFields;
    public $multiSelectFormFields;

    public $moreActions;



    public $selectAll = false;
    public $selectedRows = [];
    public $selectedItem;
    public $selectedItemId;
    public $bulkAction = '';

    public $selectedColumns;

    public $title = "Data Table";
    public $simpleActions = [];

    public $isEditMode = false;



    protected $listeners = ['refreshDataTable' => '$refresh'];

    public function mount($model, $fieldDefinitions, $hiddenFields, $simpleActions)
    {
        if(!isset($this->hiddenFields['onTable']))
            $this->hiddenFields['onTable'] = [];
        if(!isset($this->hiddenFields['onDetail']))
            $this->hiddenFields['onDetail'] = [];
        if(!isset($this->hiddenFields['onNewForm']))
            $this->hiddenFields['onNewForm'] = [];
        if(!isset($this->hiddenFields['onEditForm']))
            $this->hiddenFields['onEditForm'] = [];


        if (empty($this->fieldDefinitions)) {
            $tableName = (new $model)->getTable();
            $this->fieldDefinitions = $this->getTableFieldsWithTypes($tableName);
        }

        $this->model = $model;
        $this->modelName = class_basename($model);

        // Handle multi selection form fields
        foreach(array_keys($this->fieldDefinitions) as $fieldName) {
            $this->columns[] = $fieldName;
            if (is_array($this->fieldDefinitions[$fieldName]) &&  isset($this->fieldDefinitions[$fieldName]['multiSelect']))
                $this->multiSelectFormFields[$fieldName] = [];

        }

        $this->visibleColumns = $this->columns; // Show all columns by default
        // Hidden on table index view
        if ($this->hiddenFields['onTable'])
            $this->visibleColumns = array_diff($this->visibleColumns, $this->hiddenFields['onTable']);

        $this->selectedColumns = [...$this->visibleColumns];

        //$this->simpleActions = $simpleActions;
        //$this->hiddenFields = array_merge()
    }


    public function getTableFieldsWithTypes($tableName)
    {
        // Query the INFORMATION_SCHEMA to get column names and types
        $columns = DB::select(
            "SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$tableName' AND TABLE_SCHEMA = '".env('DB_DATABASE')."'"
        );

        // Prepare an array to store columns and their types
        $fields = [];
        foreach ($columns as $column) {
            $fields[$column->COLUMN_NAME] = $column->DATA_TYPE;
        }

        return $fields;
    }





    public function updatingSearch()
    {
        $this->resetPage();
        $this->resetSelection();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
        $this->resetSelection();
    }

    /**
     * Set the sorting field and direction.
     *
     * @param string $field
     * @return void
     */
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            // If already sorting by this field, toggle the direction
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            // Otherwise, set to sort by this field in ascending order
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
        $this->resetSelection();

    }



    public function applyColumnChanges()
    {
        // Update visibleColumns with the selectedColumns
        $this->visibleColumns = $this->selectedColumns;

        // Reset pagination or do any additional processing
        $this->resetPage();
    }





    public function export($format, $fileName="")
    {
        if (!$fileName)
            $fileName = $this->modelName."-Record";

        if ($format === 'pdf') {
            return $this->exportToPdf($fileName);
        }

        return Excel::download(new DataExport($this->getExportData()), "{$fileName}.{$format}");
        //return Excel::download(new DataExport($data, $this->columns), 'data.xlsx');

    }




    private function getExportData()
    {
        return $this->model::query()
            ->when($this->search, function ($query) {
                foreach ($this->columns as $column => $label) {
                    $query->orWhere($column, 'like', "%{$this->search}%");
                }
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->take($this->perPage)  // Limit the number of records to the per-page value
            ->get($this->visibleColumns);
    }



    public function exportToPdf($fileName="")
    {
        if (!$fileName)
            $fileName = $this->modelName."-Record";

        $data = $this->getExportData();
        $pdf = Pdf::loadView('exports.data-table-pdf', [
            'data' => $data,
            'columns' => $this->columns
        ]);

        return response()->streamDownload(function () use ($pdf, $fileName) { echo $pdf->download($fileName.'.pdf'); }, $fileName.'.pdf');

    }




    /////////////////// BULK ACTION ////////////////////////
    public function updatedSelectAll($value)
    {
        if ($value) {
            $query = app($this->model)->newQuery();

            // Apply search filters
            if (!empty($this->search)) {
                $query->where(function($q) {
                    foreach ($this->columns as $column) {
                        $q->orWhere($column, 'like', '%' . $this->search . '%');
                    }
                });
            }

            // Apply sorting
            $query->orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage);;
            $this->selectedRows = $query->pluck('id')->toArray();

        } else {
            $this->selectedRows = [];
        }
    }

    public function applyBulkAction()
    {
        switch ($this->bulkAction) {
            case 'delete':
                //$this->deleteSelected();
                return $this->confirmDelete($this->selectedRows);
            case 'exportXLSX':
                return $this->exportSelected("xlsx");
            case 'exportCSV':
                return $this->exportSelected("csv");
            case 'exportPDF':
                return $this->exportSelected("pdf");
            default:
                break;
        }
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
    }

    private function exportSelected($format, $fileName="")
    {

        if (!$fileName)
            $fileName = "Selected-".$this->modelName."-Record";

        $data = $this->model::whereIn('id', $this->selectedRows)->get($this->visibleColumns);
        if ($format === 'pdf') {
            $pdf = Pdf::loadView('exports.data-table-pdf',[
                'data' => $data,
                'columns' => $this->columns
            ]);
            return response()->streamDownload(function () use ($pdf, $fileName) { echo $pdf->download($fileName.'.pdf'); }, $fileName.'.pdf');
        }

        return Excel::download(new DataExport($data), "{$fileName}.{$format}");
    }

    private function resetSelection()
    {
        $this->selectAll = false;
        $this->selectedRows = [];
    }






    ///////////////////////// IMPORT FUNTIONALITY /////////////////
    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);


        try {
            Excel::import(new DataImport($this->model, $this->columns), $this->file->path());

            session()->flash('success_message', 'Data Imported Successfully!');
        } catch (ValidationException $e) {
            // Handle Excel validation errors
            session()->flash('error', 'There was a validation error in the imported file.');

        } catch (UniqueConstraintViolationException $e) {
            session()->flash('error', 'There was a database error during the import. Please check... It seems like some rows where already imported from the file to the database!');
        } catch (QueryException $e) {
            // Handle database-related errors (e.g., incorrect data types)
            session()->flash('error', 'There was a database error during the import.  Please check... It seems like the columns in the table do not tally with the ones in the database!');
        } catch (\Exception $e) {
            // Catch any other general exceptions
            session()->flash('error', 'An error occurred while importing the data.');
        }
    }




    //////////////////// CROPPING IMAGE  /////////////////////
    public function showCropImageModal($field, $imgUrl)
    {
        $this->dispatch('show-crop-image-modal', ['field' => $field, 'imgUrl' => $imgUrl]);
    }



    public function saveCroppedImage($field, $croppedImageBase64)
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






////////////////////// CONFIRM DELETE /////////////////////
    public function confirmDelete($id)
    {
        if (!$this->selectedRows)
            $this->selectedRows[] = $id;
        // Emit an event to trigger SweetAlert
        $this->dispatch('confirm-delete');
    }

    ///////////////////// SHOW DETAIL MODAL //////////////////
    public function selectItem($id)
    {
        // Load the selected item details from the database
        $this->selectedItem = $this->model::findOrFail($id); // Replace 'ModelName' with your actual model

        // Emit event to trigger the modal
        $this->dispatch('openModal');
    }


    ////////////////////// ADD EDIT MODAL ///////////////////
        // Method to open the Add Modal
        public function openAddModal()
        {
            $this->resetFields();
            $this->isEditMode = false;
            $this->dispatch('openAddEditModal');
        }


        // Method to open the Edit Modal
        public function openEditModal($id)
        {
            $record = $this->model::find($id);
            $this->selectedItemId = $record->id;

            foreach ($this->fieldDefinitions as $field => $type) {
                $this->fields[$field] = $record->$field;
            }

            // handle multi-selection form field
            foreach(array_keys($this->multiSelectFormFields) as $fieldName) {
                $this->multiSelectFormFields[$fieldName] = json_decode($record->$fieldName);
            }


            $this->isEditMode = true;
            $this->dispatch('openAddEditModal');
        }



    // Save Record Method (Add or Edit)
    public function saveRecord()
    {
        // Retrieve dynamic validation rules
        $validationData = $this->getDynamicValidationRules();
        $validationMsgs = [];


        // Validate inputs, including any custom messages
        $this->validate($validationData, [...$this->messages, ...$validationMsgs]);

        // Handle file uploads for image, photo & picture fields
        foreach (['image', 'photo', 'picture'] as $imageField) {
            if (isset($this->fields[$imageField]) && is_object($this->fields[$imageField])) {
                // Validate file type (e.g., ensure it's an image)
                if (!$this->fields[$imageField]->isValid()) {
                    throw new \Exception('Invalid file upload.');
                }

                $path = $this->fields[$imageField]->store('uploads', 'public'); // Use Laravel's Storage system
                $this->fields[$imageField] = $path; // Add the file path to the fields array
            }
        }

        // Handle multi-select form fields (convert them to JSON for storage)
        foreach ($this->multiSelectFormFields as $fieldName => $value) {
            $this->fields[$fieldName] = json_encode($value); // Store multi-select fields as JSON
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
            fn ($key) => in_array($key, $allowedFields),
            ARRAY_FILTER_USE_KEY
        );

        // Now create or update the model using the sanitized fields array
        if ($this->isEditMode) {
            $record = $this->model::find($this->selectedItemId);
            $record->update($sanitizedFields); // Update the record with sanitized fields
        } else {
            $this->model::create($sanitizedFields); // Create a new record with sanitized fields
        }

        // Close the modal and reset fields after saving
        $this->dispatch('closeAddEditModal');
        $this->dispatch('swal:success', [
            'title' => 'Success!',
            'text' => 'Record saved successfully.',
            'icon' => 'success',
        ]);

        $this->resetFields();
    }




    // Get Dynamic Validation Rules
// Get Dynamic Validation Rules
public function getDynamicValidationRules()
{
    $rules = [];
    foreach ($this->fieldDefinitions as $field => $type) {
        switch ($type) {
            case 'string':
                $rules["fields.$field"] = 'required|string|max:255';
                break;
            case 'email':
                if ($this->isEditMode) {
                    $rules["fields.$field"] = 'required|email|unique:users,email,' . $this->selectedItemId;
                } else {
                    $rules["fields.$field"] = 'required|email|unique:users,email';
                }
                break;
            case 'password':
                if ($field == "password") { // Avoid password_confirmation field
                    if (!$this->isEditMode) {
                        $rules["fields.$field"] = 'required|string|min:8|confirmed';
                    } else {
                        $rules["fields.$field"] = 'required|string|min:8';
                    }
                }
                break;
            case 'date':
                $rules["fields.$field"] = 'required|date';
                break;
            case 'integer':
                $rules["fields.$field"] = 'required|integer|min:1';
                break;
            case 'boolean':
                $rules["fields.$field"] = 'required|boolean';
                break;
            default:
                break; // Skip fields without validation
        }




        // Check if we are in edit mode and the field is not hidden
        if (($this->isEditMode && !in_array($field, $this->hiddenFields['onEditForm']))
            || (!in_array($field, $this->hiddenFields['onNewForm']))) {

            // Check if validation exists in fieldDefinitions
            if (isset($this->fieldDefinitions[$field]['validation'])) {
                // Apply validation directly for non-image fields only
                if (!in_array($field, ['image', 'photo', 'picture'])) {
                    // Handle the multiSelectFormFields outside this loop
                    if (is_array($this->multiSelectFormFields) && !in_array($field, array_keys($this->multiSelectFormFields)))
                        $rules["fields.$field"] = $this->fieldDefinitions[$field]['validation'];
                }
                // Apply validation for image fields only if the image is an object (i.e., uploaded)
                else if (is_object($this->fields[$field])) {
                    $rules["fields.$field"] = $this->fieldDefinitions[$field]['validation'];
                }
            }
        }
    }



    // Handle multi-select form field validation and messages
    if (isset($this->multiSelectFormFields)) {
        foreach (array_keys($this->multiSelectFormFields) as $fieldName) {
            $validationFiedName = 'multiSelectFormFields.' . $fieldName;
            if (isset($this->fieldDefinitions[$fieldName]) && isset($this->fieldDefinitions[$fieldName]['validation'])) {
                $rules[$validationFiedName] = $this->fieldDefinitions[$fieldName]['validation'];
                $rules[$validationFiedName . '.required'] = ucfirst(str_replace("_", " ", $fieldName)) . ' field is required.';
                $rules[$validationFiedName . '.min'] = 'Please, select at least :min ' . Str::plural(ucfirst(str_replace("_", " ", $fieldName)));
            }
        }
    }



    return $rules;
}






    // Reset the form fields
    public function resetFields()
    {
        foreach ($this->fieldDefinitions as $field => $type) {
            $this->fields[$field] = ''; // Reset each field
        }

        // Handle multi selection form fields
        foreach ($this->fieldDefinitions as $field => $type) {
            $this->fields[$field] = ''; // Reset each field
            if (isset($this->multiSelectFormFields[$field]))
                $this->multiSelectFormFields[$field] = [];
        }


        $this->selectedItemId = null;
    }

    // Redirect to the link
    public function openLink($route, $id)
    {
        $modelName = Str::singular(strtolower($this->modelName));
        return redirect()->route($route, [$modelName => $id]);
    }




    /////////////// RENDERING //////////////////////

    public function render()
    {
        $query = app($this->model)->newQuery();

        // Apply search filters
        if (!empty($this->search)) {
            $query->where(function($q) {
                foreach ($this->columns as $column) {
                    // password_confirmation does not exist  the database table schema
                    if ($column !== 'password_confirmation')
                        $q->orWhere($column, 'like', '%' . $this->search . '%');
                }
            });
        }

        // Apply sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        $data = $query->paginate($this->perPage);


        return view('livewire.data-tables.data-table', [
            'data' => $data,
            'columns' => $this->columns,
            'visibleColumns' => $this->visibleColumns,
        ]);


    }
}
