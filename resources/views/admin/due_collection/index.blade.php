@extends('layouts.admin')

@section('admin_content')
    <style>
        #dataTable {
            font-size: 15px;
        }

        @media only screen and (max-width: 600px) {
            .menubar ol li {
                font-size: 17px !important;
            }

            table tr td {
                font-size: 13px !important;
            }

            table tr th {
                font-size: 13px !important;
            }

            .editmodel {
                font-size: 15px !important;
            }

            .modl-body {
                margin: -35px 0px !important;
            }

            .sales h5 {
                font-size: 17px !important;
                /* padding: 4px !important; */
            }

            .formlabel label {
                font-size: 13px !important;
            }

            .formlabel input {
                font-size: 13px !important;
            }

            .formlabel button {
                font-size: 13px !important;
                margin-top: -35px !important;
            }

            .formlabel a {
                font-size: 13px !important;
                margin-top: 0px !important;
            }
        }

        @media only screen and (min-width: 600px) {
            .menubar ol li {
                font-size: 18px !important;
            }

            table tr td {
                font-size: 13px !important;
            }

            table tr th {
                font-size: 13px !important;
            }

            .editmodel {
                font-size: 16px !important;
            }

            .modl-body {
                margin: -35px 0px !important;
            }

            .sales h5 {
                font-size: 18px !important;
                /* padding: 4px !important; */
            }

            .formlabel label {
                font-size: 13px !important;
            }

            .formlabel input {
                font-size: 13px !important;
            }

            .formlabel button {
                font-size: 13px !important;
                /* margin-top:-35px !important;  */
            }

            .formlabel a {
                font-size: 14px !important;
            }
        }

        @media only screen and (min-width: 768px) {
            .menubar ol li {
                font-size: 19px !important;
            }

            table tr td {
                font-size: 14px !important;
            }

            table tr th {
                font-size: 14px !important;
            }

            .editmodel {
                font-size: 17px !important;
            }

            .modl-body {
                margin: -35px 0px !important;
            }

            .sales h5 {
                font-size: 19px !important;
                /* padding: 4px !important; */
            }

            .formlabel label {
                font-size: 14px !important;
            }

            .formlabel input {
                font-size: 14px !important;
            }

            .formlabel button {
                font-size: 13px !important;
                /* margin-top:-35px !important;  */
            }

            .formlabel a {
                font-size: 14px !important;
            }
        }

        @media only screen and (min-width: 992px) {
            .menubar ol li {
                font-size: 20px !important;
            }

            table tr td {
                font-size: 15px !important;
            }

            table tr th {
                font-size: 16px !important;
            }

            .editmodel {
                font-size: 18px !important;
            }

            .modl-body {
                margin: -35px 0px !important;
            }

            .sales h5 {
                font-size: 20px !important;
                /* padding: 4px !important; */
            }

            .formlabel label {
                font-size: 15px !important;
            }

            .formlabel input {
                font-size: 15px !important;
            }

            .formlabel button {
                font-size: 15px !important;
            }

            .formlabel a {
                font-size: 14px !important;
            }
        }

        @media only screen and (min-width: 1200px) {
            .menubar ol li {
                font-size: 22px !important;
            }

            table tr td {
                font-size: 16px !important;
            }

            table tr th {
                font-size: 16px !important;
            }

            .editmodel {
                font-size: 19px !important;
            }

            .modl-body {
                margin: -35px 0px !important;
            }

            .sales h5 {
                font-size: 22px !important;
                /* padding: 4px !important; */
            }

            .formlabel label {
                font-size: 16px !important;
            }

            .formlabel input {
                font-size: 16px !important;
            }

            .formlabel button {
                font-size: 16px !important;
            }

            .formlabel a {
                font-size: 14px !important;
            }
        }
    </style>
    <!-- Main content -->
    <section class="  content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="content-header" style="margin-bottom: -25px !important">
                            <div class="container-fluid">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row ">
                                            <div class="col-12 menubar">
                                                <ol class="breadcrumb m-0 d-flex justify-content-center">
                                                    <li class="breadcrumb-item active"> All Collections Sales</li>
                                                    <li class="breadcrumb-item active">Due</li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row pt-2 pl-4">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="card">
                                    <div class="card-body sales">
                                        <h5>Sales</h5>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12 col-sm-12">
                                                <div class="form-group formlabel">
                                                    <label>Select Customer</label>
                                                    <select class="form-control form-control-sm select2" name="customer_id"
                                                        id="customer_id" style="width: 100%;">
                                                        <option value="" selected disabled>018XXXXX</option>
                                                        @foreach ($data['users'] as $row)
                                                            <option class="pb-3" value="{{ $row->user_id }}">
                                                                {{ $row->name }} {{ $row->phone }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-sm-12 formlabel">
                                                <a href="#" class="btn btn-info add" data-toggle="modal"
                                                    data-target="#addUser" style="margin-top: 30px">Add New</a>
                                            </div>
                                        </div>
                                        <form action="{{ route('sales.collection.store') }}" method="post" id="salesForm"
                                            class="form">
                                            @csrf
                                            <input type="hidden" id="user_id" name="user_id">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6 col-sm-12 form-group formlabel">
                                                    <label>Sales Amount</label>
                                                    <input type="text" class="form-control" name="amount" value=""
                                                        placeholder="Enter Amount">
                                                </div>
                                                <div class="col-lg-5 col-md-6 col-sm-12 form-group formlabel">
                                                    <label>Collection</label>
                                                    <input type="text" name="collection" class="form-control"
                                                        value="" placeholder="Enter Collection">
                                                </div>
                                                <div class="col-lg-2 col-md-6 col-sm-12 form-group clearfix formlabel"
                                                    style="margin-top: 30px">
                                                    <button type="submit" class="btn btn-primary"
                                                        id="submitBtn">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body mt-2 form">
                                        <div class="form-group sales">
                                            <h5>Due Collection</h5>
                                            <hr>
                                            <form action="{{ route('due.collection') }}" method="post"
                                                id="dueCollectionForm">
                                                @csrf
                                                <input type="hidden" name="user_id" id="users_id">
                                                <div class="row">
                                                    <div class="col-lg-9 col-md-8 col-sm-6 form-group formlabel">
                                                        <label>Collection</label>
                                                        <input type="text" name="collection" class="form-control"
                                                            value="" placeholder="Enter Collection">
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-6 form-group clearfix formlabel"
                                                        style="margin-top: 30px">
                                                        <button type="submit" id="dueSubmitBtn"
                                                            class="btn btn-primary">Collect</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-12">
                                <div class="card">

                                    <div id="sales">
                                        <strong class="d-flex justify-content-center mb-2"><span
                                                id="user"></span>&nbsp;
                                            Today Sales</strong>
                                        <hr>
                                        <div class="card-body table-responsive">
                                            <table id="dataTable" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr style="border-top: 1px solid #ddd">
                                                        <th width="10%">SL</th>
                                                        <th width="10%">Customer</th>
                                                        <th width="20%">Sales Amount</th>
                                                        <th width="20%">Receive Amount </th>
                                                        <th width="15%">Due</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data['sales'] as $key => $row)
                                                        @php
                                                            $customer = App\Models\User::where(
                                                                'customer_id',
                                                                Auth::guard('admin')->user()->id,
                                                            )
                                                                ->where('user_id', $row->user_id)
                                                                ->value('name');
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $customer }}</td>
                                                            <td style="text-align: right">{{ $row->sales_amount < 0 ? '(' . number_format(abs($row->sales_amount), 2) . ')' : number_format($row->sales_amount, 2) }}
                                                            </td>
                                                            <td style="text-align: right">{{ $row->collection < 0 ? '(' . number_format(abs($row->collection), 2) . ')' : number_format($row->collection, 2) }}
                                                            </td>
                                                            <td style="text-align: right">{{ $row->due < 0 ? '(' . number_format(abs($row->due), 2) . ')' : number_format($row->due, 2) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="2" class="text-right"><strong>Total =</strong></td>
                                                        <td style="text-align: right">{{ number_format($data['total_amount'], 2) }}</td>
                                                        <td style="text-align: right">{{ number_format($data['total_collection'], 2) }}</td>
                                                        <td style="text-align: right">{{ $data['total_due'] < 0 ? '(' . number_format(abs($data['total_due']), 2) . ')' : number_format($data['total_due'], 2) }}
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    <div id="ledger">
                                        <strong class="d-flex justify-content-center mb-2"><span
                                                id="user"></span>&nbsp;
                                            Ledger Account</strong>
                                        <hr>
                                        <div class="card-body table-responsive">
                                            <table id="dataTable" class="table table-bordered table-striped">
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
                                                <tbody id="item-table">

                                                </tbody>
                                                <tfoot class="form">
                                                    <tr>
                                                        <td colspan="2" class="text-right"><strong>Total =</strong>
                                                        </td>
                                                        <td id="amount" style="text-align: right"></td>
                                                        <td id="total_collection" style="text-align: right"></td>
                                                        <td id="total_due" style="text-align: right"></td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title editmodel" id="exampleModalLabel">Add New Customer </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="modal_body" class="modl-body">
                    <form action="{{ route('customers.store') }}" method="POST" id="userForm">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3 mt-3 formlabel">
                                <label for="user_name" class="form-label"> Customer Name:</label>
                                <input type="text" class="form-control" value="" name="name"
                                    placeholder="Enter Full Name">
                            </div>

                            <div class="mb-3 mt-3 formlabel">
                                <label for="phone" class="form-label"> Customer Phone:</label>
                                <input type="text" class="form-control" value="" name="phone"
                                    placeholder="Enter Valid Phone" required>
                            </div>

                            <div class="mb-3 mt-3 formlabel">
                                <label for="user_email" class="form-label"> Customer Email:</label>
                                <input type="text" class="form-control" value="" name="email"
                                    placeholder="Enter Valid Email">
                            </div>
                        </div>
                        <div class="modal-footer formlabel mb-4">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- </div> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var searchRequest = null;
        $(function() {
            $(".form").hide();
            $("#ledger").hide();
            var minlength = 4;
            $("#customer_id").change(function() {
                $("#ledger").show();
                $(".form").show();
                $(".add").hide();
                $("#sales").hide();
                customerLeader($(this).val());
            });
        });

        $("#salesForm").submit(function(e) {
            e.preventDefault();
            let custID = $("#customer_id").val();
            // disable and ensble button afer 3 second 
            $('#submitBtn').prop('disabled', true);
            setTimeout(function() {
                $('#submitBtn').prop('disabled', false);
            }, 3000);

            var form = $(this);
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                dataType: 'JSON',
                success: function(data) {
                    customerLeader(custID);
                    $("#salesForm")[0].reset();
                    // $('#submitBtn').hide()

                }
            });
        });

        $("#userForm").submit(function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                dataType: 'JSON',
                success: function(data) {
                    history.go(0);
                }
            });
        });

        $("#dueCollectionForm").submit(function(e) {
            e.preventDefault();
            let custID = $("#customer_id").val();
            var form = $(this);

            $('#dueSubmitBtn').prop('disabled', true);
            setTimeout(function() {
                $('#dueSubmitBtn').prop('disabled', false);
            }, 3000);

            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                dataType: 'JSON',
                success: function(data) {
                    customerLeader(custID);
                    $("#dueCollectionForm")[0].reset();
                }
            });
        });

        function customerLeader(custID) {
            $.ajax({
                type: "GET",
                url: "{{ url('admin/get-customers') }}/" + custID,
                dataType: "json",
                success: function(res) {
                    $('#user').text(res.users.name + '`s');
                    $('#user_id').val(res.users.user_id);
                    $('#users_id').val(res.users.user_id);
                    $('#amount').text(parseFloat(res.total_amount).toFixed(2));
                    $('#total_collection').text(parseFloat(res.total_collection).toFixed(2));
                    $('#total_due').text(res.total_due < 0 ? '(' + Math.abs(parseFloat(res.total_due)).toFixed(
                            2) + ')' :
                        parseFloat(res.total_due).toFixed(2));

                    var tbody = '';
                    res.ledger.forEach((element, index) => {
                        url = '{{ url('admin/generate-invoice') }}/' + element.invoice_id;
                        tbody += '<tr>'
                        tbody += '<td>' + (index + 1) + '</td>'
                        tbody += '<td>' + element.date + '</td>'
                        tbody +=  '<td style="text-align: right;">' + parseFloat(element.amount).toFixed(2) + '</td>'
                        tbody +=  '<td style="text-align: right;">' + parseFloat(element.collection).toFixed(2) + '</td>'
                        tbody +=  '<td style="text-align: right;">' + (element.due < 0 ? '(' + Math.abs(parseFloat(element.due))
                            .toFixed(2) + ')' : parseFloat(element.due).toFixed(2)) + '</td>'
                        tbody += '<td class="text-center"><a href="' + url +
                            '" target ="_blank"><span class="fa fa-book"></span></a></td>'
                        tbody += '</tr>'
                    });
                    $('#item-table').html(tbody);
                }
            });
        }
    </script>
@endsection
