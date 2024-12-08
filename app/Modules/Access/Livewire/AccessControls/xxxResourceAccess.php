<?php

namespace App\Modules\Access\Livewire\AccessControls;

//use App\Models\Role;
use App\Models\User;
use Livewire\Component;

use App\Modules\Access\Models\Permission;
use App\Modules\Access\Models\Role;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class ResourceAccess extends Component
{


    public $resource;
    public $resourceName;
    public $scope;

    public $allControls;

    public $permissions;
    public $toggleSwitchColors = [];
    public $toggleSwitchStates = [];

    public $offColor = '#e8ebee';
    public $onColor = '#98ec2d';
    public $halfOnColor = 'green';
    public $controlColors;





    function mount()  {
        $this->resource = "Permission Class";
        //$this->resourceName = "Permission";
        //$this->scope = Role::findOrFail(1);
        $this->allControls = ['view', 'print', 'edit', 'delete', 'export'];

        $this->permissions =  $this->getPermisstions();
        $this->toggleSwitchColors = $this->getToggleSwitchColors($this->permissions, $this->allControls);
        $this->toggleSwitchStates = $this->getToggleSwitchStates($this->permissions, $this->allControls);

        $this->controlColors = $this->getControlColors();


    }


private function getPermisstions() {
    if (!$this->scope)
        return [];

    $allResourcesPermissions = $this->scope->getPermissionNames()->toArray();
    $permissions = [];
    $resourceName =  strtolower(Str::plural($this->resourceName));


    // Set on when permintion is not empty  array
    if ($allResourcesPermissions) {
        foreach ($allResourcesPermissions as $permission) {
            if (str_contains($permission, $resourceName)) {
                $permissions [] = $permission;
            }
        }
    }

    return $permissions;
}



    private function getToggleSwitchColors($permissions, $allControls) {
        $colors = [];


        if (count($permissions) == count($allControls)) {
            $colors ["toggleAll"] = $this->onColor;
        } else if (count($permissions) > 0) {
            $colors ["toggleAll"] = $this->halfOnColor;
        } else {
            $colors ["toggleAll"] = $this->offColor;
        }


        // Set all control colors to off to avoid returning empty color array for an empty permission array
        foreach ($allControls as $control) {
            $colors [$control] = $this->offColor;
        }

        // Set on when permintion is not empty  array
        if ($permissions) {
            foreach ($allControls as $control) {
                foreach ($permissions as $permission) {
                    if (str_contains($permission, $control)) {
                        $colors [$control] = $this->onColor;
                    }
                }
            }
        }

        return $colors;

    }


    private function getToggleSwitchStates($permissions, $allControls) {
        $states = [];


       if (count($permissions) > 0) {
            $states ["toggleAll"] = true;
        } else {
            $states ["toggleAll"] = false;
        }


        // Set all control states to off to avoid returning empty state array for an empty permission array
        foreach ($allControls as $control) {
            $states [$control] = false;
        }

        // Set on when permintion is not empty  array
        if ($permissions) {
            foreach ($allControls as $control) {
                foreach ($permissions as $permission) {
                    if (str_contains($permission, $control)) {
                        $states [$control] = true;
                    }
                }
            }
        }
//dd($states);
        return $states;

    }


    public function togglePermission($command, $checked) {
        $permissions = null;


        if (!$checked && strtolower($command) ==  "all") {
            $permissions = [];
            //dd ($permissions);

        } else if ($checked && strtolower($command) ==  "all") {
            // Prepare permission names in small leter plural eg. 'edit users'
            foreach($this->allControls as $control) {
                $permissionName =  $control." ".strtolower(Str::plural($this->resourceName));
                $permissions[] = $permissionName;
            }
            //dd ($permissions);


        } else  if ($checked) {
                $permissionName =  $command." ".strtolower(Str::plural($this->resourceName));
                $permissions = array_unique(array_merge([$permissionName], $this->scope->getPermissionNames()->toArray()));
                //dd ($permissions);

        } else {
            $permissionName =  $command." ".strtolower(Str::plural($this->resourceName));
            $permissions = array_diff($this->scope->getPermissionNames()->toArray(), [$permissionName]);
            //dd ($permissions);

        }


        $this->scope->syncPermissions($permissions); // Revoke all the permissions
        $this->permissions = $this->scope->getPermissionNames()->toArray();

        $this->toggleSwitchColors = $this->getToggleSwitchColors($this->permissions, $this->allControls);
        $this->toggleSwitchStates = $this->getToggleSwitchStates($this->permissions, $this->allControls);

        $data = [
            'resourceName' => $this->resourceName,
            'controls' => $this->allControls,
            'toggleSwitchColors' => $this->toggleSwitchColors,
            'toggleSwitchStates' => $this->toggleSwitchStates,
        ];

        $this->dispatch('permission-updated', $data);


    }


    function getControlColors() {
        return [
            'view' => ['color' => 'info', 'bg' => 'info'],
            'print' => ['color' => 'success', 'bg' => 'success'],
            'edit' => ['color' => 'warning', 'bg' => 'warning'],
            'delete' => ['color' => 'danger', 'bg' => 'danger'],
            'export' => ['color' => 'primary', 'bg' => 'primary'],
        ];
    }









    public function render()
    {
        return view('access.views::access-controls.resource-access');
    }





}
