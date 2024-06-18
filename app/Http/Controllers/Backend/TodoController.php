<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
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
        return view('backend.todo.CalendarTodo');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        Gate::authorize('create', Todo::class);
        return view('backend.todo.CreateTodo');
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
        return view('backend.todo.EditTodo', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        //
    }
}
