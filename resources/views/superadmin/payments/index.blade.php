@extends('layouts.admin')

@section('admin_content')
    <style>
        a.disabled {
            pointer-events: none;
            cursor: default;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
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
                                        <div class="row">
                                            <div class="col-6">
                                                <h3 class="card-title">All Collections</h3>
                                            </div>
                                            <div class="col-6">
                                                <a href="{{ route('collection.create') }}"
                                                    class="btn btn-info btn-sm text-light"  style="float: right">Add New
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
                                            <th>SL</th>
                                            <th>Client Name</th>
                                            <th>Amount</th>
                                            <th>Collection Amount</th>
                                            <th>Due</th>
                                            <th> Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($payments as $key => $item)
                                        @php
                                            $customer = App\Models\Customer::where('id', $item->customer_id)->first();
                                            // dd($costomer);
                                        @endphp
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $customer->name}}</td>
                                                <td>{{ $item->payment_amount }}</td>
                                                <td>{{ $item->paid }}</td>
                                                <td>{{ $item->due }}</td>
                                                <td>
                                                    <a href="" class="btn btn-sm btn-info edit"
                                                        data-id="{{ $item->id }}" data-toggle="modal"
                                                        data-target="#editUser"><i class="fas fa-edit"></i></a>
                                                    <a href="{{ route('collection.delete', $item->id) }}"
                                                        class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Collection </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="modal_body">

                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js"></script>
    <script>
        $('body').on('click', '.edit', function() {
            let id = $(this).data('id');
            $.get("/admin/collection/edit/" + id, function(data) {
                $('#modal_body').html(data);

            })
        })
    </script>
@endsection
