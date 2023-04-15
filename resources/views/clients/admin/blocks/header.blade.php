<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('admin.index') }}" class="nav-link">Trang chủ</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <span>
                    <i class="fas fa-gear"></i>
                    Cài đặt
                </span>
                <i class="fas fa-sort-down"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('logout') }}" class="dropdown-item d-flex justify-content-around align-items-center">
                    <span> Đăng xuất</span>
                    <i class="fas fa-power-off"></i>
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('admin.change_password') }}" class="dropdown-item d-flex justify-content-around align-items-center">
                    <span>Đổi mật khẩu</span>
                    <i class="fas fa-key"></i>
                </a>
            </div>
        </li>
    </ul>
</nav>