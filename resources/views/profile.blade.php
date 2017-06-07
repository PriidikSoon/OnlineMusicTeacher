@include('head')
<form class="form-horizontal" role="form" method="POST" action="">
    {{ csrf_field() }}
    <input type="hidden" name="isTeacherStudent" value="{{ $isTeacherStudent }}">
    <input type="hidden" name="teacherStudentID" value="{{ $teacherStudent->id or 0}}">
    <div>
        <label for="firstName">First name</label>
        <input @if($isTeacherStudent) readonly="readonly" @endif class="form-control" type="text" name="firstName" id="firstName" tabindex="1" value="{{ $user->first_name }}">
    </div>
    <div>
        <label for="lastName">Last name</label>
        <input @if($isTeacherStudent) readonly="readonly" @endif class="form-control" type="text" name="lastName" id="lastName" tabindex="1" value="{{ $user->last_name }}">
    </div>
    <div>
        <label for="type">Type</label>
        <select @if($isTeacherStudent) disabled="disabled" @endif class="form-control" name="type" title="Type">
            <option value="TEACHER">Teacher</option>
            <option value="STUDENT">Student</option>
        </select>
        <script>
            $('[name=type]').val("{{ $user->type }}");
        </script>
    </div>
    <div>
        <label for="instrument">Instrument</label>
        <input @if($isTeacherStudent) readonly="readonly" @endif class="form-control" type="text" name="instrument" id="instrument" tabindex="1" value="{{ $user->instrument }}">
    </div>
    <div>
        <label for="description">Description</label>
        <input @if($isTeacherStudent) readonly="readonly" @endif class="form-control" type="text" name="description" id="description" tabindex="1" value="{{ $user->description }}">
    </div>
    <div>
        <label for="email">Email</label>
        <input @if($isTeacherStudent) readonly="readonly" @endif class="form-control" type="email" disabled="disabled" name="email" id="email" tabindex="1" value="{{ $user->email }}">
    </div>
    @if($isTeacherStudent)
        <div>
            <label for="notes">Notes</label>
            <input class="form-control" type="text" name="notes" id="notes" tabindex="1" value="{{ $teacherStudent->notes }}">
        </div>
    @endif
    <div class="form-group">
        <input type="submit" tabindex="1" class="form-control btn btn-register" value="Save">
    </div>
</form>
@include('footer');