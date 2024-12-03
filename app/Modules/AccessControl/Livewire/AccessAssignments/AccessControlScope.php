<?php

namespace App\Modules\AccessControl\Livewire\AccessAssignments;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Livewire\Component;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class AccessControlScope extends Component
{

    public $scope;
    public $scopeType = '';
    public $scopeList = [];
    public $accessController;
    public $scopeName = '';


    public function mount() {

        $this->dispatch('someEvent', 'Hello from Livewire!');


    }


    public function scopeSelection()
    {
        // Reset the scope variable
        $this->scope = '';
        if ($this->scopeType == 'role') {
            $this->scopeList = Role::all();
        } else if ($this->scopeType == 'user') {
            $this->scopeList = User::all();
        }  else if ($this->scopeType == 'team') {
            $this->scopeList = Team::all();
        }

    }





    public function render()
    {
        return view('livewire.access-control-scope');
    }


















    public function manage()
    {

        $this->accessController['allControls'] = $this->getAllControls();
        $this->accessController['controlsCSSClasses'] = $this->getAllControlsCSSClasses();

        $this->accessController['resourceNames'] = $this->getAllModelNames();
        $this->checkPermissionsExistsOrCreate($this->accessController['allControls'], $this->accessController['resourceNames']);
        if ($this->scopeType == 'role') {
            $this->accessController['scope'] = Role::with('team')->with('permissions')->findOrFail($this->scope);
            //$this->accessController['scope'] = Role::findOrFail($this->scope);

        } else if ($this->scopeType == 'user') {
            $this->accessController['scope'] = User::with('team')->with('permissions')->findOrFail($this->scope);
            //$this->accessController['scope'] = User::findOrFail($this->scope);
        } else if ($this->scopeType == 'team') {
            $this->accessController['scope'] = User::with('team')->with('permissions')->findOrFail($this->scope);
            //$this->accessController['scope'] = Team::findOrFail($this->scope);
        }

        if (isset($this->accessController['scope']))
            $this->scopeName = $this->accessController['scope']?->first()->name;




        $this->accessController['toggleAllPermissionSwitchInitColors']  = $this->getScopeToggleAllResourcePermissionsInitialCSSClasses($this->accessController['scope'], $this->accessController['resourceNames'] );

    }









    public function update(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'scope_id' => 'required|integer',
            'scope' => 'required|string',
            'control' => 'required|string',
            'resource_name' => 'required|string',
            'checked' => 'required|boolean',
        ]);



        // Try to update access permissions
        // Feed back data is $data = $validated;
        try{
            $scope = Role::findOrFail($validated['scope_id']); // Default scope = role
            if ($validated['scope'] == 'user') {
                $scope = User::findOrFail($validated['scope_id']);
            }

            $permissions = [];
            $data = [];

            // Handle multiple permissions
            if ($validated['control'] == "all") {

                // Prepare permission names in small leter plural eg. 'edit users'
                foreach($this->getAllControls() as $control) {
                    $permissionName =  $control." ".strtolower(Str::plural($validated['resource_name']));
                    $permissions[] = $permissionName;
                }

                // Give or revoke  all the permissions
                if ($validated['checked']) {
                    $permissions = array_unique(array_merge($permissions, $scope->getPermissionNames()->toArray()));
                } else {
                    $permissions = array_diff($scope->getPermissionNames()->toArray(), $permissions);
                }

            } else { // Handle single permissions

                $permission = $validated['control'] . ' ' . strtolower(Str::plural($validated['resource_name']));
                if ($validated['checked']) {
                    //$scope->givePermissionTo($permission);
                    $permissions = array_unique(array_merge([$permission], $scope->getPermissionNames()->toArray()));
                } else {
                    //$scope->revokePermissionTo($permission);
                    $permissions = array_diff($scope->getPermissionNames()->toArray(), [$permission]);
                }

            }

            $scope->syncPermissions($permissions); // Revoke all the permissions
            $data = $this->setScopeData($scope, $validated);
            return response()->json($data);


        } catch (\Exception $e) {
            Log::error('Error updating permission: ' . $e->getMessage(), [
                'scope_id' => $request->scope_id,
                'control' => $request->control,
                'resource_name' => $request->resource_name,
                'permission' => $request->permission,
                'exception' => $e,
            ]);

            return response()->json([
                'message' => 'An error occurred while updating the permission',
                'error' => $e->getMessage(),
            ], 500);
        }

    }


    /*private function getAllSystemResourcePermissions() {
        $allResourceNames = $this->getAllModelNames(); // PLEASE CACHE THIS
        $allControls = $this->getAllModelNames();
        $data = [];
        foreach($allResourceNames as $resourceName) {
            foreach($allControls as $control) {
                $permissionResourceName = $control ." ". Str::plural(strtolower($resourceName));
                $data[] = $permissionResourceName;
            }
        }
        return $data;
    }*/


    function setScopeData($scope, $data) {

        $data['success'] = true;
        $data['permissionNames'] = $scope->permissions->pluck('name')->toArray();
        $data['controlsCSSClasses'] = $this->getAllControlsCSSClasses();

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
        $data["allControls"] = $this->getAllControls();

        return $data;
    }






    function getAllControls() {
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


    function getScopeToggleAllResourcePermissionsInitialCSSClasses($scope, $allResourceNames) {
        $permissionCount = [];
        $offColor = '#e8ebee';
        $onColor = '#98ec2d';


        // Get resource permission count
        foreach($scope->getPermissionNames() as $permissionName) {
            foreach($allResourceNames as $resourceName) {
                if (!isset($permissionCount[$resourceName])) {
                    $permissionCount[$resourceName]["permissionCount"] = 0;
                    $permissionCount[$resourceName]["controls"] = [];
                }

                $searchResourceName = strtolower(Str::plural($resourceName));
                if (str_contains($permissionName, $searchResourceName)) {
                    $permissionCount[$resourceName]["permissionCount"]++;
                    $permissionCount[$resourceName]["controls"][] = substr($permissionName, 0, strpos($permissionName, ' '));

                }
            }
        }

        $test = [];
        // Set resource permission count color
        foreach($permissionCount as $resourceName => $count) {
            if ($count["permissionCount"] == 0)
                $permissionCount[$resourceName]["bg"] = $offColor;
            else if ($count["permissionCount"] == 5)
                $permissionCount[$resourceName]["bg"] = $onColor;
            else
                $permissionCount[$resourceName]["bg"] = 'green';
        }


        $permissionCount["offColor"] = $offColor;
        $permissionCount["onColor"] = $onColor;
dd($permissionCount);

        return $permissionCount;
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








































}
