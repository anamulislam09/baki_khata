<style>
@media only screen and (max-width: 600px) {
.nav-item p a{
    font-size: 14px;
}
}

@media only screen and (min-width: 600px) {

}

@media only screen and (min-width: 768px) {

}

@media only screen and (min-width: 992px) {

}

@media only screen and (min-width: 1200px) {

}
</style>

<nav class=" navbar navbar-expand navbar-light bg-dark ">
    {{-- <!-- Left navbar links --> --}}
    <ul class="navbar-nav" style="width: 40%">
         {{-- <li class="info" style="font-size: 25px;">
            @if (Auth::guard('admin')->user()->role == 0)
            <a href="{{ route('admin.dashboard') }}" class="d-block text-light">{{ Auth::guard('admin')->user()->name }}</a>
            @else
            <a href="{{ route('admin.dashboard') }}" class="d-block text-light">{{ Auth::guard('admin')->user()->shop_name }}</a>
            @endif
        </li> --}} 
    </ul>
    <ul class="navbar-nav d-flex justify-content-center">
        @if (Auth::guard('admin')->user()->role == 0)
            <li class="nav-item">
                <a href="{{ route('client.all') }}"
                    class="nav-link text-light {{ Request::routeIs('client.all') || Request::routeIs('client.create') || Request::routeIs('client.edit') ? 'active' : '' }}">
                    <p style="font-size: 25px; margin-bottom:-0px">Client</p>
                </a>
            </li>
        @endif
        @if (Auth::guard('admin')->user()->role == 1)
            <li
                class="nav-item {{ Request::routeIs('customers.index') || Request::routeIs('customers.create') || Request::routeIs('customers.store') || Request::routeIs('customers.edit') || Request::routeIs('customers.update') ? 'menu-open' : '' }}">
                <a href="{{ route('customers.index') }}" class="nav-link text-light {{ Request::routeIs('customers.index') || Request::routeIs('customers.create') || Request::routeIs('customers.store') || Request::routeIs('customers.edit') || Request::routeIs('customers.update') ? 'active' : '' }}">
                    <p style="font-size: 25px; margin-bottom:-0px">
                    Customer
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('collections.index') }}"
                    class="nav-link text-light {{ Request::routeIs('collections.index') ? 'active' : '' }}">
                    <p style="font-size: 25px; margin-bottom:-0px">Collections</p>
                </a>
            </li>
        @endif
    </ul>

    <ul class="navbar-nav ml-auto">
        <!-- Admin Name -->
        <li class="nav-item pr-3">
            </a><form method="POST" id="logout" action="{{ route('admin.logout') }}">
                @csrf
                <a id="logout" href="" style="font-size: 22px;" class="text-light"
                    onclick="event.preventDefault();
                                        this.closest('form').submit();">
                    Logout</a>
            </form>
        </li>
    </ul>
</nav>
