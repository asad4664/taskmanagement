@extends('portal.layout.app')

@section('content')


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tasks</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Projects</a></li>
                        <li class="breadcrumb-item active">Tasks</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        
        <div class="card card-info card-outline">
            <div class="card-header">
               
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addTaskModal">
                  Add Task
                </button>
               
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="table1" width="100%">
                    <thead>
                        <tr>
                            <th> Sr. </th>
                            <th> Title </th>
                            <th> Due Date </th>
                            <th> Description </th>
                            <th> Priority </th>
                            <!-- <th> Project </th> -->
                            <th> Assigned to </th> 
                            <th> Progress </th> 
                            <th> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
               </table>
           </div>
           <!-- Role Grant Modal -->
           <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaskModalLabel">Add Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('task.store')}}" method="POST">
                    @csrf
                    <div class="form-group">
                      <label for="Title">Title</label>
                      <input type="text" class="form-control" name="title" id="Title" placeholder="Title">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" rows="3" name="Description" placeholder="Description"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="dueDate">Due Date</label>
                      <input type="text" class="form-control" name="dueDate" id="dueDate" placeholder="Due Date">
                    </div>
                    <div class="form-group">
                        <label>Priority</label>
                        <select name="priority" class="form-control">
                          <option value="Medium">Medium</option>
                          <option value="High">High</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <!--<label>Project</label> -->
                        <select style="display:none;"  name="project" class="form-control">
                        @foreach($projects as $project)
                          <option value="{{$project->id}}">{{$project->name}} | {{$project->location}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Assigned to</label>
                        <select name="assigned_to" class="form-control">
                            @foreach($users as $user)
                          <option value="{{$user->id}}">{{$user->name}} | {{$user->designation}} | {{$user->employee_id}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Collaborator</label>
                        <select multiple name="collaborators[]" class="form-control">
                        @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->name}} | {{$user->designation}} | {{$user->employee_id}}</option>
                        @endforeach
                        </select>
                    </div>

                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

           <!-- /.card-body -->
           <div class="card-footer clearfix">
            <div class="d-flex justify-content-center">
            </div>
        </div>
    </div>
    <!-- /.card -->

</section>

@endsection



@section('script')
<script type="text/javascript">
    $(function () {

        $('#table1').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('task.list')}}",
           responsive:true,
            columns: [
                { data: 'id' },
                {
                    data: 'title',
                    render: function (data, type, row) {
                        // Render the title as a clickable link
                        return '<a href="{{ route("subtask.index", ["id" => "/"]) }}/' + row.id + '">' + data + '</a>';
                    }
                },
                { data: 'due_date' },
                { data: 'description' },
                { data: 'priority' },
                // { data: 'project' },
                { data: 'assigned_to' },
                { data: 'progress' },
                {
                    targets: -1,
                    data: 'action',
                },
            ],
        //     createdRow: function (row, data, dataIndex) {
        //     // Get the due date from the row's data
        //     var dueDate = moment(data.due_date);

        //     // Current date
        //     var today = moment();

        //     // Calculate the difference in days
        //     var daysDifference = dueDate.diff(today, 'days');

        //     // Apply background color based on conditions
        //     if (dueDate.isSame(today, 'day')) {
        //         // Due date is today
        //         $(row).css('background-color', '#FFEBD8');
        //     } else if (dueDate.isBefore(today, 'day')) {
        //         // Due date is in the past
        //         $(row).css('background-color', '#FFC5C5');
        //     } else if (daysDifference >= 5) {
        //         // At least 5 days remaining
        //         $(row).css('background-color', '#C7DCA7');
        //     }
        //     else if (daysDifference >0 && daysDifference < 5 ) {
        //         // At least 5 days remaining
        //         $(row).css('background-color', '#89B9AD');
        //     }
        // },
            columnDefs: [ {
                'targets': [3], // column index (start from 0)
                'orderable': false, // set orderable false for selected columns
            }],
            order: [[0, 'asc']],
        });
    });
</script>
<script>
$(function() {
    $('#dueDate').daterangepicker({
        singleDatePicker: true,
    });
});
</script>

@endsection