<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Exception;

class VehiclesController extends Controller
{

    /**
     * Display a listing of the vehicles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $recordsPerPage = request()->input('records_per_page', 25); // Default to 25 if not set
        if(!isset($recordsPerPage))
            $recordsPerPage = 25;

        $vehicles = Vehicle::paginate($recordsPerPage);
        return view('vehicles.index', compact('vehicles'))->with('records_per_page', $recordsPerPage);
    }

    /**
     * Show the form for creating a new vehicle.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        

        return view('vehicles.create');
    }

    /**
     * Store a new vehicle in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $data = $this->getData($request);
        
        Vehicle::create($data);

        return redirect()->route('vehicles.vehicle.index')
            ->with('success_message', 'Vehicle was successfully added.');
    }

    /**
     * Display the specified vehicle.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        return view('vehicles.show', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified vehicle.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        

        return view('vehicles.edit', compact('vehicle'));
    }

    /**
     * Update the specified vehicle in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        
        $data = $this->getData($request);
        
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update($data);

        return redirect()->route('vehicles.vehicle.index')
            ->with('success_message', 'Vehicle was successfully updated.');
    }

    /**
     * Remove the specified vehicle from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);
            $vehicle->delete();

            return redirect()->route('vehicles.vehicle.index')
                ->with('success_message', 'Vehicle was successfully deleted.');
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
                Vehicle::whereIn('id', $ids)->delete();
                return redirect()->route('vehicles.vehicle.index')
                ->with('success_message', 'Vehicle was successfully deleted.');

            } else {
                return redirect()->route('vehicles.index', compact('vehicles'))
                    ->with('error_message', 'No vehicles selected for deletion.');

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
                'name' => 'string|min:1|max:255|nullable',
            'color' => 'nullable',
            'plate_number' => 'numeric|nullable',
            'category' => 'nullable',
            'date_purchased' => 'date_format:j/n/Y G:i A|nullable', 
        ];
        
        $data = $request->validate($rules);


        return $data;
    }

}
