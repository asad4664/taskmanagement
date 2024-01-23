@extends('portal.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Task Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('task.index')}}">Tasks</a></li>
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
                @foreach($tasks as $task)
                    <h4>Activities performed on Task: {{$task->title}}</h4>
                @endforeach
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12" id="accordion">
                    @foreach($tasks as $task)
                    <div class="card card-light">
                        <div class="card-header d-flex">
                            <h4 class="card-title  mr-5">
                               
                                   Task Name: {{$task->title}}
                               
                            </h4>
                            <div class="progress" style="width: 180px;">
                                <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="{{$task->progress}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$task->progress}}%">
                                    <span class="sr-only"> {{$task->progress}}</span> {{$task->progress}}%
                                </div>
                            </div>
                        </div>
                        <div id="activity{{$task->id}}" class="collapse show" data-parent="#accordion">
                            <div class="card-body">
                                @foreach($task->subtasks as $subtask)
                                <div class="post">
                                    <div class="user-block">
                                    <ul class="fc-color-picker" id="color-chooser">
                                        <li><a class="text-lightblue" style="font-size: 25px;"><i class="fas fa-square"></i></a></li>
                                    </ul>
                                        <span class="username">
                                           {{$subtask->name}}
                                        </span>
                                        <span class="description">Due Date - {{$task->duedate}}</span>
                                    </div>


                                    <p>
                                        {{$subtask->description}}<br>
                                        {{$subtask->created_at}}
                                    </p>
                                    <p>
                                        Activity performed by: {{$subtask->sub_task_creator->name}} | {{$subtask->sub_task_creator->designation}} | {{$subtask->sub_task_creator->employee_id}}</a>
                                    </p>
                                    <!-- <div class="progress w-100">
                                        <div class="progress-bar bg-green progress-bar-striped" role="progressbar" aria-valuenow="{{$task->progress}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$task->progress}}%">
                                            <span class="sr-only"> {{$task->progress}}</span>
                                        </div>
                                    </div> -->
                                </div>
                                @endforeach

                            </div>
                        </div>

                    </div>
                    @endforeach
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
</section>

@endsection



@section('script')
<script>
    // Date Picker
    $(function() {
        $('#dueDate').daterangepicker({
            singleDatePicker: true,
        });
    });

    // Slider
    $('#progressSlider').slider({
        formatter: function(value) {
            return 'Current value: ' + value;
        }
    });
</script>

@endsection
