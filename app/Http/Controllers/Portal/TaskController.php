<?php

namespace App\Http\Controllers\Portal;
use App\Models\Task;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\TaskAssignment;
use App\Models\SubTask;



class TaskController extends Controller
{
    public function index()

    {   
        $permissionResult = check_permission('view_task');
        if ($permissionResult instanceof \Illuminate\Http\RedirectResponse) {
        return $permissionResult;
        }
        $userId = auth()->user()->id;
        $projects=Project::all();
        $users=User::all();
        $userassign=User::where("unit_id", $userId)->get();
        $tasks = Task::all();

        return view('portal.task.index',compact('projects','users', 'userassign', 'tasks'));
    }

    public function add()
    {
        $permissionResult = check_permission('create_task');
        if ($permissionResult instanceof \Illuminate\Http\RedirectResponse) {
        return $permissionResult;
        }
        return view('portal.task.add');
          
    }

    public function edit($id)
    {
        $permissionResult = check_permission('edit_task');
        if ($permissionResult instanceof \Illuminate\Http\RedirectResponse) {
        return $permissionResult;
        }
        $task = Task::findorfail($id);
        return view('portal.task.edit', compact('task'));
    }

    public function delete($id)
    {
        $permissionResult = check_permission('delete_task');
        if ($permissionResult instanceof \Illuminate\Http\RedirectResponse) {
        return $permissionResult;
        }
        $task  = Task::where('id', $id)->delete();
        return redirect()->route('task.index')->with('success', 'task deleted successfully');
    }

    public function list(Request $request)
{
    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length");

    $columnIndex_arr = $request->get('order');
    $columnName_arr = $request->get('columns');
    $order_arr = $request->get('order');
    $search_arr = $request->get('search');

    $columnIndex = $columnIndex_arr[0]['column'];
    $columnName = $columnName_arr[$columnIndex]['data'];
    $columnSortOrder = $order_arr[0]['dir'];
    $searchValue = $search_arr['value'];

    $userId = auth()->user()->id;

    $totalRecords = Task::select('count(*) as allcount')->count();
    $totalRecordswithFilter = Task::select('count(*) as allcount')
        ->where(function ($query) use ($searchValue, $userId) {
            $query->where('title', 'like', '%' . $searchValue . '%')
                  ->orWhere('description', 'like', '%' . $searchValue . '%')
                  ->orWhere('priority', 'like', '%' . $searchValue . '%')
                  ->orWhereHas('task_project', function ($subquery) use ($searchValue) {
                      $subquery->where('name', 'like', '%' . $searchValue . '%');
                  })
                  ->orWhereHas('task_creator', function ($subquery) use ($searchValue) {
                    $subquery->where('name', 'like', '%' . $searchValue . '%');
                })
                  ->orWhereHas('task_manager', function ($subquery) use ($searchValue) {
                      $subquery->where('name', 'like', '%' . $searchValue . '%');
                  });
        })
        ->unless(auth()->user()->hasPermissionTo('view_alltasks'), function ($query) {
            return $query->where('assigned_to', auth()->id());
        })
        ->count();

    $records = Task::where(function ($query) use ($searchValue, $userId) {
            $query->where('title', 'like', '%' . $searchValue . '%')
                  ->orWhere('description', 'like', '%' . $searchValue . '%')
                  ->orWhere('priority', 'like', '%' . $searchValue . '%')
                  ->orWhereHas('task_project', function ($subquery) use ($searchValue) {
                      $subquery->where('name', 'like', '%' . $searchValue . '%');
                  })
                  ->orWhereHas('task_creator', function ($subquery) use ($searchValue) {
                    $subquery->where('name', 'like', '%' . $searchValue . '%');
                })
                  ->orWhereHas('task_manager', function ($subquery) use ($searchValue) {
                      $subquery->where('name', 'like', '%' . $searchValue . '%');
                  });
        })
        ->unless(auth()->user()->hasPermissionTo('view_alltasks'), function ($query) {
            return $query->where('assigned_to', auth()->id());
        })
        ->orderBy($columnName, $columnSortOrder)
        ->skip($start)
        ->take($rowperpage)
        ->get();

    $data_arr = array();

    foreach ($records as $record) {
        $route = route('task.edit', $record->id);
        $delete_route = route('task.delete', $record->id);
        
        $data_arr[] = array(
            "id" => $record->id,
            "title" => $record->title,
            "due_date" => $record->duedate,
            "description" => $record->description,
            "priority" => $record->priority,
            // "project" => $record->task_project->name. " | ".$record->task_project->location ,
            "assigned_to"=> $record->task_manager->name,
            "created_by"=> $record->task_creator->name,
            "progress"=> $record->progress,
            "action" => '<div class="btn-group">
                                <a href="' . $route . '" class="mr-1 text-info" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="#" onclick="delete_confirmation(\'' . $delete_route . '\')" class="mr-1" title="Delete">
                                    <i class="fa fa-trash"></i>
                                </a>
                              

                         
                        </div>'
        );
    }

    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordswithFilter,
        "aaData" => $data_arr
    );

    return \Response::json($response);
}

public function subtask_list(Request $request, $id)
{
   $data=SubTask::all();
   $tasks=Task::where("id", $id)->get();
   $users=User::all();
   return view('portal.task.subtasks',compact('data', 'tasks', 'users'));

}

   public function store(Request $request)
    {
        
        $permissionResult = check_permission('create_task');
        if ($permissionResult instanceof \Illuminate\Http\RedirectResponse) {
        return $permissionResult;
        }
        $request->validate([
            'title' => 'required',
            'Description' => 'required',
            'dueDate' => 'required',
            'priority' => 'required',
            //'project' => 'required',
            'assigned_to' => 'required'
        ]);
        $task = new Task([
            'title' => $request->title,
            'description' => $request->Description,
            'duedate' => date('Y-m-d', strtotime($request->dueDate)),
            'priority' => $request->priority,
            'project' => $request->project,
            'assigned_to' => $request->assigned_to,
            'created_by' => auth()->user()->id
            // Add other fields as needed
        ]);
    
    
        // Save the task to the database
        $task->save();

        $taskAssignment = new TaskAssignment([
            // 'project_id' => $request->project,
            'project_id' => 1,
            "task_id" => $task->id,
            'collaborators' => json_encode($request->collaborators),
            // Add other fields as needed
        ]);
    
        // Save the task assignment to the database
        $taskAssignment->save();
     
        
        return redirect()->route('task.index')->with('success', 'task created successfully');
    }
    public function update(Request $request, $id)
    {
        $permissionResult = check_permission('edit_task');
        if ($permissionResult instanceof \Illuminate\Http\RedirectResponse) {
        return $permissionResult;
        }
        $request->validate([
            'title' => 'required|max:1000', // Change 'name' to 'title'
        'duedate' => 'required',
        'description' => 'required',
        ]);
        Task::where("id", $id)->update([
            "title" => $request->title,
            "duedate" => $request->duedate,
            "description" => $request->description,
        ]);
        return redirect()->route('task.index')->with('success', 'task updated successfully');
    }



        
}
