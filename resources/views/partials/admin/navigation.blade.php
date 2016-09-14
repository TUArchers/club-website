<div class="menu">
    <ul class="list">
        <li class="header">MAIN NAVIGATION</li>

        <!--Dashboard-->
        <li class="active">
            <a href="{{ url('/admin') }}">
                <i class="material-icons">home</i>
                <span>Dashboard</span>
            </a>
        </li>

        <!--Users-->
        <li>
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">person</i>
                <span>Users</span>
            </a>
            <ul class="ml-menu">
                <li>
                    <a href="{{ route('users.index') }}">Find User</a>
                </li>
                <li>
                    <a href="{{ route('users.create') }}">Add User</a>
                </li>
            </ul>
        </li>

        <!--Events-->
        <li>
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">event</i>
                <span>Events</span>
            </a>
            <ul class="ml-menu">
                <li>
                    <a href="{{ url('/admin/events') }}">View Calendar</a>
                </li>
                <li>
                    <a href="{{ url('/admin/events/add') }}">Plan Event</a>
                </li>
            </ul>
        </li>

        <!--News-->
        <li>
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">content_copy</i>
                <span>News</span>
            </a>
            <ul class="ml-menu">
                <li>
                    <a href="{{ url('/admin/articles') }}">Find Article</a>
                </li>
                <li>
                    <a href="{{ url('/admin/article/add') }}">Publish Article</a>
                </li>
            </ul>
        </li>

        <!--Pages-->
        <li>
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">web</i>
                <span>Pages</span>
            </a>
            <ul class="ml-menu">
                <li>
                    <a href="{{ url('/admin/pages') }}">Find Page</a>
                </li>
            </ul>
        </li>
    </ul>
</div>