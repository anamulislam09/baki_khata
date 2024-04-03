<nav class=" navbar navbar-expand navbar-white navbar-light bg-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav" style="width: 40%">
        <li class="info">
            @if (Auth::guard('admin')->user()->role == 0)
            <a href="{{ route('admin.dashboard') }}" class="d-block text-light">{{ Auth::guard('admin')->user()->name }}</a>
            @endif
            <a href="{{ route('admin.dashboard') }}" class="d-block text-light">{{ Auth::guard('admin')->user()->shop_name }}</a>
        </li>
    </ul>
    <ul class="navbar-nav d-flex justify-content-center">
        @if (Auth::guard('admin')->user()->role == 0)
            <li class="nav-item mt-3">
                <a href="{{ route('customers.all') }}"
                    class="nav-link text-light {{ Request::routeIs('customers.all') || Request::routeIs('customers.create') || Request::routeIs('customers.edit') ? 'active' : '' }}">
                    <p>Customers</p>
                </a>
            </li>
        @endif
        @if (Auth::guard('admin')->user()->role == 1)
            <li
                class="nav-item mt-3 {{ Request::routeIs('users.index') || Request::routeIs('user.create') || Request::routeIs('user.store') || Request::routeIs('user.edit') || Request::routeIs('user.update') ? 'menu-open' : '' }}">
                <a href="{{ route('users.index') }}" class="nav-link text-light {{ Request::routeIs('users.index') || Request::routeIs('user.create') || Request::routeIs('user.store') || Request::routeIs('user.edit') || Request::routeIs('user.update') ? 'active' : '' }}">
                    <p>
                        Users
                    </p>
                </a>
            </li>
            <li class="nav-item mt-3">
                <a href="{{ route('collections.index') }}"
                    class="nav-link text-light {{ Request::routeIs('collections.index') ? 'active' : '' }}">
                    <p>Collections</p>
                </a>
            </li>
        @endif
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Admin Name -->
        <li class="nav-item pr-3">
            </a><form method="POST" id="logout" action="{{ route('admin.logout') }}">
                @csrf
                <a id="logout" href="" class="text-light"
                    onclick="event.preventDefault();
                                        this.closest('form').submit();">
                    Logout</a>
            </form>
        </li>
    </ul>
</nav>
