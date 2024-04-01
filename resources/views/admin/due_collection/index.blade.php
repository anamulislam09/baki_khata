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
                                    <a href="{{ route('collections.create') }}" class="btn btn-light">Add new</a>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-2 pl-4">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="">Choose Users</label>
                                            <form action="" method="post">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label>Minimal</label>
                                                            <select class="form-control form-control-sm select2"
                                                                name="customer_id" id="customer_id" style="width: 100%;">
                                                                @foreach ($users as $row)
                                                                    <option class="pb-3" value="{{ $row->id }}">
                                                                        {{ $row->name }} {{ $row->phone }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
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
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>User Name</th>
                                                    <th class="d-none">User Phone</th>
                                                    <th class="d-none">User ID</th>
                                                    <th>Amount</th>
                                                    <th>Date</th>
                                                    <th>Created By</th>
                                                    <th> Action</th>
                                                </tr>
                                            </thead>
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
                $.ajax({
                    type: "GET",
                    url: "{{ url('customer-details') }}/" + $(this).val(),
                    // url: "https://dummyjson.com/products/1",
                    dataType: "json",
                    success: function(res) {
                        console.log(res.id);
                        console.log(res.title);


                    }
                });
            });
        });


        $("#idForm").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);
            var actionUrl = form.attr('action');

            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize(),
                dataType: "json",
                success: function(data) {
                    alert(data); // show response from the php script.
                }
            });

        });
    </script>
@endsection
