<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            <img class="w-50" src="{{ asset('assets/images/logo.png') }}" alt="">
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
                <a class="nav-link" data-bs-toggle="collapse" href="#qrapp1" role="button" aria-expanded="false"
                    aria-controls="qrapp1">
                    <i class="link-icon" data-feather="credit-card"></i>
                    <span class="link-title">Smart Card</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="qrapp1">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.card.index') }}" class="nav-link">All Cards</a>
                        </li>

                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#qrapp2" role="button" aria-expanded="false"
                    aria-controls="qrapp2">
                    <i class="link-icon" data-feather="credit-card"></i>
                    <span class="link-title">Website Card</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="qrapp2">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.website.index') }}" class="nav-link">All website cards</a>
                        </li>

                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#qrapp3" role="button" aria-expanded="false"
                    aria-controls="qrapp3">
                    <i class="link-icon" data-feather="credit-card"></i>
                    <span class="link-title">Instagram Card</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="qrapp3">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.instagram.index') }}" class="nav-link">All Instagram Cards</a>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.instacategory.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Insta Category</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.instatemplate.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Insta Template</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.package.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Packages</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.subscription.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Subscription</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.payment.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Payment</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.block') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Block User</span>
                </a>
            </li>

        </ul>
    </div>
</nav>
