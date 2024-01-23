<?php

namespace App\Http\Controllers\Portal;
use App\Models\SubTask;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\DB;



class SubTaskController extends Controller
{
    public function index()

    {   
        $permissionResult = check_permission('view_subtask');
        if ($permissionResult instanceof \Illuminate\Http\RedirectResponse) {
        return $permissionResult;
        }
        $currentUser = auth()->user();
        $tasks=Task::all();
        $users= User::all();
        $id = auth()->user()->id;

// Assuming you have a model named Task
$taskss = Task::where('assigned_to', $id)->get();
        return view('portal.subtasks.index',compact('tasks', 'taskss', 'users', 'currentUser'));
       
       
       
    }

    public function add()
    {
        $permissionResult = check_permission('create_subtask');
        if ($permissionResult instanceof \Illuminate\Http\RedirectResponse) {
        return $permissionResult;
        }
        return view('portal.subtasks.add');
          
    }

    public function edit($id)
    {
        $permissionResult = check_permission('edit_subtask');
        if ($permissionResult instanceof \Illuminate\Http\RedirectResponse) {
        return $permissionResult;
        }
        $subtask = Subtask::findOrFail($id);
        return view('portal.subtasks.edit', compact('subtask'));
    
    }

    public function delete($id)
    {
        $permissionResult = check_permission('delete_subtask');
        if ($permissionResult instanceof \Illuminate\Http\RedirectResponse) {
        return $permissionResult;
        }
        $subtasks  = SubTask::where('id', $id)->delete();
        return redirect()->route('tasks.index')->with('success', 'subtasks deleted successfully');
    }

    public function list(Request $request)
    {
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = SubTask::select('count(*) as allcount')->count();
        $totalRecordswithFilter = SubTask::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->count();
        $records = SubTask::orderBy($columnName, $columnSortOrder)
            ->where('name', 'like', '%' . $searchValue . '%')
            ->select('*')
            ->skip($start)
            ->take($rowperpage)
            // ->orderBy($columnName, $columnSortOrder)
            ->orderByDesc('created_at')
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $route = route('subtask.edit', $record->id);
            $delete_route = route('subtask.delete', $record->id);
            $data_arr[] = array(
                "id" => $record->id,
                "name" => $record->name,
                "action" => '<div class="btn-group">
                <a href="' . $route . '" class="mr-1 text-info" title="Edit">
                    <i class="fa fa-edit"></i>
                </a>
                <a href="#" onclick="delete_confirmation(\'' . $delete_route . '\')" class="mr-1 text-danger" title="Delete">
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

   public function store(Request $request)
    {

        $permissionResult = check_permission('create_subtask');
        if ($permissionResult instanceof \Illuminate\Http\RedirectResponse) {
        return $permissionResult;
        }
        $request->validate([
            'task' => 'required',
            'name' => 'required|max:100',
            'start_datetime' => 'required',
            'end_datetime' => 'required',
            'description' => 'required',
            'progress' => 'required',
            
            
        ]);
      
        $subtask = SubTask::createSubTask($request->task, $request->name, $request->start_datetime, $request->end_datetime, $request->description);
        Task::where("id", $request->task)->update([
            "progress" => $request->progress,
        ]);
        return redirect()->route('subtask.index')->with('success', 'subtasks created successfully');
    }
    

    public function listsub(Request $request)
    {
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = SubTask::select('count(*) as allcount')->count();
        $totalRecordswithFilter = SubTask::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->orWhere('description', 'like', '%' . $searchValue . '%')->count();
        // $records = SubTask::orderBy($columnName, $columnSortOrder)
        //     ->where(function ($query) use ($searchValue) {
        //         $query->where('name', 'like', '%' . $searchValue . '%')
        //               ->orWhere('description', 'like', '%' . $searchValue . '%');

        //     })
        //     // /->where('role', 'Employee') // Add the condition for role
        //     ->select('*')
        //     ->skip($start)
        //     ->take($rowperpage)
        //     ->orderBy($columnName, $columnSortOrder)
        //     ->get();
        $records = DB::table('task')->join('sub_task', 'task.id', '=', 'sub_task.task_id')->select('task.title', 'sub_task.*')->get();

       
        $data_arr = array();

        foreach ($records as $record) {
            $route = route('user.edit', $record->id);
            $delete_route = route('user.delete', $record->id);

            if (auth()->user()->hasPermissionTo('manage_permission')) {
                $action=
                            '<div class="btn-group">
                            <a href="#"  onclick="openRoleModal(' . $record->id . ')" class="mr-1 text-success" title="Grant Role">
                            <i class="fa fa-plus"></i>
                            </a>
                            <a href="' . $route . '" class="mr-1 text-info" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="#" onclick="delete_confirmation(\'' . $delete_route . '\')" class="mr-1 text-danger" title="Delete">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>' ;
            } else {
                $action= '<div class="btn-group">
                            
                            <a href="' . $route . '" class="mr-1 text-info" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="#" onclick="delete_confirmation(\'' . $delete_route . '\')" class="mr-1 text-danger" title="Delete">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>' ;
            }
           
            $data_arr[] = array(
                "id" => $record->id,
                "task" => $record->title,
                "activityname" => $record->name,
                "description"=>$record->description,
                "duedate"=>$record->created_at, 
                "created_at"=>$record->created_at,
                "created_by"=>$record->created_by, 
                "action" => 
                    $action
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
    public function update(Request $request, $id)
    {

       $permissionResult = check_permission('edit_subtask');
        if ($permissionResult instanceof \Illuminate\Http\RedirectResponse) {
        return $permissionResult;
        }
        $request->validate([
            'name' => 'required|max:1000',
            'description' => 'required',
            'start_datetime' => 'required',
            'end_datetime' => 'required',
        ]);
        SubTask::where("id", $id)->update([
            "name" => $request->name,
            "description" => $request->description,
            "start_datetime" => $request->start_datetime,
            "end_datetime" => $request->end_datetime,
        ]);
        return redirect()->route('subtask.index')->with('success', 'subtasks updated successfully');
    }

    public function user_activity(Request $reqeust,$id){
        if(auth()->user()->id==$id || auth()->user()->hasPermissionTo('view-useractivity') ){
                    $subtasks= SubTask::all()->where('created_by',$id);
                    return $subtasks;
        }
        else{
         return redirect()->route('dashboard')->with('error','You dont have sepecified Permission');
        }

    }
}
