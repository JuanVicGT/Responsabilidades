<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ResponsabilitySheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ResponsabilitySheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        Gate::authorize('index', ResponsabilitySheet::class);
        return view('backend.responsability.IndexResponsability');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        Gate::authorize('create', ResponsabilitySheet::class);
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
        return view('backend.responsability.ShowResponsability', compact('responsabilitySheet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResponsabilitySheet $responsabilitySheet)
    {
        //
        Gate::authorize('edit', new ResponsabilitySheet());
        return view('backend.responsability.EditResponsability', compact('responsabilitySheet'));
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
