@extends('portal.layout.app')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Activities</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Activity</li>
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
            <div class="row">
                <div class="col-6">
                    <h4></h4>
                </div>
               
                <div class="col-6 text-right">
                   
                <!-- <label for="userFilter">Filter by User:</label> -->
                @if(auth()->user()->hasPermissionTo('view_allactivities'))
                    <select class="form-control d-inline-block col-2" id="userFilter">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->name }} | {{ $user->designation }} | {{ $user->employee_id }}">{{ $user->name }} | {{ $user->designation }} | {{ $user->employee_id }}</option>
                        @endforeach
                    </select>
                    
                    <select class="form-control d-inline-block col-2" id="taskFilter">
                        <option value="">All Tasks</option>
                        @foreach($tasks as $task)
                            <option value="{{ $task->title }}">{{ $task->title }}</option>
                        @endforeach
                    </select>
                    @else
                    <select class="form-control d-inline-block col-2" id="taskFilter">
                        <option value="">All Tasks</option>
                        @foreach($taskss as $task)
                            <option value="{{ $task->title }}">{{ $task->title }}</option>
                        @endforeach
                    </select>
                    @endif
                    <button type="button" class="btn btn-default" id="daterange-btn">
                        <i class="far fa-calendar-alt"></i>
                        <span>Filters</span>
                        <i class="fas fa-caret-down"></i>
                    </button>
                    @if(auth()->user()->hasPermissionTo('create_subtask'))
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addActivityModal">
                        Add Activity
                    </button>
                    @endif
                    <!-- <label for="userSearch">Search by User:</label>
                    <input type="text" class="form-control" id="userSearch" placeholder="Enter user name"> -->
                </div>
            </div>
            <!-- Add these input fields within the Add Activity Modal in your view -->
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="subtaskTable">
                    <thead>
                        <tr>
                            <th>Activity ID</th>
                            <th>Task Title</th>
                            <th>Activity Name</th>
                            <th>Activity Description</th>
                            <th>Due Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Activity Created At</th>
                            <th>Activity Performed by</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                        @foreach($task->subtasks as $subtask)
                        @if(auth()->user()->id == $subtask->created_by)
                        <tr data-user-id="{{$subtask->sub_task_creator->id}}">
                            <td>{{$subtask->id}}</td>
                            <td>{{$task->title}}</td>
                            <td>{{$subtask->name}}</td>
                            <td>{{$subtask->description}}</td>
                            <td>{{$task->duedate}}</td>
                            <td>{{$subtask->start_datetime}}</td>
                            <td>{{$subtask->end_datetime}}</td>
                            <td>{{$subtask->created_at}}</td>
                            <td>
                                {{$subtask->sub_task_creator->name}} | {{$subtask->sub_task_creator->designation}} | {{$subtask->sub_task_creator->employee_id}}
                            </td>
                            <td>
                                <!-- Add actions/buttons for the new column -->
                                @if(auth()->user()->hasPermissionTo('edit_subtask'))
                                <button class="btn btn-info btn-sm">Edit</button>
                                @endif
                                <!-- <button class="btn btn-danger btn-sm">Delete</button> -->
                                <!-- Add more actions as needed -->
                            </td>

                        </tr>
                        @elseif(auth()->user()->hasPermissionTo('view_allactivities'))
                        <tr data-user-id="{{$subtask->sub_task_creator->id}}">
                            <td>{{$subtask->id}}</td>
                            <td>{{$task->title}}</td>
                            <td>{{$subtask->name}}</td>
                            <td>{{$subtask->description}}</td>
                            <td>{{$task->duedate}}</td>
                            <td>{{$subtask->start_datetime}}</td>
                            <td>{{$subtask->end_datetime}}</td>
                            <td>{{$subtask->created_at}}</td>
                            <td>
                                {{$subtask->sub_task_creator->name}} | {{$subtask->sub_task_creator->designation}} | {{$subtask->sub_task_creator->employee_id}}
                            </td>
                            <td>
                                <!-- Add actions/buttons for the new column -->
                                @if(auth()->user()->hasPermissionTo('edit_subtask'))
                                <button class="btn btn-info btn-sm">Edit</button>
                                @endif
                                <!-- <button class="btn btn-danger btn-sm">Delete</button> -->
                                <!-- Add more actions as needed -->
                            </td>

                        </tr>
                        @endif
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Activity Modal -->
        <div class="modal fade" id="addActivityModal" tabindex="-1" role="dialog" aria-labelledby="addActivityModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addActivityModalLabel">Add Activity</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('subtask.store')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="Name">Task</label>
                                <select name="task" class="form-control">
                                    
                                @foreach($taskss as $task)
                       
                       
                                    <option value="{{$task->id}}">{{$task->title}}</option>
                                   
                                   
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="Name">Name</label>
                                <input type="text" class="form-control" name="name" id="Name" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <label for="dueDateTime">Start Time/Date</label>
                                <input type="datetime-local" class="form-control" name="start_datetime" id="start_datetime" value="{{ now()->setTimezone('Asia/Karachi')->format('Y-m-d\TH:i') }}" placeholder="Start Time/Date">
                            </div>
                            <div class="form-group">
                                <label for="dueDateTime">End Time/Date</label>
                                <input type="datetime-local" class="form-control" name="end_datetime" id="end_datetime" value="{{ now()->setTimezone('Asia/Karachi')->format('Y-m-d\TH:i') }}" placeholder="Start Time/Date">
                            </div>


                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" rows="3" name="description" placeholder="Description"></textarea>
                            </div>
                            <!--<div class="form-group">
                                <label for="dueDate">Due Date</label>
                                <input type="text" name="duedate" class="form-control" id="dueDate" placeholder="Due Date">
                            </div>
                            <div class="form-group">
                                <label>Team Member</label>
                                <select name="" class="form-control">
                                    <option>Member1</option>
                                    <option>Member2</option>
                                </select>
                            </div> -->
                            <div class="form-group">
                                <label>Task Progress</label>
                                <div class="slider-red">
                                    <input id="progressSlider" type="text" value="" name="progress" class="slider form-control" data-slider-min="0" data-slider-max="100" data-slider-step="5" data-slider-orientation="horizontal" data-slider-selection="before" data-slider-tooltip="show">
                                </div>
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
    </div>


    </div>
</section>

@endsection

@section('script')
<!-- Ensure to include necessary libraries for DataTables, Date Picker, and Slider -->
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
    // Initialize DataTables
    var table = $('#subtaskTable').DataTable({
        "columnDefs": [
        {
            "targets": -1, // Targets the last column (Actions)
            "orderable": false, // Make the column not sortable
            "render": function(data, type, row) {
                // Customize the content of the Actions column
                var subtaskId = row[0]; // Assuming the subtask ID is in the first column
                return '<a href="{{ route("subtask.edit", ["id" => "/"]) }}/' + subtaskId + '">' + data + '</a>';
                // Add more buttons or HTML content as needed
                }
            }
        ],
        "order": [
        [0, 'desc'] // Set the default order of the first column (change [0, 'asc'] to the desired column index)
    ]
    });

    // User filter change event handler
    $('#userFilter').on('change', function() {
    var selectedUserId = $(this).val();

    // Show all rows if no user is selected
    if (selectedUserId === '') {
        table.columns(8).search('').draw();
    } else {
        // Filter the table based on the selected user's ID
        table.columns(8).search(selectedUserId).draw();
    }
});

// Task filter change event handler
$('#taskFilter').on('change', function() {
    var selectedUserId = $(this).val();

    // Show all rows if no user is selected
    if (selectedUserId === '') {
        table.columns(1).search('').draw();
    } else {
        // Filter the table based on the selected user's ID
        table.columns(1).search(selectedUserId).draw();
    }
});

    // DataTables date range filtering function
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex, startDatetime, endDatetime) {
            startDatetime = $('#daterange-btn').data('daterangepicker').startDate.format('YYYY-MM-DD HH:mm:ss');
            endDatetime = $('#daterange-btn').data('daterangepicker').endDate.format('YYYY-MM-DD HH:mm:ss');
            var activityCreatedAt = data[7]; // Assuming Activity Created At is in the 8th column

            if ((startDatetime === '' && endDatetime === '') || 
                (startDatetime === '' && activityCreatedAt <= endDatetime) || 
                (startDatetime <= activityCreatedAt && endDatetime === '') || 
                (startDatetime <= activityCreatedAt && activityCreatedAt <= endDatetime)) {
                return true;
            }
            return false;
        }
    );

    // Input event handler for the user search
    $('#userSearch').on('input', function() {
        var searchQuery = $(this).val().toLowerCase();

        // Filter the table based on the entered user name
        $('#subtaskTable tbody tr').each(function() {
            var userName = $(this).find('td').eq(8).text().toLowerCase();

            if (userName.includes(searchQuery)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Initialize date pickers
    $('#daterange-btn').daterangepicker(
        {
            ranges   : {
                'Today'       : [moment().format('DD-MM-YYYY'), moment()],
                'Yesterday'   : [moment().subtract(1, 'days').format('DD-MM-YYYY'), moment().subtract(1, 'days').endOf('day')],
                'Last 7 Days' : [moment().subtract(6, 'days').format('DD-MM-YYYY'), moment().endOf('day')],
                'Last 30 Days': [moment().subtract(29, 'days').format('DD-MM-YYYY'), moment().endOf('day')],
                'This Month'  : [moment().startOf('month').format('DD-MM-YYYY'), moment()],
                'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'All the Time'  : [moment().subtract(100, 'years').startOf('year'), moment()]
            },
            startDate: moment().subtract(100, 'years').startOf('year'),
            endDate  : moment(),
            locale: {
            format: 'DD-MM-YYYY hh:mm A'
            },
            showDropdowns: true,
            timePicker: true,
        },
        function (start, end) {
            $("#daterange-btn span").html(start.format('DD-MM-YYYY hh:mm:ss A') + " to " + end.format('DD-MM-YYYY hh:mm:ss A'))
            table.draw();
    });

    // Slider
    $('#progressSlider').slider({
        formatter: function(value) {
            return 'Current value: ' + value;
        }
    });
});

</script>

@endsection