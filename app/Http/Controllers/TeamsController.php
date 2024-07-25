<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Exception;

class TeamsController extends Controller
{

    /**
     * Display a listing of the teams.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $recordsPerPage = request()->input('records_per_page', 25); // Default to 25 if not set
        if(!isset($recordsPerPage))
            $recordsPerPage = 25;

        $teams = Team::paginate($recordsPerPage);
        return view('teams.index', compact('teams'))->with('records_per_page', $recordsPerPage);
    }

    /**
     * Show the form for creating a new team.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        

        return view('teams.create');
    }

    /**
     * Store a new team in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $data = $this->getData($request);
        
        Team::create($data);

        return redirect()->route('teams.team.index')
            ->with('success_message', 'Team was successfully added.');
    }

    /**
     * Display the specified team.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $team = Team::findOrFail($id);

        return view('teams.show', compact('team'));
    }

    /**
     * Show the form for editing the specified team.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $team = Team::findOrFail($id);
        

        return view('teams.edit', compact('team'));
    }

    /**
     * Update the specified team in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        
        $data = $this->getData($request);
        
        $team = Team::findOrFail($id);
        $team->update($data);

        return redirect()->route('teams.team.index')
            ->with('success_message', 'Team was successfully updated.');
    }

    /**
     * Remove the specified team from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $team = Team::findOrFail($id);
            $team->delete();

            return redirect()->route('teams.team.index')
                ->with('success_message', 'Team was successfully deleted.');
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
                Team::whereIn('id', $ids)->delete();
                return redirect()->route('teams.team.index')
                ->with('success_message', 'Team was successfully deleted.');

            } else {
                return redirect()->route('teams.index', compact('teams'))
                    ->with('error_message', 'No teams selected for deletion.');

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
                'name' => 'required|string|min:1|max:255|nullable',
            'description' => 'string|min:1|max:1000|nullable', 
        ];
        
        $data = $request->validate($rules);


        return $data;
    }

}
