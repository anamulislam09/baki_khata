@extends('layouts.admin')
@section('admin_content')
    <style>
        @media only screen and (max-width: 600px) {

            .shop_name h3 {
                font-size: 18px !important;
            }

            .menu_bar {
                font-size: 13px !important;
            }

            .inner h3,
            sup {
                font-size: 14px !important;
            }

            .small-box-footer {
                font-size: 12px !important;
            }

            .title {
                font-size: 17px !important;
            }

        }

        @media only screen and (min-width: 600px) {

            .shop_name h3 {
                font-size: 18px !important;
            }

            .menu_bar {
                font-size: 13px !important;
            }

            .inner h3,
            sup {
                font-size: 15px !important;
            }

            .small-box-footer {
                font-size: 12px !important;
            }

            .title {
                font-size: 17px !important;
            }
        }

        @media only screen and (min-width: 768px) {

            .shop_name h3 {
                font-size: 20px !important;
            }

            .menu_bar {
                font-size: 15px !important;
            }

            .inner h3,
            sup {
                font-size: 17px !important;
            }

            .small-box-footer {
                font-size: 14px !important;
            }

            .title {
                font-size: 19px !important;
            }
        }

        @media only screen and (min-width: 992px) {

            .shop_name h3 {
                font-size: 20px !important;
            }

            .menu_bar {
                font-size: 15px !important;
            }

            .inner h3,
            sup {
                font-size: 19px !important;
            }

            .small-box-footer {
                font-size: 14px !important;
            }

            .title {
                font-size: 20px !important;
            }
        }

        @media only screen and (min-width: 1200px) {

            .shop_name h3 {
                font-size: 22px !important;
            }

            .menu_bar {
                font-size: 16px !important;
            }

            .inner h3,
            sup {
                font-size: 20px !important;
            }

            .small-box-footer {
                font-size: 15px !important;
            }

            .title {
                font-size: 21px !important;
            }
        }
    </style>
    <!-- Content Header (Page header) -->
    <div class="content-header ">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    {{-- <div class="menubar"> --}}
                        {{-- <div class="col-lg-2 col-md-2 col-sm-0">
                        </div> --}}
                        <div class="shop_name text-center">
                            <h3 class="m-0 " > {{ Auth::guard('admin')->user()->shop_name }}</h3>
                        </div><!-- /.col -->
                        {{-- <div class="menu_bar">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard </li>
                            </ol>
                        </div><!-- /.col --> --}}
                    {{-- </div><!-- /.row --> --}}
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    @php
        $user = App\Models\User::where('customer_id', Auth::guard('admin')->user()->id)->count();
        $users = App\Models\User::where('customer_id', Auth::guard('admin')->user()->id)->get();
        $Customers = App\Models\Customer::where('role', 1)->count();
        $packages = App\Models\Package::count();
        $superAdmin = Auth::guard('admin')->user()->id;
        $total_sales = App\Models\Ledger::where('customer_id', Auth::guard('admin')->user()->id)->sum('amount');
        $total_collection = App\Models\Ledger::where('customer_id', Auth::guard('admin')->user()->id)->sum(
            'collection',
        );
        $total_due = App\Models\Ledger::where('customer_id', Auth::guard('admin')->user()->id)->sum('due');

        // today transaction
        $today_sales = App\Models\Ledger::where('customer_id', Auth::guard('admin')->user()->id)
            ->where('date', date('Y-m-d'))
            ->sum('amount');
        $today_collection = App\Models\Ledger::where('customer_id', Auth::guard('admin')->user()->id)
            ->where('date', date('Y-m-d'))
            ->sum('collection');
        $today_due = App\Models\Ledger::where('customer_id', Auth::guard('admin')->user()->id)
            ->where('date', date('Y-m-d'))
            ->sum('due');

        $due_amount = App\Models\Customer::sum('customer_balance');
        $total_client_collection = App\Models\Payment::sum('paid');

    @endphp
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if ($superAdmin == 1001)
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <p>Total Clients</p>
                                <h3>{{ $Customers }}</h3>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('client.all') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <p>Total Packages</p>
                                <h3>{{ $packages }}</h3>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('packages.all') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <p>Total Collections</p>
                                <h3>{{ $total_client_collection }} TK</h3>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('collections.all') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <p>Total Due</p>
                                <h3>{{ $due_amount }} TK</h3>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            @else
                <div class="card " style="margin-top: -20px !important">
                    <div class="card-header row ">
                        <h4><input value="{{ date('Y-m-d') }}" type="date" name="date" class="form-control"
                                id="date"></h4>
                    </div>
                </div>


                <div class="row" id="today">
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
                                <p>Today Total Sales</p>
                                <h3>{{ $today_sales }} TK</h3>

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
                                <p>Today Total Collection</p>
                                <h3>{{ $today_collection }} TK</h3>

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
                                <p>Today Total Due</p>
                                <h3>{{ $today_due }} TK</h3>

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

                <div class="row" id="datewise">
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
                    {{-- dateAmount
                    dateCollection
                    dateDue --}}
                    <!-- /.col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner text-white">
                                <p>Today Total Sales</p>
                                <h3 id="dateAmount"> TK</h3>

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
                                <p>Today Total Collection</p>
                                <h3 id="dateCollection"> TK</h3>

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
                                <p>Today Total Due</p>
                                <h3 id="dateDue"> TK</h3>

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

                <div class="card">
                    <div class="card-header">
                        <h4 class="title">Total Transactions</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <p>Total Customer</p>
                                <div class="row">
                                    <div class="col-2">
                                        <h3>{{ $user }}</h3>
                                    </div>
                                    <div class="col-9">
                                        <div class="form-group">
                                            <select class="form-control form-control-sm select2 " name="customer_id"
                                                id="customer_id" style="width: 100%;">
                                                <option value="" selected disabled>018XXXXX</option>
                                                @foreach ($users as $row)
                                                    <option class="pb-3 user" value="{{ $row->user_id }}">
                                                        {{ $row->name }} {{ $row->phone }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

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
                                <h3>{{ $total_sales }} TK</h3>

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
                                <h3>{{ $total_collection }} TK</h3>

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
                                <p>Total Due</p>
                                <h3>{{ $total_due }} TK</h3>

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
                <div class="card" id="table">
                    <strong class="d-flex justify-content-center mb-2"><span id="user"></span>&nbsp; Ledger
                        Account</strong>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-bordered report_table">
                                <thead>
                                    <tr style="border-top: 1px solid #ddd">
                                        <th width="10%">SL</th>
                                        <th width="15%">Date</th>
                                        <th width="20%">Sales Amount</th>
                                        <th width="20%">Receive Amount </th>
                                        <th width="15%">Balance</th>
                                        <th width="15%"> Action</th>
                                    </tr>
                                </thead>
                                <tbody id="item-table"></tbody>
                                <tfoot class="form">
                                    <tr>
                                        <td colspan="2"><strong>Total =</strong></td>
                                        <td id="amount"></td>
                                        <td id="total_collection"></td>
                                        <td id="total_due"></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var searchRequest = null;
        $(function() {
            $("#table").hide();
            var minlength = 4;
            $("#customer_id").change(function() {
                $("#table").show();

                customerLeader($(this).val());
            });
        });

        function customerLeader(custID) {
            $.ajax({
                type: "GET",
                url: "{{ url('admin/get-customers') }}/" + custID,
                dataType: "json",
                success: function(res) {
                    $('#user').text(res.users.name + '`s');
                $('#amount').text(res.total_amount);
                $('#total_collection').text(res.total_collection);
                $('#total_due').text(parseFloat(res.total_due).toFixed(2));

                var tbody = '';
                res.ledger.forEach((element, index) => {
                    url = '{{ url('admin/generate-invoice') }}/' + element.invoice_id;
                    tbody += '<tr>'
                    tbody += '<td>' + (index + 1) + '</td>'
                    tbody += '<td>' + element.date + '</td>'
                    tbody += '<td>' + element.amount + '</td>'
                    tbody += '<td>' + element.collection + '</td>'
                    tbody += '<td>' + element.due + '</td>'
                    tbody += '<td class="text-center"><a href="' + url +
                        '" target ="_blank"><span class="fa fa-book"></span></a></td>'
                    tbody += '</tr>'
                });
                $('#item-table').html(tbody);
            }
        });
    }

    $(document).ready(function() {
        $("#datewise").hide();
        $("#date").on('change', function() {
            $("#datewise").show();
            $("#today").hide();
            var date = $(this).val();
            // alert(date);
            $.ajax({
                type: "GET",
                url: "{{ url('admin/get-transaction') }}/" + date,
                dataType: "json",
                success: function(res) {
                    // $('#user').text(res.users.name + '`s');
                        $('#dateAmount').text(res.dateAmount);
                        $('#dateCollection').text(res.dateCollection);
                        $('#dateDue').text(parseFloat(res.dateDue).toFixed(2));
                        // console.log(res.dateAmount);
                    }
                });
            });
        });
    </script>
@endsection
