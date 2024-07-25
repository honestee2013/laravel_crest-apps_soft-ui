<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Team;
use Illuminate\Http\Request;
use Exception;

class RolesController extends Controller
{

    /**
     * Display a listing of the roles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $recordsPerPage = request()->input('records_per_page', 25); // Default to 25 if not set
        if(!isset($recordsPerPage))
            $recordsPerPage = 25;

        $roles = Role::with('team')->paginate($recordsPerPage);
        return view('roles.index', compact('roles'))->with('records_per_page', $recordsPerPage);
    }

    /**
     * Show the form for creating a new role.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $teams = Team::pluck('name','id')->all();

        return view('roles.create', compact('teams'));
    }

    /**
     * Store a new role in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $data = $this->getData($request);

        Role::create($data);

        return redirect()->route('roles.role.index')
            ->with('success_message', 'Role was successfully added.');
    }

    /**
     * Display the specified role.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $role = Role::with('team')->findOrFail($id);

        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified role.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $teams = Team::pluck('name','id')->all();

        return view('roles.edit', compact('role','teams'));
    }

    /**
     * Update the specified role in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {

        $data = $this->getData($request);

        $role = Role::findOrFail($id);
        $role->update($data);

        return redirect()->route('roles.role.index')
            ->with('success_message', 'Role was successfully updated.');
    }

    /**
     * Remove the specified role from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            return redirect()->route('roles.role.index')
                ->with('success_message', 'Role was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }



    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            if (!empty($ids)) {
                Role::whereIn('id', $ids)->delete();
                return redirect()->route('roles.role.index')
                ->with('success_message', 'Role was successfully deleted.');

            } else {
                return redirect()->route('roles.index', compact('roles'))
                    ->with('error_message', 'No roles selected for deletion.');

            }
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }








    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
                'team_id' => 'nullable',
            'name' => 'required|string|min:1|max:255',
            'description' => 'required|string|min:1|max:255',
            //'guard_name' => 'required|string|min:1|max:255',
        ];

        $data = $request->validate($rules);


        return $data;
    }

}
