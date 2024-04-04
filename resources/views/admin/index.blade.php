@extends('layouts.admin')

@section('admin_content')
    {{-- <div class="content-wrapper"> --}}
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
           <div class="card">
            <div class="card-header">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="m-0"> {{Auth::guard('admin')->user()->shop_name }}</h3>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard </li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>
           </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    @php
        $user = App\Models\User::where('customer_id', Auth::guard('admin')->user()->id)->count();
        $Customers = App\Models\Customer::where('role', 1)->count();
        $superAdmin = Auth::guard('admin')->user()->id;
        $total_sales = App\Models\Ledger::where('customer_id', Auth::guard('admin')->user()->id)->sum('amount');
        $total_collection = App\Models\Ledger::where('customer_id', Auth::guard('admin')->user()->id)->sum('collection');
        $total_due = App\Models\Ledger::where('customer_id', Auth::guard('admin')->user()->id)->sum('due');

    @endphp
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->

            @if ($superAdmin == 1001)
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <p>Total Client</p>
                                <h3>{{ $Customers }}</h3>

                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{route('client.all')}}" class="small-box-footer">More info <i
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
                                <p>Total Customer</p>
                                <h3>{{ $user }}</h3>

                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('customers.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <!-- /.col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner text-white">
                                <p>Total Sales</p>
                                <h3>{{ $total_sales }}<sup style="font-size: 20px">TK</sup></h3>

                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
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
                                <p>Total Collection</p>
                                <h3>{{ $total_collection }}<sup style="font-size: 20px">TK</sup></h3>

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
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <p>Others Due</p>
                                <h3>{{ $total_due }}<sup style="font-size: 20px">TK</sup></h3>

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
                    <!-- /.col -->
                </div>

                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <p>Total Customer</p>
                                <h3>{{ $user }}</h3>

                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('customers.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <!-- /.col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner text-white">
                                <p>Total Sales</p>
                                <h3>{{ $total_sales }}<sup style="font-size: 20px">TK</sup></h3>

                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
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
                                <p>Total Collection</p>
                                <h3>{{ $total_collection }}<sup style="font-size: 20px">TK</sup></h3>

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
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <p>Others Due</p>
                                <h3>{{ $total_due }}<sup style="font-size: 20px">TK</sup></h3>

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
                    <!-- /.col -->
                </div>
            @endif
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
    {{-- </div> --}}
@endsection
