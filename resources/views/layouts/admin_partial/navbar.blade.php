<style>
    @media only screen and (max-width: 600px) {
        .nav-item a {
            font-size: 10px;
        }

        .nav-link {
            margin-right: 0px;
            padding-left: 0px !important;
            padding-right: 0px !important;
        }
    }

    @media only screen and (min-width: 600px) {
        .nav-item a {
            font-size: 15px;
        }

        .nav-link {
            margin-right: 0px;
            padding-left: 0px !important;
            padding-right: 0px !important;
        }
    }

    @media only screen and (min-width: 768px) {
        .nav-item a {
            font-size: 16px;
        }

        .nav-link{
            margin-right: 0px;
            padding-left: 0px !important;
            padding-right: 0px !important;
        }
    }

    @media only screen and (min-width: 992px) {
        .nav-item a {
            font-size: 19px;
        }
    }

    @media only screen and (min-width: 1200px) {
        .nav-item a {
            font-size: 21px;
        }
    }

    /* li.nav-item a:hover {
        background: #000;
        padding: 5px 10px;
    } */

    li.nav-item{
        background: #616970;
        margin-right: 4px;
        padding: 5px 8px;
    }
  
    nav.navbar.navbar-expand.navbar-light.bg-dark {
        padding: 0px;
    }
    .navbar-light {
            background-color: #f8f9fa;
            margin: 0px;
            padding: 0px;
        }
</style>

<nav class=" navbar navbar-expand navbar-light" style="background: #6C757D">
    {{-- <!-- Left navbar links --> --}}
    <ul class="navbar-nav" style="width: 40%">
        <li class="nav-item">
            @if (Auth::guard('admin')->user()->role == 0)
                <a href="{{ route('admin.dashboard') }}"
                    class="d-block nav-link text-light">{{ Auth::guard('admin')->user()->name }}</a>
            @else
                <a href="{{ route('admin.dashboard') }}"
                    class="d-block nav-link text-light">{{ Auth::guard('admin')->user()->shop_name }}</a>
            @endif
        </li>
    </ul>
    <ul class="navbar-nav d-flex justify-content-center">
        @if (Auth::guard('admin')->user()->role == 0)
            <li class="nav-item">
                <a href="{{ route('client.all') }}"
                    class="nav-link text-light {{ Request::routeIs('client.all') || Request::routeIs('client.create') || Request::routeIs('client.edit') ? 'active' : '' }}">
                    <p style=" margin-bottom:-0px">Client</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('collections.all') }}"
                    class="nav-link text-light {{ Request::routeIs('collections.all') || Request::routeIs('collection.create') || Request::routeIs('collection.edit') ? 'active' : '' }}">
                    <p style=" margin-bottom:-0px">Collection</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('packages.all') }}"
                    class="nav-link text-light {{ Request::routeIs('packages.all') || Request::routeIs('package.create') || Request::routeIs('package.edit') ? 'active' : '' }}">
                    <p style=" margin-bottom:-0px">Packages</p>
                </a>
            </li>
        @endif
        @if (Auth::guard('admin')->user()->role == 1)
            <li
                class="nav-item {{ Request::routeIs('customers.index') || Request::routeIs('customers.create') || Request::routeIs('customers.store') || Request::routeIs('customers.edit') || Request::routeIs('customers.update') ? 'menu-open' : '' }}">
                <a href="{{ route('customers.index') }}"
                    class="nav-link text-light {{ Request::routeIs('customers.index') || Request::routeIs('customers.create') || Request::routeIs('customers.store') || Request::routeIs('customers.edit') || Request::routeIs('customers.update') ? 'active' : '' }}">
                    <p style=" margin-bottom:-0px">
                        Customer
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('collections.index') }}"
                    class="nav-link text-light {{ Request::routeIs('collections.index') ? 'active' : '' }}">
                    <p style=" margin-bottom:-0px">Collections</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('report.index') }}"
                    class="nav-link text-light {{ Request::routeIs('report.index') ? 'active' : '' }}">
                    <p style=" margin-bottom:-0px">Report</p>
                </a>
            </li>
        @endif
    </ul>

    <ul class="navbar-nav ml-auto">
        <!-- Admin Name -->
        <li class="nav-item pr-3">
            <form method="POST" id="logout" action="{{ route('admin.logout') }}">
                @csrf
                <a id="logout" href="" style="" class="nav-link text-light"
                    onclick="event.preventDefault();
                                        this.closest('form').submit();">
                    Logout</a>
            </form>
        </li>
    </ul>
</nav>
