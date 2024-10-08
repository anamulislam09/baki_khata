@extends('layouts.admin')

@section('admin_content')
    <style>
        a.disabled {
            pointer-events: none;
            cursor: default;
        }

        @media only screen and (max-width: 600px) {
            .menubar {
                display: flex;
                justify-content: space-between;
            }

            .shop_name a {
                font-size: 12px !important;
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

            .edit {
                font-size: 12px !important;
                padding: 4px !important;
            }
        }

        @media only screen and (min-width: 600px) {
            .menubar {
                display: flex;
                justify-content: space-between;
            }

            .shop_name a {
                font-size: 12px !important;
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

            .edit {
                font-size: 12px !important;
                padding: 4px !important;
            }
        }

        @media only screen and (min-width: 768px) {
            .menubar {
                display: flex;
                justify-content: space-between;
            }

            .shop_name a {
                font-size: 13px !important;
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

            .edit {
                font-size: 13px !important;
                padding: 4px !important;
            }
        }

        @media only screen and (min-width: 992px) {
            .menubar {
                display: flex;
                justify-content: space-between;
            }

            .shop_name a {
                font-size: 14px !important;
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

            .edit {
                font-size: 13px !important;
                padding: 4px !important;
            }
        }

        @media only screen and (min-width: 1200px) {
            .menubar {
                display: flex;
                justify-content: space-between;
            }

            .shop_name a {
                font-size: 15px !important;
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

            .edit {
                font-size: 14px !important;
                padding: 4px !important;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
    {{-- <div class="content-wrapper"> --}}
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="content-header" style="margin-bottom: -40px !important">
                            <div class="container-fluid">
                                <div class="card">
                                    <div class="card-header ">
                                        <div class="menubar">
                                            <div class="shop_name pt-2">
                                                <h3 class="card-title">All Customers</h3>
                                            </div>
                                            <div class="shop_name">
                                                <a href="{{ route('customers.create') }}"
                                                    class="btn btn-info text-light">Add New
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr style="border-top: 1px solid #ddd">
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Balance</th>
                                            {{-- <th>Status</th> --}}
                                            <th> Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $key => $item)
                                            @php
                                                $balance = App\Models\Ledger::where(
                                                    'customer_id',
                                                    Auth::guard('admin')->user()->id,
                                                )
                                                    ->where('user_id', $item->user_id)
                                                    ->sum('due');
                                                $Total_balance = App\Models\Ledger::where(
                                                    'customer_id',
                                                    Auth::guard('admin')->user()->id,
                                                )->sum('due');
                                            @endphp
                                            <tr>
                                                <td>{{ $item->user_id }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->phone }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td style="text-align: right">{{ $balance < 0 ? '(' . number_format(abs($balance), 2) .')' : number_format($balance, 2) }} </td>
                                                {{-- <td>
                                                    @if ($item->status == 0)
                                                        <span class="badge badge-danger">Deactive</span>
                                                    @else
                                                        <span class="badge badge-primary">Active</span>
                                                    @endif
                                                </td> --}}
                                                <td>
                                                    <a href="" class="btn btn-sm btn-info edit"
                                                        data-id="{{ $item->user_id }}" data-toggle="modal"
                                                        data-target="#editUser"><i class="fas fa-edit"></i></a>
                                                    <a href="{{ route('customers.delete', $item->user_id) }}"
                                                        class="btn btn-sm btn-danger edit"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td>Total =</td>
                                            <td style="text-align: right">
                                                @if (isset($Total_balance) && !empty($Total_balance))
                                                    {{ $Total_balance < 0 ? '(' . number_format(abs($Total_balance), 2) .')' : number_format($Total_balance, 2) }}
                                                @else
                                                    0.00
                                                @endif
                                            </td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    {{-- category edit model --}}
    <!-- Modal -->
    <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title editmodel">Edit Customer </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div id="modal_body" class="modl-body">

                </div>

            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js"></script>
    <script>
        $('body').on('click', '.edit', function() {
            let user_id = $(this).data('id');
            $.get("/admin/customers/edit/" + user_id, function(data) {
                $('#modal_body').html(data);
            })
        })
    </script>
@endsection
