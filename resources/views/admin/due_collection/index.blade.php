@extends('layouts.admin')

@section('admin_content')
    <style>
        #dataTable {
            font-size: 15px;
        }
    </style>
    {{-- <div class="content-wrapper"> --}}
    <!-- Content Header (Page header) -->
    {{-- <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> All Collections</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Collection List</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section> --}}

    <!-- Main content -->
    <section class="  content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <div class="row ">
                                <div class="col-lg-10 col-md-10 col-sm-8 pt-2">
                                    <h3 class="card-title">All Due Collections</h3>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-4">
                                    {{-- <a href="{{ route('collections.create') }}" class="btn btn-light">Add new</a> --}}
                                </div>
                            </div>
                        </div>
                        <div class="row pt-2 pl-4">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <h5 for="">Sales</h5>
                                            <hr>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label>Select User</label>
                                                        <select class="form-control form-control-sm select2"
                                                            name="customer_id" id="customer_id" style="width: 100%;">
                                                            <option value="" selected disabled>018XXXXX</option>
                                                            @foreach ($users as $row)
                                                                <option class="pb-3" value="{{ $row->user_id }}">
                                                                    {{ $row->name }} {{ $row->phone }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <form action="{{ route('sales.collection.store') }}" method="post"
                                                id="salesForm">
                                                @csrf
                                                <input type="hidden" id="user_id" name="user_id">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                                                        <label>Sales Amount</label>
                                                        <input type="text" class="form-control" name="amount"
                                                            value="" placeholder="Enter Amount">
                                                    </div>
                                                    <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                                                        <label>Collection</label>
                                                        <input type="text" name="collection" class="form-control"
                                                            value="" placeholder="Enter collection">
                                                    </div>
                                                    <div class="col-lg-4 col-md-6 col-sm-12 form-group clearfix"
                                                        style="margin-top: 30px">
                                                        <button type="submit" class="btn btn-primary"
                                                            id="submitbtn">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body mt-2">
                                        <div class="form-group">
                                            <h5 for="">Due Collection</h5>
                                            <hr>
                                            <form action="{{ route('due.collection') }}" method="post" id="dueCollectionForm">
                                                @csrf
                                                <input type="hidden" name="user_id" id="users_id">
                                                <div class="row">
                                                    <div class="col-lg-8 col-md-8 col-sm-6 form-group">
                                                        <label>Collection</label>
                                                        <input type="text" name="collection" class="form-control"
                                                            value="" placeholder="Enter collection">
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-6 form-group clearfix"
                                                        style="margin-top: 30px">
                                                        <button type="submit" id="dueSubmitBtn" class="btn btn-primary">Collect</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <strong>Due Collection From <span id="user"></span></strong>
                                        <table id="" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th width="10%">SL</th>
                                                    <th width="15%">Date</th>
                                                    <th width="20%">Sales Amount</th>
                                                    <th width="20%">Receive Amount </th>
                                                    <th width="15%">Due Amount</th>
                                                    <th width="15%"> Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="item-table"></tbody>
                                            {{-- <tbody>
                                                @foreach ($collections as $key => $item)
                                                    @php
                                                        $user = DB::table('users')
                                                            ->where('customer_id', Auth::guard('admin')->user()->id)
                                                            ->where('user_id', $item->user_id)
                                                            ->first();
                                                        $createdBy = DB::table('customers')
                                                            ->where('id', $item->auth_id)
                                                            ->first();
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $item->invoice_id }}</td>
                                                        <td>{{ $user->name }}</td>
                                                        <td class="d-none">{{ $user->phone }}</td>
                                                        <td class="d-none">{{ $user->user_id }}</td>
                                                        <td>{{ $item->amount }}</td>
                                                        <td>{{ $item->date }}/{{ $item->month }}/{{ $item->year }}</td>
                                                        <td>{{ $createdBy->name }}</td>
                                                        <td>
                                                            <a href="{{ route('sales.update', $item->invoice_id) }}"
                                                                class="btn btn-sm btn-info"><i class="fas fa-book"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
        
                                            </tbody> --}}
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- </div> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var searchRequest = null;
        $(function() {
            var minlength = 4;
            $("#customer_id").change(function() {
                customerLeader($(this).val());
            });
        });

        $("#salesForm").submit(function(e) {
            e.preventDefault();
            let custID = $("#customer_id").val();
            console.log(custID);
            var form = $(this);
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                dataType: 'JSON',
                success: function(data) {
                    customerLeader(custID);
                }
            });
        });

        $("#dueCollectionForm").submit(function(e) {
            e.preventDefault();
            let custID = $("#customer_id").val();
            var form = $(this);
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                dataType: 'JSON',
                success: function(data) {
                    customerLeader(custID);
                }
            });
        });

        function customerLeader(custID){
            $.ajax({
                type: "GET",
                url: "{{ url('admin/get-user') }}/" + custID,
                dataType: "json",
                success: function(res) {
                    $('#user').text(res.users.name);
                    $('#user_id').val(res.users.user_id);
                    $('#users_id').val(res.users.user_id);
                    var tbody = '';
                    res.ledger.forEach((element, index)=> {
                        tbody += '<tr>'
                        tbody += '<td>'+ (index+1) +'</td>'
                        tbody += '<td>'+ element.date +'</td>'
                        tbody += '<td>'+ element.amount +'</td>'
                        tbody += '<td>'+ element.collection +'</td>'
                        tbody += '<td>'+ element.due +'</td>'
                        tbody += '<td><a href = ""><span class="fa fa-book">'+element.due+'</span></a></td>'
                        tbody += '</tr>'
                    });
                    $('#item-table').html(tbody);
                }
            });
        }
    </script>
@endsection
