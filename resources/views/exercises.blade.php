@include('head')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">Exercises</h3>
                        </div>
                        <div class="col col-xs-6 text-right">
                            <a href="addExercise"><button type="button" class="btn btn-sm btn-primary btn-create">Create New</button></a>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th class="hidden-xs">ID</th>
                            <th>Type</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Tags</th>
                            <th><em class="fa fa-cog"></em></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($exercises as $exercise)
                            <tr>
                                <td class="hidden-xs">{{ $exercise->id }}</td>
                                <td>{{ $exercise->type }}</td>
                                <td>{{ $exercise->title }}</td>
                                <td>{{ $exercise->author }}</td>
                                <td>{{ $exercise->category }}</td>
                                <td>{{ $exercise->tags }}</td>
                                <td align="center">
                                    <a href="exercise?id={{ $exercise->id }}" class="btn btn-default"><em class="fa fa-pencil"></em></a>
                                    {{--<a class="btn btn-danger"><em class="fa fa-trash"></em></a>--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
                {{--<div class="panel-footer">
                    <div class="row">
                        <div class="col col-xs-4">Page 1 of 5
                        </div>
                        <div class="col col-xs-8">
                            <ul class="pagination hidden-xs pull-right">
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                            </ul>
                            <ul class="pagination visible-xs pull-right">
                                <li><a href="#">«</a></li>
                                <li><a href="#">»</a></li>
                            </ul>
                        </div>
                    </div>
                </div>--}}
            </div>

        </div></div></div>

@include('footer')