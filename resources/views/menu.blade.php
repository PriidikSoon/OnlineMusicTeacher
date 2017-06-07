<div class="navigationWrapper">
    <nav class="navigation">
        <ul>
            <li class="active">
                <a href="home"><em class="fa fa-home"></em>  Home</a>
            </li>
            <li>
                <a href="exercises"><em class="fa fa-book"></em>  Exercises</a>
            </li>
            <li>
                <a href="tasks"><em class="fa fa-tasks"></em>  Tasks</a>
            </li>
            <li>
                @if (Auth::user()->type == 'TEACHER')
                <a href="students"><em class="fa fa-users"></em>  Students</a>
                @else
                <a href="teachers"><em class="fa fa-users"></em>  Teachers</a>
                @endif
            </li>
            <li>
                <a href="profile"><em class="fa fa-user"></em>  {{ Auth::user()->first_name }}</a>
            </li>
            <li>
                <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><em class="fa fa-sign-out"></em></a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </nav>
</div>