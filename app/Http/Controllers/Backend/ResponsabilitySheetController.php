<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ResponsabilitySheet;
use Illuminate\Http\Request;

class ResponsabilitySheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('backend.responsability.Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('backend.responsability.Create');
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
        return view('backend.responsability.Show', compact('responsabilitySheet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResponsabilitySheet $responsabilitySheet)
    {
        //
        return view('backend.responsability.Edit', compact('responsabilitySheet'));
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
