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

class AccessControl extends Component
{


    public $allControls = [];
    public $controlsCSSClasses = [];
    public $resourceNames = [];
    public $selectedScopeGroup = null;
    public $selectedScope = null;
    public $selectedScopeId = null;
    public $selectedModule;

    public $moduleOptions = [];
    public $scopeGroupOptions = ['Role', 'Team', 'User'];
    public $scopeOptions = [];




    public $accessController;


    protected $listeners = [
        "updateSelectedScopeIdEvent" => "updateSelectedScopeId",
    ];






    public function mount()
    {

        $this->moduleOptions = $this->getModuleNames();
        $this->resourceNames = $this->getAllModelNames();
        //$this->allControls = $this->getAllControls();
        //$this->controlsCSSClasses = $this->getAllControlsCSSClasses();



/*
        $data['allControls'] = $this->getAllControls();
        $data['controlsCSSClasses'] = $this->getAllControlsCSSClasses();

        $data['resourceNames'] = $this->getAllModelNames();
        $this->checkPermissionsExistanceOrCreate($data['allControls'], $data['resourceNames']);


        if (isset($this->selectedScopeId)) {
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
        $this->accessController = $data;*/
       //return view('access-control.manage', ['accessController' => $data]);//->with('records_per_page', $recordsPerPage);


    }


    public function updatedSelectedModule($selectedModule) {
        $this->selectedScopeGroup = null;
        $this->selectedScopeId = null;
        //$this->selectedScope = null;

    }



    public function updatedSelectedScopeGroup($selectedScopeGroup)
    {


        //$this->scopeOptions = Role::all();

        //$this->selectedScopeId = null;
        //$this->selectedScope = null;

        if ($this->selectedModule && $this->selectedScopeGroup) {

            $this->scopeOptions = []; // Reset

            if ($this->selectedScopeGroup == 'Role') {
                //$data['scope'] = Role::with('team')->with('permissions')->findOrFail($id);
                //$this->scope = Role::with('permissions')->findOrFail($this->selectedScope);
                $this->scopeOptions = Role::all();//where('name')->findOrFail($this->selectedScope);

            } else if ($this->selectedScopeGroup == 'User') {
                //$data['scope'] = User::with('team')->with('permissions')->findOrFail($id);
                $this->scopeOptions = User::all();//with('permissions')->findOrFail($this->selectedScopeId);
            }

            ///$this->toggleAllPermissionSwitchInitColors  = $this->getScopeToggleAllResourcePermissionsInitialCSSClasses($this->scopeOptions, $this->resourceNames );
            $this->selectedScopeId = null;


        }

    }



    public function updateSelectedScopeId($selectedModule, $selectedScopeGroup, $selectedScopeId) {
        //$this->resourceNames = []; //reset
        $this->selectedScopeGroup = $selectedScopeGroup;
        $this->selectedScope = null;

        if ($selectedModule && $selectedScopeGroup && $selectedScopeId ) {
            //dd($selectedScopeId);

            //$this->allControls = $this->getAllControls();

            //$this->controlsCSSClasses = $this->getAllControlsCSSClasses();

            $directory = app_path("Modules/".$selectedModule."/Models");
            $namespace = addslashes("App\\Modules\\".$selectedModule."\\Models\\");

            $this->resourceNames = $this->getAllModelNames($directory, $namespace);

            $this->checkPermissionsExistanceOrCreate($this->allControls, $this->resourceNames);



            if ($selectedScopeGroup == 'Role') {
                $this->selectedScope = Role::findOrFail($selectedScopeId);
            } else if ($selectedScopeGroup == 'User') {//if ($this->selectedScopeGroup == 'User') {
                $this->selectedScope = User::findOrFail($selectedScopeId);
            } else {
                $this->selectedScope = null;
            }
            //$this->toggleAllPermissionSwitchInitColors  = $this->getScopeToggleAllResourcePermissionsInitialCSSClasses($this->selectedScope, $this->resourceNames );

        }



    }




    static function checkPermissionsExistanceOrCreate($controls, $resourceNames) {
        //$allPermissions = Permission::all();//->contains("edit users");
        //dd(Permission::all());//where("name", "view permissions")->first());


        foreach($resourceNames as $resourceName) {
            foreach($controls as $control) {
                $permissionName = $control." ".Str::plural(strtolower($resourceName));
                if(!Permission::where("name", $permissionName)->first())
                    Permission::create(['name' => $permissionName, 'guard_name' => 'web', 'description' => 'Allow role or user to '.$permissionName]);
            }
        }
    }





        /*public function updatedSelectedScopeId($selectedScopeId) {


            $this->resourceNames = []; //reset

            if ( $this->selectedModule && $this->selectedScopeGroup && $this->selectedScopeId ) {

                $this->allControls = $this->getAllControls();

                $this->controlsCSSClasses = $this->getAllControlsCSSClasses();

                $directory = app_path("Modules/".$this->selectedModule."/Models");
                $namespace = addslashes("App\\Modules\\".$this->selectedModule."\\Models\\");

                $this->resourceNames = $this->getAllModelNames($directory, $namespace);

                $this->checkPermissionsExistanceOrCreate($this->allControls, $this->resourceNames);



                if ($this->selectedScopeGroup == 'Role') {
                    $this->selectedScope = Role::findOrFail($selectedScopeId);
                } else {//if ($this->selectedScopeGroup == 'User') {
                    $this->selectedScope = User::findOrFail($selectedScopeId);
                }

                $this->toggleAllPermissionSwitchInitColors  = $this->getScopeToggleAllResourcePermissionsInitialCSSClasses($this->selectedScope, $this->resourceNames );

            }


        }*/


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


                //if (class_exists($fullClassName)) {
                    // Take class name out of the path
                    $models[] = class_basename($fullClassName);
                //}
            }

            return $models;
        }




    private function getModuleNames() {
        $moduleNames = [];
        // Get all module directories
        $modules = File::directories(base_path('app/Modules'));

        // Loop through each module to load views, routes, and config files dynamically
        foreach ($modules as $module) {
            $moduleNames[] = basename($module); // Get the module name from the directory
        }

        return $moduleNames;
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







    function getAllControls() {
        return  ['view', 'print', 'edit', 'delete', 'export'];
    }
























    public function render()
    {
        return view('access.views::access-controls.access-control');
    }


}
