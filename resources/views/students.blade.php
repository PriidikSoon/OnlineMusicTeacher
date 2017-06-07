@include('head')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">Students</h3>
                        </div>
                        <div class="col col-xs-6 text-right">
                            <a href="addStudent"><button type="button" class="btn btn-sm btn-primary btn-create">Add</button></a>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Instrument</th>
                            <th>Email</th>
                            <th>Notes</th>
                            <th>Confirmed</th>
                            <th><em class="fa fa-cog"></em></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                <td>{{ $student->instrument }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->notes }}</td>
                                <td class="text-center">@if($student->confirmed) <em class="fa fa-check"></em> @else <em class="fa fa-times"></em>@endif</td>
                                <td align="center">
                                    <a href="profile?id={{ $student->id }}" class="btn btn-default"><em class="fa fa-pencil"></em></a>
                                    <a href="profile?id={{ $student->id }}&remove=true" class="btn btn-danger"><em class="fa fa-trash"></em></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

        </div></div></div>

@include('footer')