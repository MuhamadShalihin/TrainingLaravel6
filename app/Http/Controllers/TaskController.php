<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Exports\TaskExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Task;
use App\User;
use PDF;

class TaskController extends Controller
{
    protected function getUsersList($users, $key = 'name')
    {
        $input = [];

        $input[''] = "Choose user";

        foreach ($users as $user)
        {
            $input[$user->id] = $user->{$key};
        }

        return $input;
    }

    public function getList()
    {
        $tasks = \App\Task::orderBy('id', 'asc');

        $users = User::get();

        $input = $this-> getUsersList($users, 'name');

        $inputEmail = $this-> getUsersList($users, 'email');

        $params = (object) request()->all();

        if(request()->filled('name'))
        {
            $tasks = $tasks->where('name', 'like', "%" . request()->name . "%");
        }

        if(request()->filled('user_id'))
        {
            $tasks = $tasks->where('user_id', request()->user_id);
        }

        if(request()->filled('email'))
        {
            $tasks = $tasks->where('user_id', request()->email);
        }
        
        $tasks = $tasks->paginate(10);

        $paramString = request()->getQueryString();

        return view('tasks.index', compact('tasks', 'users', 'params', 'input', 'inputEmail', 'paramString'));
    }

    public function getCreateTask()
    {
        $users = User::get();

        $input = $this-> getUsersList($users, 'name');

        return view('tasks.create', compact('input', 'inputEmail'));
    }

    public function postCreateTask()
    {
        $task = new Task();

        $task->name = request()->name;

        $task->content = request()->content;

        $task->user_id = request()->user_id;

        $task->save();

        return redirect()->to('/tasks')->with('status', 'successfully submitted');
    }

    public function getViewTask($id)
    {
        $task = Task::find($id);

        $users = User::get();

        $input = $this-> getUsersList($users);

        return view('tasks.view', compact('users', 'task', 'input'));
    }

    public function postDelete($id)
    {
        Task::where('id', $id)->delete();
        return redirect()->back()->with('status', 'successfully deleted');

    }

    public function getViewTaskPdf($id)
    {
        $task = Task::find($id);

       
        $pdf = PDF::loadView('tasks.view-pdf',compact( 'task'));

        $pdf->setPaper('AS', 'portrait');

        return $pdf->stream();
        
        return $pdf->download();
    }

    public function getListExcel()
    {
        $tasks = \App\Task::orderBy('id', 'desc');

        if(request()->filled('name'))
        {
            $tasks = $tasks->where('name', 'like', "%" . request()->name . "%");
        }

        if(request()->filled('user_id'))
        {
            $tasks = $tasks->where('user_id', request()->user_id);
        }

        if(request()->filled('email'))
        {
            $tasks = $tasks->where('user_id', request()->email);
        }

        $tasks = $tasks->get();
        
        return Excel::download(new TaskExport($tasks), 'tasks.xlsx');
    }
}
