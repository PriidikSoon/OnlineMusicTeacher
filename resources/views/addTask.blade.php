@include('head')
<form class="form-horizontal" role="form" method="POST" action="" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div>
        <label for="student">Student</label>
        <select name="student" title="student" class="form-control">
            @foreach($students as $student)
                <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="exercise">Exercise</label>
        <select name="exercise" title="exercise" class="form-control">
            @foreach($exercises as $exercise)
                <option value="{{ $exercise->id }}">{{ $exercise->title }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="due_date">Due date</label>
        <input class="form-control" type="text" name="due_date" id="due_date" tabindex="1" value="">
    </div>
    <div>
        <label for="description">Description</label>
        <textarea class="form-control" name="description" id="description" tabindex="1"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" tabindex="1" class="form-control btn btn-register" value="Save">
    </div>
</form>
@include('footer');