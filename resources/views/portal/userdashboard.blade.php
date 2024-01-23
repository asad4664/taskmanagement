@extends('portal.layout.app')
@section('content')
     <!-- Content Header (Page header) -->
     <div class="content-header">
       <div class="container-fluid">
         <div class="row mb-2">
           <div class="col-sm-6">
             <h1 class="m-0">Dashboard</h1>
           </div><!-- /.col -->
           <div class="col-sm-6">
             <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="#">Home</a></li>
               <li class="breadcrumb-item active">Dashboard</li>
             </ol>
           </div><!-- /.col -->
         </div><!-- /.row -->
       </div><!-- /.container-fluid -->
     </div>
     <!-- /.content-header -->
     <?php
$id = request()->route('id');
?>
     <!-- Main content -->
     <section class="content">
       <div class="container-fluid">
         <!-- Small boxes (Stat box) -->
         <div class="row">
           <div class="col-lg-3 col-6">
             <!-- small box -->
             <div class="small-box bg-info">
        <div class="inner">
        <h3>{{ $data['total_tasks'] }}</h3>
            <p>All Tasks</p>
        </div>
        <div class="icon">
            <i class="ion ion-bag"></i>
        </div>
        <a href="{{ route('task.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
           </div>
           <!-- ./col -->
           <div class="col-lg-3 col-6">
             <!-- small box -->
             <div class="small-box bg-success">
               <div class="inner">
               <!-- <h3>{{ auth()->user()->tasks()->where('progress', 100)->count() }}</h3> -->
               <h3>{{ $data['completed_tasks'] }}</h3>
                 <p>Completed Tasks</p>
               </div>
               <div class="icon">
                 <i class="ion ion-stats-bars"></i>
               </div>
               <a href="{{route('subtask.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
             </div>
           </div>
           <!-- ./col -->
           <div class="col-lg-3 col-6">
             <!-- small box -->
             <div class="small-box bg-warning">
               <div class="inner">
               <!-- <h3>{{ auth()->user()->tasks()->where('progress', '<', 100)->count() }}</h3> -->
               <h3>{{ $data['pending_tasks'] }}</h3>
                 <p>In-Progress Tasks</p>
               </div>
               <div class="icon">
                 <i class="ion ion-cube"></i>
               </div>
               <a href="{{route('subtask.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
             </div>
           </div>
           <!-- ./col -->
           <div class="col-lg-3 col-6">
             <!-- small box -->
             <div class="small-box bg-danger">
               <div class="inner">
               <h3>{{ $data['pending_tasks'] }}</h3>
                 <p>Pending Tasks</p>
               </div>
               <div class="icon">
                 <i class="ion ion-person"></i>
               </div>
               <a href="{{route('subtask.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
             </div>
           </div>
           <!-- ./col -->
         </div>
         <div class="row">
       
        </div>
        <div class="row">
          <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header d-flex">
                        <h3 class="card-title nowrap">
                            <i class="far fa-chart-bar"></i>
                            Tasks Progress &nbsp;<small id="chart-1-display-dates" style="color: red;"></small>
                        </h3>
                        <div class="input-group justify-content-end">
                            <button id="chart-1-spinner" class="btn btn-info mr-1" style="display: none;">
                                <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                            </button>
                            <!-- <button type="button" class="btn btn-default float-right" id="chart-1-daterange-btn">
                                <i class="far fa-calendar-alt"></i> Date Range
                                <i class="fas fa-caret-down"></i>
                            </button> -->
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <!-- <canvas id="bar-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas> -->
                            <div id="projectsChart"></div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
         <!-- /.row -->
         
       </div><!-- /.container-fluid -->
       <div class="card card-info card-outline">
       <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <h4>Activities</h4>
                </div>
               
                <div class="col-6 text-right">
                   
                <!-- <label for="userFilter">Filter by User:</label> -->
                @if(auth()->user()->hasPermissionTo('view_allactivities'))
                  
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
                           

                        </tr>
                        @endif
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
     </section>
     <!-- /.content -->
@endsection
@section('script')
    <script src="{{ url('/portal') }}/plugins/chart.js/Chart.min.js"></script>
    <script src="{{ url('/portal') }}/plugins/chart.js/Chart.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>

   

    <script>
      
        
        //-------------
        //- BAR CHART -
        //-------------

        Highcharts.chart('projectsChart', {
    chart: {
        type: 'column'
    },
    title: {
        text: '',
        align: 'left'
    },
    subtitle: {
        text: '',
        align: 'left'
    },
    xAxis: {
      type: 'category',
        title: {
            text: null
        },
        gridLineWidth: 1,
        lineWidth: 0,
        labels: {
            rotation: 0,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: '',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        },
        gridLineWidth: 0
    },
    tooltip: {
      headerFormat: '',
      pointFormat: '<b>{point.name}: {point.y:,.0f}%</b>',
      //valueSuffix: ' %'
    },
    plotOptions: {
        bar: {
            borderRadius: '50%',
            dataLabels: {
                enabled: true
            },
            groupPadding: 0.1
        }
    },
    legend: {
      enabled: false,
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -40,
        y: 80,
        floating: true,
        borderWidth: 1,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
        shadow: true
    },
    credits: {
        enabled: false
    },
    series: [{
      name: 'Projects',
            colorByPoint: true,
            data: [
              <?php foreach($tasks_chart as $subtask){ ?>
                {
                    name: '{{$subtask->title}}',
                    y: {{$subtask->progress}},
                },
                <?php } ?>
            ]
        }]
});



    


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
                return data;
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