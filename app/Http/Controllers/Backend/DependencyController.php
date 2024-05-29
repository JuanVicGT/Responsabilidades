<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Dependency;
use App\Utils\Enums\AlertType;
use Illuminate\Http\Request;

class DependencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('backend.dependency.Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('backend.dependency.Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'code' => ['required', 'string', 'max:30'],
            'name' => ['required', 'string', 'max:150'],
        ]);

        $dependency = new Dependency();
        $dependency->code = $request->code;
        $dependency->name = $request->name;
        $save = $dependency->save();

        if (!$save)
            $this->addAlert(AlertType::ERROR, __('Could not be created'));

        if ($save)
            $this->addAlert(AlertType::SUCCESS, __('Created successfully'));

        return redirect()->route('dependency.create')->with('alerts', $this->getAlerts());
    }

    /**
     * Display the specified resource.
     */
    public function show(Dependency $dependency)
    {
        //
        return view('backend.dependency.Show', compact('dependency'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dependency $dependency)
    {
        //
        return view('backend.dependency.Edit', compact('dependency'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dependency $dependency)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dependency $dependency)
    {
        //
    }
}
