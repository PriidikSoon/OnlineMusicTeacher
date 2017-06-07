@include('head')
<form class="form-horizontal" role="form" method="POST" action="" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div>
        <label for="student">Student</label>
        <input disabled="disabled" class="form-control" type="text" name="student" id="student" tabindex="1" value="{{ $task->student->first_name}} {{ $task->student->last_name}}">
    </div>
    <div>
        <label for="exercise">Exercise</label>
        <input disabled="disabled" class="form-control" type="text" name="exercise" id="exercise" tabindex="1" value="{{ $task->exercise->title }}">
    </div>
    <div>
        <label for="due_date">Due date</label>
        <input class="form-control" type="text" name="due_date" id="due_date" tabindex="1" value="{{ $task->due_date }}">
    </div>
    <div>
        <label for="description">Description</label>
        <textarea class="form-control" name="description" id="description" tabindex="1">{{ $task->description }}</textarea>
    </div>
    <div id="musicSheet" style=""></div>
    <div class="form-group">
        <a href="sightReading?taskID={{ $task->id }}"><button type="button" class="form-control btn btn-register">Play</button></a>
    </div>
    <div class="form-group">
        <input type="submit" tabindex="1" class="form-control btn btn-register" value="Save">
    </div>
</form>
@include('footer');

<script>
    $(function(){
        VEXUTIL.importFromXML({{ $task->exercise->user_id }},'{{ $task->exercise->file_link }}');
    });
</script>