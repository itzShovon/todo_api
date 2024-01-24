<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Models\Todo;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateTodoRequest;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Todo::all();

        if($tasks->count() > 0){
            return response()->json([
                'status' => 200,
                'tasks' => $tasks
            ], 200);
        } else{
            return response()->json([
                'status' => 404,
                'message' => 'Got nothing'
            ], 404);
        }
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
        $validator = Validator::make($request->all(), [
            'task' => 'required|string|max:191',
            'status' => 'required',
            'figure' => 'nullable|string|max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else{
            $tasks = Todo::create([
                'task' => $request->task,
                'status' => $request->status,
                'figure' => $request->figure,
            ]);

            if($tasks){
                return response()->json([
                    'status' => 200,
                    'message' => 'task added'
                ], 200);
            } else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Something went wrong!'
                ], 500);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $task = Todo::find($id);

        if($task){
            return response()->json([
                'status' => 200,
                'task' => $task
            ], 200);
        } else{
            return response()->json([
                'status' => 404,
                'message' => 'Got nothing'
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'task' => 'required|string|max:191',
            'status' => 'required',
            'figure' => 'nullable|string|max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else{
            $task = Todo::find($id);

            $task->update([
                'task' => $request->task,
                'status' => $request->status,
                'figure' => $request->figure,
            ]);

            if($task){
                return response()->json([
                    'status' => 200,
                    'message' => 'task updated'
                ], 200);
            } else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Something went wrong!'
                ], 500);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Todo::find($id);

        if($task){
            $task->delete();

            return response()->json([
                'status' => 200,
                'message' => 'task deleted'
            ], 200);
        } else{
            return response()->json([
                'status' => 404,
                'message' => 'Got nothing'
            ], 404);
        }
    }

    // Custom methods
    public function complete($id)
    {
        $task = Todo::find($id);

        $task->update([
            'status' => 'Completed',
        ]);

        if($task){
            return response()->json([
                'status' => 200,
                'message' => 'task completed'
            ], 200);
        } else{
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong!'
            ], 500);
        }
    }
}
