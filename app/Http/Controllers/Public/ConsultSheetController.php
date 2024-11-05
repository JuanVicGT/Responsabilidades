<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConsultSheetController extends Controller
{
    public function index_sheet($id)
    {
        $sheet = \App\Models\ResponsabilitySheet::find($id);
        return view('public.consult-sheet', compact('sheet'));
    }

    public function index_item($id)
    {
        $item = \App\Models\Item::find($id);
        return view('public.consult-item', compact('item'));
    }
}
