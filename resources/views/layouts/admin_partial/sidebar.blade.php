<aside class="main-sidebar sidebar-dark-primary elevation-4 p-0">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('admin//dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        @if (Auth::guard('admin')->user()->role == 0)
            <span class="brand-text font-weight-light">Super Admin</span>
        @else
            <span class="brand-text font-weight-light">Admin dashboard</span>
        @endif
    </a>

    <!-- Sidebar -->
    <div class="sidebar mt-3">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('admin//dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('admin.dashboard') }}" class="d-block">{{ Auth::guard('admin')->user()->name }}</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <!-- Category start here -->
        <nav class=" mb-5">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @if (Auth::guard('admin')->user()->role == 0)
                    <li
                        class="nav-item {{ Request::routeIs('customers.all') || Request::routeIs('customers.create') || Request::routeIs('customers.edit') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Customers
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-3">
                            <li class="nav-item">
                                <a href="{{ route('customers.all') }}"
                                    class="nav-link {{ Request::routeIs('customers.all') || Request::routeIs('customers.create') || Request::routeIs('customers.edit') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Customers</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endif

                @if (Auth::guard('admin')->user()->role == 1)
                    {{-- Users Start here --}}
                    <li
                        class="nav-item {{ Request::routeIs('users.index') || Request::routeIs('user.create') || Request::routeIs('user.store') || Request::routeIs('user.edit') || Request::routeIs('user.update') ? 'menu-open' : '' }}">
                        <a href="{{route('users.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Users
                            </p>
                        </a>
                    </li>
                    {{-- Users ends here --}}
                    {{-- Users Start here --}}
                    <li
                        class="nav-item {{ Request::routeIs('collections.index') || Request::routeIs('collections.create') || Request::routeIs('collections.store') || Request::routeIs('collections.edit') || Request::routeIs('collections.update') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Collections
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-3">
                            <li class="nav-item">
                                <a href="{{ route('collections.create') }}"
                                    class="nav-link {{ Request::routeIs('collections.create') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Create Collection</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('collections.index') }}"
                                    class="nav-link {{ Request::routeIs('collections.index') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>All Collection</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- Users ends here --}}
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
