<?php

namespace App\Modules\Core\Livewire\DataTables;


use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Modules\Core\Traits\DataTable\DataTableControlsTrait;
use App\Modules\Core\Traits\DataTable\DataTableFieldsConfigTrait;



class DataTableManager extends Component
{

    use DataTableControlsTrait, DataTableFieldsConfigTrait;

    public $modelName;
    public $moduleName;

    public $model;
    public $controls;
    public $columns;
    public $visibleColumns;
    public $fieldDefinitions;
    public $multiSelectFormFields;
    public $simpleActions;
    public $moreActions;
    public $hiddenFields;

    public $isEditMode;
    public $selectedItem;

    public $sortField = 'id'; // Default sort field
    public $sortDirection = 'asc'; // Default sort direction
    public $perPage = 5;

    public $modalCount = 0;
    public $refreshModalCount = 20;

    public $modalStack = [];
    public $feedbackMessages = "";


    protected $listeners = [
        "setFeedbackMessageEvent" => "setFeedbackMessage",
        "changeFormModeEvent" => "changeFormMode",
        "changeSelectedItemEvent" => "changeSelectedItem",
        "openAddRelationshipItemModalEvent" => "openAddRelationshipItemModal",

        "openCropImageModalEvent" => "openCropImageModal",
        'checkPageRefreshTimeEvent' => 'checkPageRefreshTime',

        'addModalFormComponentStackEvent' => 'addModalFormComponentStack',

    ];




    public function mount() {
Log::info("DataTableManager->mount(): ".$this->getId());
//array_push($this->modalStack, $this->getId());

        $this->feedbackMessages = "";

$tableName = app($this->model)->getTable();

//if(Schema::hasColumn($tableName, 'display_name')) // Try using display_name if it exist
//dd(app($this->model)->getTable());

        $this->modelName = class_basename($this->model);
        if(!$this->moduleName)
            $this->moduleName = $this->extractModuleNameFromModel($this->model);

        $data = $this->configTableFields($this->moduleName, $this->modelName);
        $this->fieldDefinitions = $data["fieldDefinitions"];
        $this->simpleActions = $data["simpleActions"];
        $this->moreActions = $data["moreActions"];
        $this->hiddenFields = $data["hiddenFields"];
        $this->controls = $data["controls"];
        $this->columns = $data["columns"];
        $this->multiSelectFormFields = $data["multiSelectFormFields"];

        // If custom controls are passed, use them. Otherwise, fetch default controls from the trait.
        $this->controls = $this->getPreparedControls($this->controls);

        $this->visibleColumns = $data["columns"];// Show all columns by default
        // Hidden on table index view
        if ($this->hiddenFields['onTable'])
            $this->visibleColumns = array_diff($this->visibleColumns, $this->hiddenFields['onTable']);


    }



    public function addModalFormComponentStack($componentId) {
        array_push($this->modalStack, $componentId);
        $this->modalStack = array_unique($this->modalStack);
    }



    public function changeFormMode($data) {

        if ($data['mode'] == 'edit') {
            $this->isEditMode = true;
        } else {
            // New modal
            $this->isEditMode = false;
              // Update the stack
            //array_push($this->modalStack, $data['componentId']) ;

        }
    }


    public function changeSelectedItem($id) {
        // Load the selected item details from the database
        $this->selectedItem = $this->model::findOrFail($id);

    }


    public function openAddRelationshipItemModal($model, $moduleName = "") {

        Log::info("openAddRelationshipItemModal(). Model: ".$model. " Module: ".$moduleName);

        // Reset multiple opend modal component to release space
        $this->checkPageRefreshTime();

        // Next Modal id
        $modalId = ++$this->modalCount;

        // To be used for test
        // $model="App\Models\User";
        // $moduleName = "Core";

        // Set the ModuleName and the Model
        $modelName = class_basename($model);
        if(!$moduleName)
            $moduleName = $this->extractModuleNameFromModel($model);
            //dd($model, $modelName, $moduleName);
        // Config file name space access is in lower case
        //$modelName=strtolower($modelName);
        //$moduleName=strtolower($moduleName);

        // Get the data table configuration data
        $data = $this->configTableFields($moduleName, $modelName);

        $data["modalId"] = $modalId;
        $data["isEditMode"] = false;
        $data["model"] = $model;
        $data["modelName"] = $modelName;
        $data["modalClass"] = "childModal";

        //try {
        $modalHeader =  view('core.views::data-tables.modals.modal-header', $data)->render();
        $modalBodyContent =   view('core.views::data-tables.partials.form-render', $data)->render();
        $modalBody =  view('core.views::data-tables.modals.modal-body', ["content" => $modalBodyContent])->render();
        $modalFooter =  view('core.views::data-tables.modals.modal-footer',$data)->render();

        $modalHtml = $modalHeader.$modalBody.$modalFooter;



        // Dispatch the modal event again
        $this->dispatch("open-child-modal-event", ['modalHtml' => $modalHtml, "modalId" => $modalId]);

        //array_push($this->modalStack, $this->getId());

        //} catch (\Exception $e) {
            //Log::error("DataTableManager::openAddRelationshipItemModal($modelName, $moduleName): Failed to load the configuration file for the child modal!");
        //}

    }




    public function openCropImageModal($field, $imgUrl, $id) {

        $modalId = ++$this->modalCount;
        $data = [
            "modalId" => $modalId,
            "field" => $field,
            "imgUrl" => $imgUrl,
            "id" => $id,
        ];

        //@include('core.views::data-tables.modals.crop-image-modal')
        $modalHtml =  view('core.views::data-tables.modals.crop-image-modal', $data)->render();
        //$this->dispatch("open-add-relationship-modal", ['modalHtml' => $modalHtml, "modalId" => $modalId]);
        $data["modalHtml"] = $modalHtml;

        ///$this->dispatch("open-add-relationship-modal", $data);
        $this->dispatch("show-crop-image-modal-event", $data);
    }


    public function checkPageRefreshTime() {
        if ( $this->modalCount >= $this->refreshModalCount) {
            $this->dispatch('confirm-page-refresh');
        }
     }



    //////////////// RENDERING METHODS /////////////////
    public function render() {
        return view('core.views::data-tables.data-table-manager', []);
    }



}
