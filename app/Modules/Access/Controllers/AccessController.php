<?php

namespace App\Modules\Access\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Modules\Access\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Modules\Access\Models\Permission;



class AccessController extends Controller
{





    public function index()
    {

        $module  = request("module");
        if (isset($module)) {
            request()->validate([
                'module' => 'required|string|max:255',
            ]);
        }
        // Module selector will collect the needed data and redirect to [ $this->manage($module, $scope, $id) ]
        $data = [
            "id" => null,
            "scope" => null,
            "module" => $module,
        ];
        return view('access.views::access-controls.manage',  ['accessController' => $data]);
    }


    /*public function selectScopeAndRole($module)
    {

        // Module selector will collect the needed data and redirect to [ $this->manage($module, $scope, $id) ]
        $data = [
            "id" => null,
            "scope" => null,
            "module" => strtolower($module),
        ];
        return view('access.views::access-controls.manage',  ['accessController' => $data]);
    }



    public function selectRole($module, $scope)
    {
        // Module selector will collect the needed data and redirect to [ $this->manage($module, $scope, $id) ]
        $data = [
            "id" => null,
            "scope" => strtolower($scope),
            "module" => strtolower($module),
        ];
        return view('access.views::access-controls.manage',  ['accessController' => $data]);
    }*/



    public function manage($module, $scope, $id)
    {

        $data["id"] = $id;
        $data["scope"] = $scope;
        $data["module"] = $module;

        $data['allControls'] = $this->getAllControls();
        $data['controlsCSSClasses'] = $this->getAllControlsCSSClasses();


        $directory = app_path("Modules/".ucfirst($module)."/Models");
        $namespace = addslashes("App\\Modules\\".ucfirst($module)."\\Models\\");

        $data['resourceNames'] = $this->getAllModelNames($directory, $namespace);


        $this->checkPermissionsExistsOrCreate($data['allControls'], $data['resourceNames']);
        if ($scope == 'role') {
            //$data['scope'] = Role::with('team')->with('permissions')->findOrFail($id);
            $data['scope'] = Role::with('permissions')->findOrFail($id);
        } else if ($scope == 'user') {
            //$data['scope'] = User::with('team')->with('permissions')->findOrFail($id);
            $data['scope'] = User::with('permissions')->findOrFail($id);
        }

        $data['toggleAllPermissionSwitchInitColors']  = $this->getScopeToggleAllResourcePermissionsInitialCSSClasses($data['scope'], $data['resourceNames'] );


        //return view('access-control.manage', ['accessController' => $data]);//->with('records_per_page', $recordsPerPage);
        return view('access.views::access-controls.manage',  ['accessController' => $data]);


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
                $permissionCount[$resourceName]["bg"] = $offColor;
            else if ($count["permissionCount"] == 5)
                $permissionCount[$resourceName]["bg"] = $onColor;
            else
                $permissionCount[$resourceName]["bg"] = 'green';
        }

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





    /*static function getAllModelNames($directory = null, $namespace = 'App\\Models\\')
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
    }*/


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


            //if (class_exists($fullClassName)) {
                // Take class name out of the path
                $models[] = class_basename($fullClassName);
            //}
        }

        return $models;
    }








}
