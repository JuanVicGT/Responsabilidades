<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Todo\StoreTodoRequest;
use App\Http\Requests\Todo\UpdateTodoRequest;
use App\Models\Todo;
use App\Utils\Enums\AlertType;
use App\Utils\Enums\StatusTodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        Gate::authorize('index', Todo::class);
        return view('backend.todo.IndexTodo');
    }

    /**
     * Display a listing of the resource.
     */
    public function calendar()
    {
        //
        Gate::authorize('index', Todo::class);

        $current_date = date('Y-m-d');

        // First day of the month.
        $first_date = date('Y-m-01', strtotime('-3 month', strtotime($current_date)));

        // Last day of the month.
        $last_date = date('Y-m-t', strtotime('+3 month', strtotime($current_date)));

        $todos = Todo::select(
            'name AS title',
            'status',
            'date AS start',
            'hour'
        )
            ->where('id_user', Auth::user()->id)
            ->where('date', '>=', $first_date)
            ->where('date', '<=', $last_date)
            ->get()
            ->map(function ($todo) {
                // Set the start and end time of the event.
                if ($todo->hour)
                    $todo->start = $todo->start . 'T' . $todo->hour;

                                    // Set the background color of the event.
                $todo->color = match ($todo->status) {
                    StatusTodo::NotStarted->value => '#C99701',
                    StatusTodo::Started->value => '#00A96E',
                    StatusTodo::Cancelled->value => '#FF5861',
                    StatusTodo::Finished->value => '#0073A0',
                };

                return $todo;
            });
        return view('backend.todo.CalendarTodo', compact('todos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        Gate::authorize('create', Todo::class);

        $status_options = StatusTodo::array();
        return view('backend.todo.CreateTodo', compact('status_options'));
    }

    /**
     * The function `store` creates a new Todo entry with specified details and redirects to the create
     * page with success or error alerts.
     * 
     * @param StoreTodoRequest
     */
    public function store(StoreTodoRequest $request)
    {
        $year = null;
        $month = null;

        if ($request->date)
            $month = date('m', strtotime($request->date));

        if ($request->date)
            $year = date('Y', strtotime($request->date));

        $saved = Todo::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'hour' => $request->hour,
            'date' => $request->date,
            'year' => $year,
            'month' => $month,
            'id_user' => Auth::user()->id
        ]);

        if (!$saved) {
            $this->addAlert(AlertType::Error, __('Could not be created'));
            return redirect()->route('todo.create')->with('alerts', $this->getAlerts());
        }

        $this->addAlert(AlertType::Success, __('Created successfully'));
        return redirect()->route('todo.create')->with('alerts', $this->getAlerts());
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        //
        Gate::authorize('show', $todo);
        return view('backend.todo.ShowTodo', compact('todo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $todo = Todo::find($id);
        Gate::authorize('index', $todo);

        // Format the values for the view
        $status_options = StatusTodo::array();
        $todo->hour = date('H:i', strtotime($todo->hour));
        $current_status = ucwords(str_replace('_', ' ', $todo->status));
        return view('backend.todo.EditTodo', compact('todo', 'status_options', 'current_status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoRequest $request)
    {
        $year = null;
        $month = null;

        if ($request->date)
            $month = date('m', strtotime($request->date));

        if ($request->date)
            $year = date('Y', strtotime($request->date));

        $todo = Todo::find($request->id);
        $saved = $todo->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'hour' => $request->hour,
            'date' => $request->date,
            'year' => $year,
            'month' => $month,
            'id_user' => Auth::user()->id
        ]);

        if (!$saved) {
            $this->addAlert(AlertType::Error, __('Could not be updated'));
            return redirect()->route('todo.create')->with('alerts', $this->getAlerts());
        }

        $this->addAlert(AlertType::Success, __('Updated successfully'));
        return redirect()->route('todo.edit', $todo->id)->with('alerts', $this->getAlerts());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        //
    }
}
