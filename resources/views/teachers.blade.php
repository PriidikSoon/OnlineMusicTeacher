@include('head')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">Teachers</h3>
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
                            <th>Confirmed</th>
                            <th><em class="fa fa-cog"></em></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($teachers as $teacher)
                            <tr>
                                <td>{{ $teacher->first_name }} {{ $teacher->last_name }}</td>
                                <td>{{ $teacher->instrument }}</td>
                                <td>{{ $teacher->email }}</td>
                                <td class="text-center">
                                    @if($teacher->confirmed)
                                        <em class="fa fa-check"></em>
                                    @else
                                        <em class="fa fa-times"></em>
                                    @endif
                                </td>
                                <td align="center">
                                    @if(!$teacher->confirmed)
                                        <a href="teachers?teacherStudentID={{ $teacher->teacherStudentID }}&confirm=true" class="btn btn-default"><em class="fa fa-check"></em></a>
                                    @endif
                                    <a href="profile?id={{ $teacher->id }}" class="btn btn-default"><em class="fa fa-pencil"></em></a>
                                    <a href="profile?id={{ $teacher->id }}&remove=true" class="btn btn-danger"><em class="fa fa-trash"></em></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

        </div></div></div>

@include('footer')