<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    /**
     * Display available tasks which are retrived from the database
     * If there is no task, then it'll return 404 error.
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

    public function create()
    {
        //
    }

    /**
     * Check for validation and
     * Checks for attached file which can be null.
     * And stores image file to filesystem and task to database.
     * Updated the function default parameter.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task' => 'required|string|max:191',
            'status' => 'required',
            'figure' => 'nullable|image',
        ]);


        if($request->file('figure')){
            $path = $request->file('figure')->store('public/figures');
            // $visibility = Storage::getVisibility($path);
            // Storage::setVisibility($path, 'public');
        }

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else{
            $tasks = Todo::create([
                'task' => $request->task,
                'status' => $request->status,

                'figure' => $path,
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
     * Display the specified task.
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

    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage and database.
     * Updated the function default parameter.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'task' => 'required|string|max:191',
            'status' => 'required',
            'figure' => 'nullable|image',
        ]);


        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else{
            $task = Todo::find($id);

            $path = $task->figure;

            if($request->file('figure')){
                $new_path = $request->file('figure')->store('public/figures');

                Storage::delete($path);
                $path = $new_path;
            }

            $task->update([
                'task' => $request->task,
                'status' => $request->status,
                'figure' => $path,
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
            Storage::delete($task->figure);
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
    // Complete will set status to complete if called.
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
