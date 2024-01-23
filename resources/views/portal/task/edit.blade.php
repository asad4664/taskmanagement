@extends('portal.layout.app')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Task</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Users</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card card-info card-outline">
            {{-- <div class="card-header">
               <h4>General Information</h4>
            </div> --}}
            <div class="card-body">
                <form action="{{route('task.update', $task->id)}}" method="POST">
                    {{csrf_field()}}
                    <label  class="form-label required">Task Name</label>
                    <input type="text" class="form-control" id="name" name="title" value="{{old('name') ?? $task->title}}" required/>
                    <label for="dueDateTime">Due Date</label>
                    <input type="datetime-local" class="form-control" name="duedate" id="duedate" value="{{ now()->setTimezone('Asia/Karachi')->format('Y-m-d\TH:i') }}">

                    <label  class="form-label required mt-2">Description </label>
                    <input type="text" class="form-control" id="description" name="description" value="{{old('description') ?? $task->description}}" required/>
                    
                    <button type="submit" class="btn btn-primary my-2 float-right">Submit</button>
                </form>
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



