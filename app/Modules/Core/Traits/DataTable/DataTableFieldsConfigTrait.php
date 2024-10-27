<?php

namespace App\Modules\Core\Traits\DataTable;

use Illuminate\Support\Facades\DB;


trait DataTableFieldsConfigTrait
{

    private $defaultHiddenFields = ["created_at", "updated_at", "id", "remember_token"];

    public function configTableFields($moduleName, $modelName) {

        $config = [
            "fieldDefinitions" => $this->initialiseFieldDefinitions(config( "$moduleName.$modelName.fieldDefinitions")) ?? [],
            "simpleActions" => config( "$moduleName.$modelName.simpleActions") ?? [],
            "moreActions" =>config( "$moduleName.$modelName.moreActions") ?? [],
            "hiddenFields" => $this->initialiseHiddenFields(config( "$moduleName.$modelName.hiddenFields")) ?? [],
            "controls" => config( "$moduleName.$modelName.controls") ?? [],
        ];

        $config = $this->setColumns($config);
        $config = $this->setMultiSelectFormFields($config);
        return $config;
    }


    private function setColumns($config) {
        // Populate te table fields
        foreach (array_keys($config["fieldDefinitions"]) as $fieldName) {
            $config["columns"][] = $fieldName;
        }
        return $config;
    }


    private function setMultiSelectFormFields($config) {
        $available = false;
        foreach (array_keys($config["fieldDefinitions"]) as $fieldName) {
            // Handle multi selection form fields
            if (is_array($config["fieldDefinitions"][$fieldName])
                && isset($config["fieldDefinitions"][$fieldName]['multiSelect'])
                && $config["fieldDefinitions"][$fieldName]['multiSelect'])
            {
                $config["multiSelectFormFields"][$fieldName] = [];
                $available = true;
            }
        }

        // To avoid error set "multiSelectFormFields" to empty array
        if (!$available)
            $config["multiSelectFormFields"] = [];

        return $config;
    }


    public function extractModuleNameFromModel($model)
    {
        // Assuming the model namespace is something like "App\Modules\Inventory\Models\Item"
        $namespaceParts = explode('\\', $model);
        // Extract the module name from the namespace (e.g., "Inventory")
        return $namespaceParts[2] ?? 'default';
    }


    private function initialiseHiddenFields($hiddenFields) {
        // Setup the none existing hidden fields
        if (!isset($hiddenFields['onTable']))
            $hiddenFields['onTable'] = [];
        if (!isset($hiddenFields['onDetail']))
            $hiddenFields['onDetail'] = [];
        if (!isset($hiddenFields['onNewForm']))
            $hiddenFields['onNewForm'] = [];
        if (!isset($hiddenFields['onEditForm']))
            $hiddenFields['onEditForm'] = [];

        // Add the default hidden fields
        foreach ($this->defaultHiddenFields as $field) {
            if (!in_array($field, array_keys($hiddenFields['onTable'])))
                $hiddenFields['onTable'][] = $field;
            if (!in_array($field, array_keys($hiddenFields['onDetail'])))
                $hiddenFields['onDetail'][] = $field;
            if (!in_array($field, array_keys($hiddenFields['onNewForm'])))
                $hiddenFields['onNewForm'][] = $field;
            if (!in_array($field, array_keys($hiddenFields['onEditForm'])))
                $hiddenFields['onEditForm'][] = $field;
        }

        return $hiddenFields;
    }


    //////////// INITIALISATION METHODS /////////////////
    private function initialiseFieldDefinitions($fieldDefinitions) {
        if (empty($fieldDefinitions)) {
            $tableName = (new $this->model)->getTable();
            $fieldDefinitions = $this->getTableFieldsWithTypes($tableName);
        }

        return $fieldDefinitions;
    }

    private function getTableFieldsWithTypes($tableName)
    {
        // Query the INFORMATION_SCHEMA to get column names and types
        $columns = DB::select(
            "SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$tableName' AND TABLE_SCHEMA = '" . env('DB_DATABASE') . "'"
        );

        // Prepare an array to store columns and their types
        $fields = [];
        foreach ($columns as $column) {
            $fields[$column->COLUMN_NAME] = $column->DATA_TYPE;
        }

        return $fields;
    }


    public function getSupportedImageColumnNames() {
        return ['image', 'photo', 'picture', 'logo'];
    }
}
