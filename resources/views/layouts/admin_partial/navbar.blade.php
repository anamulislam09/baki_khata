<style>
    @media only screen and (max-width: 600px) {
        .nav-item a {
            font-size: 12px;
        }

        .nav-link {
            margin-right: 0px;
            padding-left: 2px !important;
            padding-right: 2px !important;
        }
    }

    @media only screen and (min-width: 600px) {
        .nav-item a {
            font-size: 16px;
        }

        .nav-link {
            margin-right: 0px;
            padding-left: 3px !important;
            padding-right: 3px !important;
        }
    }

    @media only screen and (min-width: 768px) {
        .nav-item a {
            font-size: 18px;
        }

        .nav-link{
            margin-right: 0px;
            padding-left: 3px !important;
            padding-right: 3px !important;
        }
    }

    @media only screen and (min-width: 992px) {
        .nav-item a {
            font-size: 20px;
        }
    }

    @media only screen and (min-width: 1200px) {
        .nav-item a {
            font-size: 22px;
        }
    }

    /* li.nav-item a:hover {
        background: #000;
        padding: 5px 10px;
    } */

    li.nav-item{
        background: #292d31;
        margin-right: 5px;
        padding: 5px 10px;
    }

    /* li.nav-item :hover{
        background: #000;
        margin-right: 5px;
        padding: 5px 10px;
    } */
  
    nav.navbar.navbar-expand.navbar-light.bg-dark {
        padding: 0px;
    }
    .navbar-light {
            background-color: #f8f9fa;
            margin: 0px;
            padding: 0px;
        }
</style>

<nav class=" navbar navbar-expand navbar-light" style="background: #464141">
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
