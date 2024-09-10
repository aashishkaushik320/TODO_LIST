<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     //
    // }
    public function get_todo_list()

    {
        $tasks = Task::where('is_completed', 0)->get();
        return response()->json(['html' => view('components.todo-list', compact('tasks'))->render()]);
    }
    public function add_task(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:tasks,name',
        ]);
        $data = [
            'name' => $request->name,
            'is_completed' => 0,
        ];
        Task::create($data);
    }

    public function showall(){
        $tasks = Task::all();

        return response()->json(['html' => view('components.todo-list', compact('tasks'))->render()]);
    }
    public function action(Request $request)
    {
        try {
            $id = decrypt($request->id);

            if ($request->type == 'complete') {
                // DB::enableQueryLog();
                Task::find($id)->update(['is_completed' => 1]);
                // dd(DB::getQueryLog());
                $msg = 'Task Update Successful';
            } else if ($request->type == 'delete') {
                Task::find($id)->delete();
                $msg = 'Task Delete Successful';
            }
            return response()->json(['success' => true, 'message' => $msg]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Technical Issue!']);
        }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function delete(Request $request, $id)
    // {
    //     dd($request->all());
    // }
}
