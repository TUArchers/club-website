<div class="menu">
    <ul class="list">
        <li class="header">COMMITTEE TOOLS</li>
        {{--TODO: Add active class to the active menu item--}}

        <!--Dashboard-->
        <li class="active">
            <a href="{{ route('admin.index') }}">
                <i class="material-icons">home</i>
                <span>Dashboard</span>
            </a>
        </li>

        <!--People-->
        <li>
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">person</i>
                <span>People</span>
            </a>
            <ul class="ml-menu">
                <li>
                    <a href="{{ route('admin.users.index') }}">Manage People</a>
                </li>
                <li>
                    <a href="{{ route('admin.users.create') }}">Register a Person</a>
                </li>
                <li>
                    <a href="{{ route('admin.roles.index') }}">Manage Roles &amp; Permissions</a>
                </li>
                <li>
                    <a href="{{ route('admin.roles.create') }}">Define a Role</a>
                </li>
            </ul>
        </li>

        <!--Scores-->
        <li>
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">timeline</i>
                <span>Scores</span>
            </a>
            <ul class="ml-menu">
                <li>
                    <a href="{{ route('admin.scores.index') }}">Scoring Summary</a>
                </li>
                <li>
                    <a href="{{ route('admin.scores.create') }}">Record Score</a>
                </li>
                <li>
                    <a href="{{ route('admin.rounds.index') }}">Round Definitions</a>
                </li>
                <li>
                    <a href="{{ route('admin.rounds.create') }}">Define New Round</a>
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
                    <a href="{{ route('admin.events.index') }}">View Schedule</a>
                </li>
                <li>
                    <a href="{{ route('admin.events.create') }}">Plan Event</a>
                </li>
            </ul>
        </li>

        {{--<!--News-->--}}
        {{--<li>--}}
            {{--<a href="javascript:void(0);" class="menu-toggle">--}}
                {{--<i class="material-icons">content_copy</i>--}}
                {{--<span>News</span>--}}
            {{--</a>--}}
            {{--<ul class="ml-menu">--}}
                {{--<li>--}}
                    {{--<a href="{{ url('/admin/articles') }}">Find Article</a>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a href="{{ url('/admin/article/add') }}">Publish Article</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</li>--}}

        {{--<!--Pages-->--}}
        {{--<li>--}}
            {{--<a href="javascript:void(0);" class="menu-toggle">--}}
                {{--<i class="material-icons">web</i>--}}
                {{--<span>Pages</span>--}}
            {{--</a>--}}
            {{--<ul class="ml-menu">--}}
                {{--<li>--}}
                    {{--<a href="{{ url('/admin/pages') }}">Find Page</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</li>--}}
    </ul>
</div>