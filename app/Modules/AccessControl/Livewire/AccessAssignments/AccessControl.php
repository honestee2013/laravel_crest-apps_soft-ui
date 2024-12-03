<?php

namespace App\Modules\AccessControl\Livewire\AccessAssignments;


use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class AccessControl extends Component
{

    public $accessController;
    public $scopeType;
    public $scope;
    public $scopeId;
    public $controls;

    public $controlsCSSClasses;
    public $resourceNames;
    public $allSystemResourcePermissions = [];
    public $allSystemGroupedResourcePermissions = [];
    public $scopeAllPermissions = [];
    public $allScopeGroupedPermissions = [];



    public function mount($scopeType = "role", $scopeId = 1)
    {
        $this->scopeType = $scopeType;
        $this->scopeId = $scopeId;

        $this->controls = $this->getAllControls();
        $this->controlsCSSClasses = $this->getAllControlsCSSClasses();
        $this->resourceNames = $this->getAllModelNames();
        $this->checkPermissionsExistsOrCreate($this->controls, $this->resourceNames);

        // All the  Scope permissions
        if ($scopeType == 'role') {
            $this->scope = Role::with('team')->with('permissions')->findOrFail($scopeId);
            $this->scopeAllPermissions = Role::findOrFail($scopeId)->getPermissionNames()->toArray();
        } else if ($scopeType == 'user') {
            $this->scope = User::with('team')->with('permissions')->findOrFail($scopeId);
            $this->scopeAllPermissions = User::findOrFail($scopeId)->getPermissionNames()->toArray();
        }

        // Scope permissions grouped by resource name
        $this->allScopeGroupedPermissions = $this->allScopeGroupedPermissions();
        $this->allSystemResourcePermissions = $this->getAllSystemResourcePermissions();
        $this->allSystemGroupedResourcePermissions = $this->getAllSystemGroupedResourcePermissions();

        //dd($this->allSystemResourcePermissions);
//dd($this->getAllSystemResourcePermissions());
        //array_intersect($this->permissions, $resourcePermissions)
        //dd($this->allScopeGroupedPermissions());
//dd($this->scopeAllPermissions);
//dd($this->getResourcePermissions('Team'));
//dd($this->areAllPermissionsSelected('User'), $this->getResourcePermissions('User'));
}

    public function savePermissions() {
        $this->scope->syncPermissions($this->scopeAllPermissions); //Give all the permissions
    }


    private function allScopeGroupedPermissions() {

        $data = [];
        if ($this->scopeAllPermissions && $this->resourceNames) {
            foreach($this->scopeAllPermissions as $permission) {
                foreach($this->resourceNames as $resourceName) {
                    $permissionResourceName = Str::plural(strtolower($resourceName));
                    if(str_contains($permission, $permissionResourceName)) {
                        $data[$resourceName][] = $permission;
                    }
                }
            }
        }

        return $data;
    }

    private function getAllSystemResourcePermissions() {
        $data = [];
        foreach($this->resourceNames as $resourceName) {
            foreach($this->controls as $control) {
                $permissionResourceName = $control ." ". Str::plural(strtolower($resourceName));
                $data[] = $permissionResourceName;
            }
        }
        return $data;
    }

    private function getAllSystemGroupedResourcePermissions() {
        $data = [];
        foreach($this->resourceNames as $resourceName) {
            foreach($this->controls as $control) {
                $permissionResourceName = $control ." ". Str::plural(strtolower($resourceName));
                $data[$resourceName][] = $permissionResourceName;
            }
        }
        return $data;
    }






    public function getAllControls() {
        return  ['view', 'print', 'edit', 'delete', 'export'];
    }



    function getAllControlsCSSClasses() {
        return [
            'view' => ['color' => 'info', 'bg' => 'info'],
            'print' => ['color' => 'success', 'bg' => 'success'],
            'edit' => ['color' => 'warning', 'bg' => 'warning'],
            'delete' => ['color' => 'danger', 'bg' => 'danger'],
            'export' => ['color' => 'primary', 'bg' => 'primary'],
        ];
    }


    static function getAllModelNames($directory = null, $namespace = 'App\\Models\\')
    {
        if (!$directory) {
            $directory = app_path('Models');
        }

        $models = [];
        $files = File::allFiles($directory);

        foreach ($files as $file) {
            $relativePath = $file->getRelativePathname();
            $fullClassName = $namespace . str_replace(['/', '.php'], ['\\', ''], $relativePath);

            if (class_exists($fullClassName)) {
                // Take class name out of the path
                $models[] = class_basename($fullClassName);
            }
        }

        return $models;
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




    static function checkPermissionsExistsOrCreate($controls, $resourceNames) {
        //$allPermissions = Permission::all();//->contains("edit users");
        //dd(Permission::all());//where("name", "view permissions")->first());
        foreach($resourceNames as $resourceName) {
            foreach($controls as $control) {
                $permissionName = $control." ".Str::plural(strtolower($resourceName));
                if(!Permission::where("name", $permissionName)->first())
                    Permission::create(['name' => $permissionName, 'description' => 'Allow role or user to '.$permissionName]);
            }
        }
    }





    //public function updatePermission($control, $resourceName, $checked)
    public function updateAllResourcePermission($permissions, $checked)
    {


        // ******** SECURITY CONCERN about $resourceName should be considered ***********

        // Try to update access permissions
        try{
            /*$scope = Role::findOrFail($scopeId); // Default scope = role
            if ( $scope == 'user') {
                $scope = User::findOrFail($validated['scope_id']);
            }*/


            // Handle multiple permissions
            if ($control == "all") {

                // Prepare permission names in small leter plural eg. 'edit users'
                $permissions = [];
                foreach($this->controls as $control) {
                    $permissionName =  $control." ".strtolower(Str::plural($resourceName));
                    $permissions[] = $permissionName;
                }

                // Give or revoke  all the permissions
                if ($checked) {
                    $this->scope->syncPermissions($permissions); //Give all the permissions
                } else {
                    $this->scope->syncPermissions([]); // Revoke all the permissions
                }

                ///$data = $this->setScopeData($scope, $validated);
                ///return response()->json($data);

            } else { // Handle single permissions

                $permission = $control . ' ' . strtolower(Str::plural($resourceName));
                if ($checked) {
                    $this->scope->givePermissionTo($permission);
                } else {
                    $this->scope->revokePermissionTo($permission);
                }

                //$data['success'] = true;
                //$data['permissionNames'] = json_encode($scope->permissions->pluck('name'));
                ///$data = $this->setScopeData($scope, $validated);
                ///return response()->json($data);
            }

        } catch (\Exception $e) {
            Log::error('Error updating permission: ' . $e->getMessage(), ['exception' => $e]);

            return response()->json([
                'message' => 'An error occurred while updating the permission',
                'error' => $e->getMessage(),
            ], 500);
        }

    }




    function setScopeData($scope, $data) {

        $data['success'] = true;
        $data['permissionNames'] = $scope->permissions->pluck('name')->toArray();
        $data['controlsCSSClasses'] = $this->getAllControlsCSSClasses();
        $controls = [];
        foreach([...$scope->permissions->pluck('name')] as $permissionName) {
            $control = substr($permissionName, 0, strpos($permissionName, ' '));
            $controls[] = $control;
        }
        $data["controls"] = $controls;

        return $data;
    }









/////////////////////////////////////////////////////////////////////////

// Function to retrieve all permissions for a given resource
private function getAllScopeGroupedPermissions($resource)
{
    // Define permissions for each resource here or dynamically fetch them
    /*$permissions = [
        'user' => ['edit user', 'view user', 'delete user'],
        'post' => ['edit post', 'view post', 'delete post'],
        // Add more resources and their permissions as needed
    ];*/

    return $this->allScopeGroupedPermissions[$resource] ?? [];
}


// Generic function to check if all permissions for a given resource are selected
public function areAllPermissionsSelected($resource)
{
    $resourcePermissions = $this->getAllScopeGroupedPermissions($resource);
    //return count(array_intersect($this->scopeAllPermissions->toArray(), $resourcePermissions)) === count($resourcePermissions);
    return count($resourcePermissions) === count($this->controls);
}


// Generic function to toggle all permissions for a given resource
public function togglePermissions($resource)
{
    $resourcePermissions =  $this->allSystemGroupedResourcePermissions[$resource];
    if ($this->areAllPermissionsSelected($resource)) {
        // Uncheck all permissions related to the resource
        $this->scopeAllPermissions = array_diff($this->scopeAllPermissions, $resourcePermissions);
    } else {
        // Select all permissions related to the resource
        $this->scopeAllPermissions = array_unique(array_merge($this->scopeAllPermissions, $resourcePermissions));
    }
}






















    public function render()
    {
        return view('livewire.access-control');
    }


}
