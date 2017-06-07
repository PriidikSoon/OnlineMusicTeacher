@include('auth/authHeader')

<div class="row">
    <div class="col-xs-6">
        <a href="{{ url('/login') }}" class="active" id="login-form-link">Login</a>
    </div>
    <div class="col-xs-6">
        <a href="{{ url('/register') }}" id="register-form-link">Register</a>
    </div>
</div>
<hr>
</div>
<div class="panel-body">
    <div class="row">
        <div class="col-lg-12">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="text" name="email" id="email" tabindex="1" class="form-control"
                           placeholder="Email" value="">
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" tabindex="2" class="form-control"
                           placeholder="Password">
                </div>
                <div class="form-group text-center">
                    <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
                    <label for="remember"> Remember Me</label>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                            <input type="submit" tabindex="4" class="form-control btn btn-login" value="Log In">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <a href="{{ url('/password/reset') }}" tabindex="5" class="forgot-password">Forgot
                                    Password?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>


            {{--<form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">Password</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Login
                        </button>

                        <a class="btn btn-link" href="{{ url('/password/reset') }}">
                            Forgot Your Password?
                        </a>
                    </div>
                </div>
            </form>--}}
@include('auth/authFooter')