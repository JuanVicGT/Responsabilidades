<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Models\Event;
use App\Utils\Enums\AlertTypeEnum;
use App\Utils\Enums\StatusEventEnum;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    const MODULE_NAME = 'event';

    public function dashboard()
    {
        // Antes de dibujar el calendario, comprobamos que sea el primer inicio del usuario
        if (Auth::user()->is_first_login) {
            return redirect()->route('first_login');
        }

        $current_date = date('Y-m-d');

        // First day of the month.
        $first_date = date('Y-m-01', strtotime('-3 month', strtotime($current_date)));

        // Last day of the month.
        $last_date = date('Y-m-t', strtotime('+3 month', strtotime($current_date)));

        $events = Event::select(
            'name as title',
            'description',
            'status',
            'start_date as start',
            'end_date as end',
            'start_hour',
            'end_hour'
        )
            ->where('start_date', '>=', $first_date)
            ->where('start_date', '<=', $last_date)
            ->get()
            ->map(function ($event) {
                // Set the start and end time of the event.
                if ($event->start_hour)
                    $event->start = $event->start . 'T' . $event->start_hour;

                if ($event->end_hour)
                    $event->end = $event->end . 'T' . $event->end_hour;

                // Set the background color of the event.
                $event->color = match ($event->status) {
                    StatusEventEnum::Active->value => '#00A96E',
                    StatusEventEnum::Cancelled->value => '#FF5861',
                    StatusEventEnum::Finished->value => '#0073A0',
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
        $this->general_auth('index', self::MODULE_NAME);
        return view('backend.event.IndexEvent');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->general_auth('create', self::MODULE_NAME);

        $status_options = StatusEventEnum::array();
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
            $this->addAlert(AlertTypeEnum::Success, __('Created successfully'));
        else
            $this->addAlert(AlertTypeEnum::Error, __('Could not be created'));

        return redirect()->route('event.create')->with('alerts', $this->getAlerts());
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $this->general_auth('show', self::MODULE_NAME);
        return view('backend.event.ShowEvent', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(?int $id)
    {
        $this->general_auth('edit', self::MODULE_NAME);

        $status_options = StatusEventEnum::array();
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
            $this->addAlert(AlertTypeEnum::Success, __('Created successfully'));
        else
            $this->addAlert(AlertTypeEnum::Error, __('Could not be created'));

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
