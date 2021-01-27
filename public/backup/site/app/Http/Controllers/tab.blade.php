<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link {{ ($tab == 0)?'active':'' }}" href="{{ url('profile/index.html') }}">
            <i class="fas fa-chart-area"></i>
            <span>{{ trans('validation.attributes.userProfile') }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ ($tab == 2)?'active':'' }}" href="{{ url('profile/changeInfo.html') }}">
            <i class="fa fa-pencil-alt"></i>
            <span>{{ trans('validation.attributes.changeInfo') }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ ($tab == 5)?'active':'' }}" href="{{ url('profile/changePassword.html') }}">
            <i class="fa fa-key"></i>
            <span>{{ trans('validation.attributes.changePassword') }}</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ ($tab == 6)?'active':'' }}" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
            <i class="fa fa-sign-out-alt"></i>
            <span>{{ trans('validation.attributes.logout') }}</span>
             
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </li>
</ul>