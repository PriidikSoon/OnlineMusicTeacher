@include('head')
<div id="error">
    {{ $error or '' }}
</div>
<form class="form-horizontal" role="form" method="POST" action="" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div>
        <label for="studentMail">Student email</label>
        <input class="form-control" type="text" name="studentMail" id="studentMail" tabindex="1" value="">
    </div>
    <div>
        <label for="notes">Notes</label>
        <input class="form-control" type="text" name="notes" id="notes" tabindex="1" value="">
    </div>
    <div class="form-group">
        <input type="submit" tabindex="1" class="form-control btn btn-register" value="Save">
    </div>
</form>
@include('footer');