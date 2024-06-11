<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Models\Event;
use App\Models\User;
use App\Utils\Enums\AlertType;
use App\Utils\Enums\StatusEvent;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    public function dashboard()
    {
        $current_date = date('Y-m-d');

        // First day of the month.
        $first_date = date('Y-m-01', strtotime('-3 month', strtotime($current_date)));

        // Last day of the month.
        $last_date = date('Y-m-t', strtotime('+3 month', strtotime($current_date)));

        $events = Event::select(
            'name as title',
            'description',
            'status',
            DB::raw('concat(start_date, "T", start_hour) as start'),
            DB::raw('concat(end_date, "T", end_hour) as end'),
        )
            ->where('start_date', '>=', $first_date)
            ->where('start_date', '<=', $last_date)
            ->get()
            ->map(function ($event) {
                // Set the background color of the event.
                $event->color = match ($event->status) {
                    StatusEvent::Active->value => '#00A96E',
                    StatusEvent::Cancelled->value => '#FF5861',
                    StatusEvent::Finished->value => '#0073A0',
                };
                return $event;
            })
            ->toArray();

        return view('backend.dashboard', compact('events'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        Gate::authorize('index', Event::class);
        return view('backend.event.IndexEvent');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        Gate::authorize('create', Event::class);

        $status_options = StatusEvent::array();
        return view('backend.event.CreateEvent', compact('status_options'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        //
        $event = new Event();
        $event->name = $request->name;
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->status = $request->status;
        $event->description = $request->description;
        $event->start_hour = $request->start_hour;
        $event->end_hour = $request->end_hour;
        $event->id_responsible = $request->id_responsible;
        $event->save();

        if ($event->save())
            $this->addAlert(AlertType::Success, __('Created successfully'));
        else
            $this->addAlert(AlertType::Error, __('Could not be created'));

        return redirect()->route('event.create')->with('alerts', $this->getAlerts());
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
        return view('backend.event.ShowEvent', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(?int $id)
    {
        //
        Gate::authorize('edit', new Event());

        $status_options = StatusEvent::array();
        return view('backend.event.EditEvent', compact('status_options', 'id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request)
    {
        //
        $event = Event::find($request->id);
        $event->name = $request->name;
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->status = $request->status;
        $event->description = $request->description;
        $event->start_hour = $request->start_hour;
        $event->end_hour = $request->end_hour;
        $event->id_responsible = $request->id_responsible;
        $event->save();

        if ($event->save())
            $this->addAlert(AlertType::Success, __('Created successfully'));
        else
            $this->addAlert(AlertType::Error, __('Could not be created'));

        return redirect()->route('event.edit', $event->id)->with('alerts', $this->getAlerts());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
