<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\task;
use App\User; // 追加

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::check()) {
            $login_id = \Auth::id(); 
            $tasks = task::where('user_id',$login_id)->get();
    
            return view('tasks.index', [
                'tasks' => $tasks,
            ]);
        }else{
            return view('welcome');
            
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new task;

        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'status' => 'required|max:10',   // 追加
            'content' => 'required|max:191',
        ]);
        
        $task = new task;
        $task->status = $request->status;    // 追加
        $task->content = $request->content;
        $task->user_id = $request->user()->id;
        $task->save();

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = task::find($id);
        $login_id = \Auth::id();
        
        if($task->user_id == $login_id){
            return view('tasks.show', [
                'task' => $task,
            ]);
        }else{
            return redirect('/');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = task::find($id);
        $login_id = \Auth::id();
        
        if($task->user_id == $login_id){
            return view('tasks.edit', [
                'task' => $task,
            ]);
        }else{
            return redirect('/');
        }
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
        $task = task::find($id);
        $login_id = \Auth::id();
        
        if($task->user_id == $login_id){
            $this->validate($request, [
                'status' => 'required|max:10',   // 追加
                'content' => 'required|max:191',
            ]);
            
            $task = task::find($id);
            $task->status = $request->status;    // 追加
            $task->content = $request->content;
            $task->save();
            return redirect('/');
        }else{
            return redirect('/');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = task::find($id);
        $login_id = \Auth::id();
        
        if($task->user_id == $login_id){
            $task = task::find($id);
            $task->delete();
            return redirect('/');
        }else{
            return redirect('/');
        }
    }
}
