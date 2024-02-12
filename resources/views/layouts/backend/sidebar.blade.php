<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            Noble<span>UI</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Users</span>
                </a>
            </li>
            <li class="nav-item nav-category">Smart Card</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#qrapp" role="button" aria-expanded="false"
                    aria-controls="qrapp">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Smart Card</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="qrapp">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.card.index') }}" class="nav-link">All Cards</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/email/read.html" class="nav-link">Read</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/email/compose.html" class="nav-link">Compose</a>
                        </li>
                    </ul>
                </div>
            </li>

        </ul>
    </div>
</nav>
