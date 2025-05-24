<li class="nav-item has-treeview">
    <a href="{{'#'}}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>
            Email
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('email.create')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i> <p>Compose</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{route('email.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i> <p>Inbox</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{route('email.sentmails')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i> <p>Sent</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{route('email.draftmails')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i> <p>Draft</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{route('email.trashmails')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i> <p>Trash</p>
            </a>
        </li>

    </ul>
</li>
