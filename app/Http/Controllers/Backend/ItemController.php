<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Item\StoreItemRequest;
use App\Http\Requests\Item\UpdateItemRequest;
use App\Models\Item;
use App\Utils\Enums\AlertTypeEnum;

class ItemController extends Controller
{
    const MODULE_NAME = 'item';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->general_auth('index', self::MODULE_NAME);
        return view('backend.item.IndexItem');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->general_auth('create', self::MODULE_NAME);
        return view('backend.item.CreateItem');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemRequest $request)
    {
        // Clear the format of the current inputs
        $amount = $request->amount ?? 0;
        $unit_value = $request->unit_value ?? 0;

        $item = new Item();
        $item->code = $request->code;
        $item->amount = $amount;
        $item->quantity = $request->quantity;
        $item->unit_value = $unit_value;
        $item->description = $request->description;
        $item->observations = $request->observations;

        if ($item->save())
            $this->addAlert(AlertTypeEnum::Success, __('Created successfully'));
        else
            $this->addAlert(AlertTypeEnum::Error, __('Could not be created'));

        return redirect()->route('item.create')->with('alerts', $this->getAlerts());
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        $this->general_auth('show', self::MODULE_NAME);
        return view('backend.item.ShowItem', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $this->general_auth('edit', self::MODULE_NAME);

        $item = Item::find($id);
        return view('backend.item.EditItem', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemRequest $request)
    {
        // Clear the format of the current inputs
        $amount = $request->amount ?? 0;
        $unit_value = $request->unit_value ?? 0;

        $item = Item::find($request->id);
        $item->code = $request->code;
        $item->amount = $amount;
        $item->quantity = $request->quantity;
        $item->unit_value = $unit_value;
        $item->description = $request->description;
        $item->observations = $request->observations;

        if ($item->save())
            $this->addAlert(AlertTypeEnum::Success, __('Updated successfully'));
        else
            $this->addAlert(AlertTypeEnum::Error, __('Could not be updated'));

        return redirect()->route('item.edit', $item->id)->with('alerts', $this->getAlerts());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
    }
}
