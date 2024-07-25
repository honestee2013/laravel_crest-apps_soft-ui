<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use Exception;

class SchoolsController extends Controller
{

    /**
     * Display a listing of the schools.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $recordsPerPage = request()->input('records_per_page', 25); // Default to 25 if not set
        if(!isset($recordsPerPage))
            $recordsPerPage = 25;

        $schools = School::paginate($recordsPerPage);
        return view('schools.index', compact('schools'))->with('records_per_page', $recordsPerPage);
    }

    /**
     * Show the form for creating a new school.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        

        return view('schools.create');
    }

    /**
     * Store a new school in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $data = $this->getData($request);
        
        School::create($data);

        return redirect()->route('schools.school.index')
            ->with('success_message', 'School was successfully added.');
    }

    /**
     * Display the specified school.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $school = School::findOrFail($id);

        return view('schools.show', compact('school'));
    }

    /**
     * Show the form for editing the specified school.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $school = School::findOrFail($id);
        

        return view('schools.edit', compact('school'));
    }

    /**
     * Update the specified school in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        
        $data = $this->getData($request);
        
        $school = School::findOrFail($id);
        $school->update($data);

        return redirect()->route('schools.school.index')
            ->with('success_message', 'School was successfully updated.');
    }

    /**
     * Remove the specified school from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $school = School::findOrFail($id);
            $school->delete();

            return redirect()->route('schools.school.index')
                ->with('success_message', 'School was successfully deleted.');
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
                School::whereIn('id', $ids)->delete();
                return redirect()->route('schools.school.index')
                ->with('success_message', 'School was successfully deleted.');

            } else {
                return redirect()->route('schools.index', compact('schools'))
                    ->with('error_message', 'No schools selected for deletion.');

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
            'address' => 'nullable',
            'is_closed' => 'boolean|nullable',
            'date_started' => 'date_format:j/n/Y G:i A|nullable',
            'sections' => 'nullable',
            'distance' => 'array|nullable',
            'classes' => 'nullable',
            'sold_at' => 'date_format:j/n/Y G:i A|nullable',
            'picture' => ['image','file','nullable'],
            'file' => ['file','nullable'], 
        ];
        
        $data = $request->validate($rules);
        if ($request->has('custom_delete_picture')) {
            $data['picture'] = null;
        }
        if ($request->hasFile('picture')) {
            $data['picture'] = $this->moveFile($request->file('picture'));
        }
        if ($request->has('custom_delete_file')) {
            $data['file'] = null;
        }
        if ($request->hasFile('file')) {
            $data['file'] = $this->moveFile($request->file('file'));
        }
        $data['is_closed'] = $request->has('is_closed');

        return $data;
    }
  
    /**
     * Moves the attached file to the server.
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return string
     */
    protected function moveFile($file)
    {
        if (!$file->isValid()) {
            return '';
        }
        
        $path = config('laravel-code-generator.files_upload_path', 'uploads');
        $saved = $file->store('public/' . $path, config('filesystems.default'));

        return substr($saved, 7);
    }

}
