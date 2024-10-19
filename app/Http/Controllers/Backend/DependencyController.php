<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dependency\StoreDependencyRequest;
use App\Http\Requests\Dependency\UpdateDependencyRequest;
use App\Models\Dependency;
use App\Utils\Enums\AlertTypeEnum;
use Illuminate\Support\Facades\Gate;


class DependencyController extends Controller
{
    const MODULE_NAME = 'dependency';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->general_auth('index', self::MODULE_NAME);

        return view('backend.dependency.IndexDependency');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->general_auth('create', self::MODULE_NAME);

        return view('backend.dependency.CreateDependency');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDependencyRequest $request)
    {
        $dependency = new Dependency();
        $dependency->name = $request->name;
        $save = $dependency->save();

        if (!$save)
            $this->addAlert(AlertTypeEnum::Error, __('Could not be created'));

        if ($save)
            $this->addAlert(AlertTypeEnum::Success, __('Created successfully'));

        return redirect()->route('dependency.create')->with('alerts', $this->getAlerts());
    }

    /**
     * Display the specified resource.
     */
    public function show(Dependency $dependency)
    {
        $this->general_auth('show', self::MODULE_NAME);

        return view('backend.dependency.ShowDependency', compact('dependency'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $this->general_auth('edit', self::MODULE_NAME);

        $dependency = Dependency::find($id);
        return view('backend.dependency.EditDependency', compact('dependency'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDependencyRequest $request)
    {
        $dependency = Dependency::find($request->id);
        $dependency->name = $request->name;
        $save = $dependency->save();

        if (!$save)
            $this->addAlert(AlertTypeEnum::Error, __('Could not be updated'));

        if ($save)
            $this->addAlert(AlertTypeEnum::Success, __('Updated successfully'));

        return redirect()->route('dependency.edit', $request->id)->with('alerts', $this->getAlerts());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dependency $dependency)
    {
        //
    }
}
