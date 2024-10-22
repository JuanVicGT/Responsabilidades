<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ResponsabilitySheet;
use Illuminate\Http\Request;

class ResponsabilitySheetController extends Controller
{
    const MODULE_NAME = 'responsability';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $this->general_auth('index', self::MODULE_NAME);
        return view('backend.responsability.IndexResponsability');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $this->general_auth('create', self::MODULE_NAME);
        return view('backend.responsability.CreateResponsability');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ResponsabilitySheet $responsabilitySheet)
    {
        //
        $this->general_auth('show', self::MODULE_NAME);
        return view('backend.responsability.ShowResponsability', compact('responsabilitySheet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $sheet = ResponsabilitySheet::find($id);

        $this->general_auth('edit', self::MODULE_NAME);
        return view('backend.responsability.EditResponsability', compact('sheet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ResponsabilitySheet $responsabilitySheet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResponsabilitySheet $responsabilitySheet)
    {
        //
    }
}
