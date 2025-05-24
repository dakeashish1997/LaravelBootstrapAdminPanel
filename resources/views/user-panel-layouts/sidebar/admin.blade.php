<li class="nav-item has-treeview">
    <a href="{{'#'}}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>
            Admin
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('admin.users.index')}}" class="nav-link">
                <i class="nav-icon far fa-circle"></i>
                <p>Users</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.questions.index')}}" class="nav-link">
                <i class="nav-icon far fa-circle"></i>
                <p>Questions</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.workshop.index')}}" class="nav-link">
                <i class="nav-icon far fa-circle"></i>
                <p>Workshop</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.onlinetest.index')}}" class="nav-link">
                <i class="nav-icon far fa-circle"></i>
                <p>Online Tests</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.digitalocean')}}" class="nav-link">
                <i class="nav-icon far fa-circle"></i>
                <p>DigitalOcean</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{'http://64.227.172.159/phpmyadmin/'}}" target="_blank" class="nav-link">
                <i class="nav-icon far fa-circle"></i>
                <p>Database</p>
            </a>
        </li>

    </ul>
</li>
