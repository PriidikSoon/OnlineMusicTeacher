@include('auth/authHeader')

<div class="row">
    <div class="col-xs-6">
        <a href="{{ url('/login') }}" id="login-form-link">Login</a>
    </div>
    <div class="col-xs-6">
        <a href="{{ url('/register') }}" class="active" id="register-form-link">Register</a>
    </div>
</div>
<hr>
</div>
<div class="panel-body">
    <div class="row">
        <div class="col-lg-12">

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="text" name="firstName" id="firstName" tabindex="1" class="form-control" placeholder="First Name" value="">
                </div>
                <div class="form-group">
                    <input type="text" name="lastName" id="lastName" tabindex="1" class="form-control" placeholder="Last Name" value="">
                </div>
                <div class="form-group">
                    Type:
                    <select name="type" title="Type">
                        <option value="TEACHER">Teacher</option>
                        <option value="STUDENT">Student</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" name="instrument" id="instrument" tabindex="1" class="form-control" placeholder="Instrument" value="">
                </div>
                <div class="form-group">
                    <input type="text" name="description" id="description" tabindex="1" class="form-control" placeholder="Description" value="">
                </div>
                <div class="form-group">
                    <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="">
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirmation" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                            <input type="submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
                        </div>
                    </div>
                </div>
            </form>
@include('auth/authFooter')