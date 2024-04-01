@extends('layouts.admin')

@section('admin_content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard </li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        {{-- @php
            $user = App\Models\User::where('customer_id', Auth::guard('admin')->user()->id)->count();
            $flat = App\Models\Flat::where('customer_id', Auth::guard('admin')->user()->id)->count();
            $total_exp = App\Models\Exp_detail::where('customer_id', Auth::guard('admin')->user()->id)->sum('amount');
            $total_income = App\Models\Income::where('customer_id', Auth::guard('admin')->user()->id)->sum('paid');
            $manualOpeningBlance = DB::table('opening_balances')
                ->where('customer_id', Auth::guard('admin')->user()->id)
                ->first();
            $others_income = DB::table('others_incomes')
                ->where('customer_id', Auth::guard('admin')->user()->id)
                ->sum('amount');

            $balance = App\Models\MonthlyBlance::where('customer_id', Auth::guard('admin')->user()->id)->sum('amount');
            $Customers = App\Models\Customer::where('role', 1)->count();
            $category = App\Models\Category::count();
            $superAdmin = Auth::guard('admin')->user()->id;

        @endphp --}}
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Info boxes -->

                {{-- @if ($superAdmin == 1001)
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <p>Total Customers</p>
                                    <h3>{{ $Customers }}</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('customers.all') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <p>Total Category</p>
                                    <h3>{{ $category }}</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('category.index') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                @else
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <p>Total User</p>
                                    <h3>{{ $user }}</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('users.index') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box " style="background: #df8e15">
                                <div class="inner text-white">
                                    <p>No of Flat</p>
                                    <h3>{{ $flat }}</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('flat.index') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner text-white">
                                    <p>Total Expenses</p>
                                    <h3>{{ $total_exp }}<sup style="font-size: 20px">TK</sup></h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('expenses.year') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->

                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <p>Total Service Charge</p>
                                    <h3>{{ $total_income }}<sup style="font-size: 20px">TK</sup></h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="{{ route('income.statement') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <p>Others Income</p>
                                    <h3>{{ $others_income }}<sup style="font-size: 20px">TK</sup></h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    @if (isset($manualOpeningBlance))
                                        @if ($manualOpeningBlance->flag == 1)
                                            <p>Opening Balance (Profit)</p>
                                            <h3>{{ $manualOpeningBlance->profit }}<sup style="font-size: 20px">TK</sup>
                                            </h3>
                                        @else
                                            <p>Opening Balance (Loss)</p>
                                            <h3>{{ $manualOpeningBlance->loss }}<sup style="font-size: 20px">TK</sup></h3>
                                        @endif
                                    @else
                                            <p>Opening Balance </p>
                                            <h3>0<sup style="font-size: 20px">TK</sup>
                                            </h3>
                                        
                                    @endif
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->

                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <p>Balance</p>
                                    <h3>{{ $balance }} <sup style="font-size: 20px">TK</sup></h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{ route('blance.index') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                @endif --}}
            </div><!--/. container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
