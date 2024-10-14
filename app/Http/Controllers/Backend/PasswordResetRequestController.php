<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetRequest;
use Illuminate\Http\Request;

class PasswordResetRequestController extends Controller
{
    private const MODULE_NAME = 'prequest';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->general_auth('index', self::MODULE_NAME);
        return view('backend.prequest.IndexPrequest');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(PasswordResetRequest $passwordResetRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PasswordResetRequest $passwordResetRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PasswordResetRequest $passwordResetRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PasswordResetRequest $passwordResetRequest)
    {
        //
    }
}
