<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Services\AppSettingService;
use App\Models\ResponsabilitySheet;
use Barryvdh\DomPDF\Facade\Pdf;
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

    public function print(int $id)
    {
        $sheet = ResponsabilitySheet::find($id);
        $appSettings = app(AppSettingService::class);

        $showSheetHeader = $appSettings->get('show_sheet_header', false);
        $maxLinesPerPage = $appSettings->get('print_lines_per_page', 13); // Define el máximo de líneas por página
        $lines = $sheet->lines->chunk($maxLinesPerPage); // Divide las líneas en grupos

        $data = [
            'sheet' => $sheet,
            'lines' => $lines,
            'show_sheet_header' => $showSheetHeader
        ];

        $pdf = Pdf::loadView('backend.pdfs.print-responsability-sheet', $data);
        $pdf->setPaper('legal', 'landscape');
        return $pdf->stream('Hoja de Responsabilidades - ' . $sheet->number . '.pdf');
    }
}
