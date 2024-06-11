<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Item\StoreItemRequest;
use App\Models\Item;
use App\Utils\Enums\AlertType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        Gate::authorize('index', Item::class);
        return view('backend.item.IndexItem');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        Gate::authorize('create', Item::class);
        return view('backend.item.CreateItem');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemRequest $request)
    {
        $item = new Item();
        $item->code = $request->code;
        $item->name = $request->name;
        $item->amount = $request->amount;
        $item->serial = $request->serial;
        $item->quantity = $request->quantity;
        $item->unit_value = $request->unit_value;
        $item->description = $request->description;
        $item->observations = $request->observations;

        if ($item->save())
            $this->addAlert(AlertType::Success, __('Created successfully'));
        else
            $this->addAlert(AlertType::Error, __('Could not be created'));

        return redirect()->route('item.create')->with('alerts', $this->getAlerts());
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
        Gate::authorize('show', $item);
        return view('backend.item.ShowItem', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        Gate::authorize('edit', new Item());
        return view('backend.item.EditItem', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
    }
}
