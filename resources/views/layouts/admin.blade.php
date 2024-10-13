<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <nav class="sidebar bg-dark text-white" id="sidebar">
            <ul class="nav flex-column">
                <li class="nav-item profile">
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link active" href="{{ url('/admin/dashboard') }}">
                        <span class="menu-icon"><i class="mdi mdi-speedometer"></i></span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="{{ url('/admin/products') }}">
                        <span class="menu-icon"><i class="mdi mdi-format-list-bulleted"></i></span>
                        <span class="menu-title
                        ">Product Management</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <div class="collapse" id="product-management">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"><a class="nav-link" href="{{ url('/admin/products/add') }}">Add Product</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/admin/products/list') }}">Product List</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="{{ url('/admin/accounts') }}">
                        <span class="menu-icon"><i class="mdi mdi-account"></i></span>
                        <span class="menu-title">Account Management</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="{{ url('/admin/orders') }}">
                        <span class="menu-icon"><i class="mdi mdi-cart"></i></span>
                        <span class="menu-title">Order Management</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span class="menu-icon"><i class="mdi mdi-logout"></i></span>
                        <span class="menu-title">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="page-content-wrapper" class="w-100 p-3">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
