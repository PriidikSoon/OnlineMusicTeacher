@include('head')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">Tasks</h3>
                        </div>
                        @if(Auth::user()->type == 'TEACHER')
                            <div class="col col-xs-6 text-right">
                                <a href="addTask"><button type="button" class="btn btn-sm btn-primary btn-create">Create New</button></a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th class="hidden-xs">ID</th>
                            <th>Student</th>
                            <th>Exercise</th>
                            <th>Due date</th>
                            <th>Description</th>
                            <th>Grade</th>
                            <th>Status</th>
                            <th><em class="fa fa-cog"></em></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <td class="hidden-xs">{{ $task->id }}</td>
                                <td>{{ $task->student->first_name }} {{ $task->student->last_name }}</td>
                                <td>{{ $task->exercise->title }}</td>
                                <td>{{ $task->due_date }}</td>
                                <td>{{ $task->description }}</td>
                                <td>{{ $task->grade }}</td>
                                <td>{{ $task->status }}</td>
                                <td align="center">
                                    @if(Auth::user()->type == 'TEACHER')
                                        <a href="task?id={{ $task->id }}" class="btn btn-default"><em class="fa fa-pencil"></em></a>
                                        {{--<a class="btn btn-danger"><em class="fa fa-trash"></em></a>--}}
                                    @else
                                        <a href="sightReading?taskID={{ $task->id }}" class="btn btn-default"><em class="fa fa-play"></em></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

            </div>

        </div></div></div>

@include('footer')