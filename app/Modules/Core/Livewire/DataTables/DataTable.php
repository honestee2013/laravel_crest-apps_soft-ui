<?php

namespace App\Modules\Core\Livewire\DataTables;


use Livewire\Component;

use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Modules\Core\Traits\DataTable\DataTableFieldsConfigTrait;



class DataTable extends Component
{
    use WithPagination, DataTableFieldsConfigTrait;


    ///////////////// DEFINED BY THE PARENT CLASS ///////////////
    public $model;
    public $controls;
    public $columns;
    public $fieldDefinitions;
    public $multiSelectFormFields;
    public $simpleActions;
    public $moreActions;
    public $hiddenFields;
    public $modelName;
    public $moduleName;

    ///////////////// DEFINED BY THIS CLASS ///////////////
    public $visibleColumns;
    public $selectedColumns;
    public $sortField; // Default sort field
    public $sortDirection = 'asc'; // Default sort direction
    public $perPage;
    public $selectedRows = [];
    public $selectAll;
    public $search = '';



    protected $listeners = [
        "perPageEvent" => "changePerPage",
        "searchEvent" => "changeSearch",
        "showHideColumnsEvent" => "showHideColumns",
        "recordDeletedEvent" => "resetSelection",
        'recordSavedEvent' => '$refresh',
    ];





    public function mount()
    {

    }



    public function resetSelection()
    {
        $this->selectedRows = [];
        $this->selectedColumns = null;
        $this->selectAll = null;
    }




   public function sortColumn($field)
   {

       if ($this->sortField === $field) {
           // If already sorting by this field, toggle the direction
           $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
       } else {
           // Otherwise, set to sort by this field in ascending order
           $this->sortField = $field;
           $this->sortDirection = 'asc';
           $this->dispatch('sortColumnEvent', ["column" => $field, "direction" => $this->sortDirection]);

       }
   }



   public function changePerPage($perPage)
   {
        $this->perPage = $perPage;
        $this->dispatch("changePerPageEvent", $perPage);
   }


   public function changeSearch($search)
   {

        $this->search = $search;
        $this->dispatch("changeSearchEvent", $search);
   }


    public function showHideColumns($selectedColumns)
    {
        // Update visibleColumns with the selectedColumns
        $this->visibleColumns = $selectedColumns;
    }



    /////////////////// BULK ACTION ////////////////////////

    /************ Select All Checbox Toggle ****************/
    public function updatedSelectAll($value)
    {

        if ($value) {
            $query = app($this->model)->newQuery();

            // Apply search filters
            if (!empty($this->search)) {
                $query->where(function ($q) {
                    foreach ($this->columns as $column) {
                        $q->orWhere($column, 'like', '%' . $this->search . '%');
                    }
                });
            }

            // Apply sorting
            $query->orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage);
            ;
            $this->selectedRows = $query->pluck('id')->toArray();

        } else {
            $this->selectedRows = [];
        }

        $this->dispatch("toggleRowsSelectedEvent", $this->selectedRows);
    }



    /***************** Single Checbox Toggle ****************/
    public function toggleRowSelected() {
        $this->dispatch("toggleRowsSelectedEvent", $this->selectedRows);
    }



    ///////// Trigger Events /////////////
    public function editRecord($id, $model) {
        $this->dispatch("openEditModalEvent", $id, $model);
    }



    public function showDetail($id) {
        $this->dispatch("openShowItemDetailModalEvent", $id);
    }



    public function deleteRecord($id) {
        $this->dispatch("confirmDeleteEvent", $id);
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

        // Get the hidden fields on query
        $hiddenFields = $this->hiddenFields["onQuery"];//config( "$moduleName.$modelName.hiddenFields.onQuery") ?? [];

       $modelClass = '\\' . ltrim($this->model, '\\'); // Ensure the model has a leading backslash
       $query = (new $modelClass)->newQuery();


        // Apply search filters
        if (!empty($this->search)) {
            $query?->where(function ($q) use($hiddenFields) {
                foreach ($this->fieldDefinitions as $fieldName => $fieldDefinition) {
                   // Skip the hidden fields
                   if (in_array($fieldName, $hiddenFields))
                        continue;

                    // Check if the field has a relationship
                    if (isset($fieldDefinition['relationship'])) {
                        $relationship = $fieldDefinition['relationship'];

                        // Check the dependent fields
                        if (!isset($relationship['type'])
                            || !isset($relationship['display_field'])
                            || !isset($relationship['dynamic_property']))
                            continue;

                        $relationshipType = $relationship['type'];
                        //$relatedModel = $relationship['model'];
                        $displayField = $relationship['display_field'];
                        //$foreignKey = $relationship['foreign_key'];
                        $dynamicProperty = $relationship['dynamic_property'];

                        // Handle belongsTo, hasMany, belongsToMany relationships
                        if (in_array($relationshipType, ['belongsTo', 'hasMany', 'belongsToMany'])) {
                            $q->orWhereHas($dynamicProperty, function ($relatedQuery) use ($displayField) {
                                $relatedQuery->where($displayField, 'like', '%' . $this->search . '%');
                            });
                        }
                    } else {
                        // For non-relationship fields, do a regular where clause
                        $q->orWhere($fieldName, 'like', '%' . $this->search . '%');
                    }
                }
            });
        }


        // Apply sorting
        if ($this->sortField)
            $query?->orderBy($this->sortField, $this->sortDirection);

        $data = $query?->paginate($this->perPage);

        return view('core::data-tables.data-table', [
            'data' => $data
        ]);


    }
}
