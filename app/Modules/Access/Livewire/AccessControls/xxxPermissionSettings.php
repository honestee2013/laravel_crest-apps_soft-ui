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

class PermissionSettings extends Component
{



    public $controlsCSSClasses = [];
    public $allControls;


    public $toggleAllPermissionSwitchInitColors;
    public $resourceNames;
    public $selectedScope;


    public $selectedScopeGroup;

    public $offColor = '#e8ebee';
    public $onColor = '#98ec2d';
    public $halfOnColor = 'green';


    protected $listeners = [
        "updateSelectedScopeIdEvent" => "updateSelectedScopeId",
        "updatePermissionEvent" => "updatePermission",
        "selectedModuleChangedEvent" => "selectedModuleChanged"
    ];


    public function mount() {



        //$data['allControls'] = $this->getAllControls();
        //$data['controlsCSSClasses'] = $this->getAllControlsCSSClasses();

        //$data['resourceNames'] = $this->getAllModelNames();


        /*if (isset($this->selectedScopeId)) {
            if (strtolower($this->selectedScopeGroup) == 'role') {
                //$data['scope'] = Role::with('team')->with('permissions')->findOrFail($id);
                $data['selectedScope'] = Role::with('permissions')->findOrFail($this->selectedScopeId);

            } else  if (strtolower($this->selectedScopeGroup) ==  'user') {
                //$data['scope'] = User::with('team')->with('permissions')->findOrFail($id);
                $data['selectedScope'] = User::with('permissions')->findOrFail($this->selectedScopeId);
            }

            $data['toggleAllPermissionSwitchInitColors']  = $this->getScopeToggleAllResourcePermissionsInitialCSSClasses($data['selectedScope'], $data['resourceNames'] );

        }
        //dd($data);
        $this->accessController = $data;
       //return view('access-control.manage', ['accessController' => $data]);//->with('records_per_page', $recordsPerPage);

*/

    }






    function selectedModuleChanged() {
        //dd("ggggg");
    }








    function setScopeData($scope, $data) {

        $data['success'] = true;
        $data['permissionNames'] = $scope->permissions->pluck('name')->toArray();
        $data['controlsCSSClasses'] = $this->controlsCSSClasses;

        // Updated user control list on this resource
        $controls = [];
        foreach($scope->getPermissionNames()->toArray() as $permissionName) {
            $resourceName = strtolower(Str::plural($data['resource_name']));
            if (str_contains($permissionName, $resourceName)) {
                // extract control name from the permission name eg. 'view'  from 'view user'
                $control = substr($permissionName, 0, strpos($permissionName, ' '));
                $controls[] = $control;
            }
        }
        // User only assigned controls
        $data["controls"] = $controls;
        // All available ontrols
        $data["allControls"] = $this->allControls;

        return $data;
    }

















    function getScopeToggleAllResourcePermissionsInitialCSSClasses($scope, $allResourceNames) {
        $permissionCount = [];


        // Get resource permission count
        foreach($scope->getPermissionNames() as $permissionName) {
            foreach($allResourceNames as $resourceName) {
                if (!isset($permissionCount[$resourceName]))
                    $permissionCount[$resourceName]["permissionCount"] = 0;

                $searchResourceName = strtolower(Str::plural($resourceName));
                if (str_contains($permissionName, $searchResourceName)) {
                    $permissionCount[$resourceName]["permissionCount"]++;
                }
            }
        }

        $test = [];
        // Set resource permission count color
        foreach($permissionCount as $resourceName => $count) {
            if ($count["permissionCount"] == 0)
                $permissionCount[$resourceName]["bg"] = $this->offColor;
            else if ($count["permissionCount"] == 5)
                $permissionCount[$resourceName]["bg"] = $this->onColor;
            else
                $permissionCount[$resourceName]["bg"] = 'green';
        }

        return $permissionCount;
    }







    static function getAllModels($directory = null, $namespace = 'App\\Models\\')
    {
        if (!$directory) {
            $directory = app_path('Models');
        }

        $models = [];
        $files = File::allFiles($directory);

        foreach ($files as $file) {
            $relativePath = $file->getRelativePathname();
            $class = $namespace . str_replace(['/', '.php'], ['\\', ''], $relativePath);

            if (class_exists($class)) {
                $models[] = $class;
            }
        }

        return $models;
    }








    public function updatePermission($data) {

        // Validation
        /*$validated = $this->validate([
            'scope_id' => 'required|integer',
            'scope' => 'required|string',
            'control' => 'required|string',
            'resource_name' => 'required|string',
            'checked' => 'required|boolean',
        ]);*/


            // Try to update access permissions
            // Feed back data is $data = $validated;
            try{
                $scope = Role::findOrFail($data['scope_id']); // Default scope = role
                if (strtolower($data['scope']) === 'user') {
                    $scope = User::findOrFail($data['scope_id']);
                }


                $permissions = [];
                //$data = [];

                // Handle multiple permissions
                if ($data['control'] == "all") {

                    // Prepare permission names in small leter plural eg. 'edit users'
                    foreach($this->allControls as $control) {
                        $permissionName =  $control." ".strtolower(Str::plural($data['resource_name']));
                        $permissions[] = $permissionName;
                    }

                    // Give or revoke  all the permissions
                    if ($data['checked']) {
                        $permissions = array_unique(array_merge($permissions, $scope->getPermissionNames()->toArray()));
                    } else {
                        $permissions = array_diff($scope->getPermissionNames()->toArray(), $permissions);
                    }


                } else { // Handle single permissions

                    $permission = $data['control'] . ' ' . strtolower(Str::plural($data['resource_name']));
                    if ($data['checked']) {
                        //$scope->givePermissionTo($permission);
                        $permissions = array_unique(array_merge([$permission], $scope->getPermissionNames()->toArray()));
                    } else {
                        //$scope->revokePermissionTo($permission);
                        $permissions = array_diff($scope->getPermissionNames()->toArray(), [$permission]);
                    }

                }


                $scope->syncPermissions($permissions); // Revoke all the permissions

                $data = $this->setScopeData($scope, $data);

                ///return response()->json($data);


            } catch (\Exception $e) {
                Log::error('Error updating permission: ' . $e->getMessage());//, [
                    /*'scope_id' => $request->scope_id,
                    'control' => $request->control,
                    'resource_name' => $request->resource_name,
                    'permission' => $request->permission,
                    'exception' => $e,
                ]);*/

                return response()->json([
                    'message' => 'An error occurred while updating the permission',
                    'error' => $e->getMessage(),
                ], 500);
            }


        $this->dispatch("permission-updated-event", $data);

    }











    public function render()
    {
        return view('access.views::access-controls.permission-settings');
    }





}
