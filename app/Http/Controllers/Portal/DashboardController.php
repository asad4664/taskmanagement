<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\Order;
use App\Models\Category;
use App\Models\Group;
use App\Models\Application;
use App\Models\Tag;
use App\Models\Product;
use App\Models\User;
use App\Models\Project;
use App\Models\SubTask;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $data = [
            'total_users' => User::count(),
            'total_projects' => Project::count(),
            'total_tasks' => Task::count(),
            //'total_subtasks' => SubTask::count(),
            //'total_projects' => 0,
            //'total_tasks' => 0,
            'total_subtasks' => 0,
        ];
        $permissionResult = check_permission('view_subtask');
        if ($permissionResult instanceof \Illuminate\Http\RedirectResponse) {
        return $permissionResult;
        }
        $session_id = auth()->user()->id;
        $tasks_chart=Task::where('assigned_to', $session_id)->get();
        $tasks=Task::all();
        $users= User::all();
        $currentUser = auth()->user();
        $id = auth()->user()->id;
        $taskss = Task::where('assigned_to', $id)->get();
       // return view('portal.subtasks.index',compact('tasks'));
        return view('portal.dashboard', compact('data', 'tasks', 'taskss', 'users', 'tasks_chart', 'currentUser'));

        
    }
    public function userdashboard($id)
    {

        $data = [
            
            'total_users' => User::count(),
            'total_projects' => Project::count(),
            'total_tasks' => Task::where('assigned_to', $id)->get()->count(),
            'completed_tasks' => Task::where('assigned_to', $id)
            ->where('progress', 100)
            ->get()->count(),
            'pending_tasks' => Task::where('assigned_to', $id)
            ->where('progress', '<', 100)
            ->get()->count(),
            //'total_subtasks' => SubTask::count(),
            //'total_projects' => 0,
            //'total_tasks' => 0,
            'total_subtasks' => 0,
        ];
         $tasks=Task::where('assigned_to', $id)->get();
        $tasks_chart=Task::where('assigned_to', $id)->get();
        // return view('portal.subtasks.index',compact('tasks'));
         return view('portal.userdashboard', compact('data', 'tasks', 'tasks_chart'));
    }
    
    
}
