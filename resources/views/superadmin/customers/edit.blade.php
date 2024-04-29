@extends('layouts.admin')

@section('admin_content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
    <style>
        #dataTable {
            font-size: 15px;
        }

        @media only screen and (max-width: 600px) {
            .shop_name h3 {
                font-size: 15px !important;
            }

            .shop_name a {
                font-size: 15px !important;
            }

            table tr td {
                font-size: 13px !important;
            }

            table tr th {
                font-size: 13px !important;
            }

            .form label {
                font-size: 13px !important;
            }

            .form input {
                font-size: 13px !important;
            }

            .form button {
                font-size: 13px !important;
            }

            .edit {
                font-size: 12px !important;
                padding: 4px !important;
            }
        }

        @media only screen and (min-width: 600px) {
            .shop_name h3 {
                font-size: 15px !important;
            }

            .shop_name a {
                font-size: 15px !important;
            }

            table tr td {
                font-size: 13px !important;
            }

            table tr th {
                font-size: 13px !important;
            }

            .form label {
                font-size: 14px !important;
            }

            .form input {
                font-size: 14px !important;
            }

            .form button {
                font-size: 14px !important;
            }

            .edit {
                font-size: 12px !important;
                padding: 4px !important;
            }
        }

        @media only screen and (min-width: 768px) {
            .shop_name h3 {
                font-size: 16px !important;
            }

            .shop_name a {
                font-size: 16px !important;
            }

            table tr td {
                font-size: 14px !important;
            }

            table tr th {
                font-size: 14px !important;
            }

            .form label {
                font-size: 15px !important;
            }

            .form input {
                font-size: 15px !important;
            }

            .form button {
                font-size: 15px !important;
            }

            .edit {
                font-size: 13px !important;
                padding: 4px !important;
            }
        }

        @media only screen and (min-width: 992px) {
            .shop_name h3 {
                font-size: 21px !important;
            }

            .shop_name a {
                font-size: 21px !important;
            }

            table tr td {
                font-size: 15px !important;
            }

            table tr th {
                font-size: 16px !important;
            }

            .form label {
                font-size: 17px !important;
            }

            .form input {
                font-size: 17px !important;
            }

            .form button {
                font-size: 17px !important;
            }

            .edit {
                font-size: 13px !important;
                padding: 4px !important;
            }
        }

        @media only screen and (min-width: 1200px) {
            .shop_name h3 {
                font-size: 22px !important;
            }

            .shop_name a {
                font-size: 22px !important;
            }

            table tr td {
                font-size: 16px !important;
            }

            table tr th {
                font-size: 16px !important;
            }

            .form label {
                font-size: 17px !important;
            }

            .form input {
                font-size: 17px !important;
            }

            .form button {
                font-size: 17px !important;
            }

            .edit {
                font-size: 14px !important;
                padding: 4px !important;
            }
        }
    </style>
    <!-- Main content -->
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card">
                            <div class="card-header ">
                                <div class="row">
                                    <div class="col-6 shop_name">
                                        <h3 class="card-title mt-2">Edit Client </h3>
                                    </div>
                                    <div class="col-6 shop_name">
                                        <a href="{{ route('client.all') }}" style="float: right"
                                            class="btn btn-sm btn-outline-primary">Cancel Edit
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row m-auto">
                                <div class="col-lg-8 col-md-10 col-sm-12 m-auto" style="border: 1px solid #ddd">
                                    <form action="{{ route('client.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $data->id }}">
                                        <div class="modal-body">
                                            <div class="mb-3 mt-3 form">
                                                <label for="user_name" class="form-label"> Client Name:</label>
                                                <input type="text" class="form-control" value="{{ $data->name }}"
                                                    name="name">
                                            </div>

                                            @php
                                                $details = App\Models\CustomerDetail::where(
                                                    'customer_id',
                                                    $data->id,
                                                )->first();
                                                $packages = App\Models\Package::get();
                                                // dd($details);
                                            @endphp

                                            <div class="mb-3 mt-3 form">
                                                <label for="user_phone" class="form-label"> Client phone:</label>
                                                <input type="text" class="form-control" value="{{ $details->phone }}"
                                                    name="phone">
                                            </div>

                                            <div class="mb-3 mt-3">
                                                <label for="user_email" class="form-label"> Client email:</label>
                                                <input type="email" class="form-control" value="{{ $data->email }}"
                                                    name="email">
                                            </div>

                                            <div class="mb-3 mt-3 form">
                                                <label for="exampleInputEmail1">Assign Package </label>
                                                <select name="package" id="" class="form-control">
                                                    <option value="" selected disabled>Select Once</option>
                                                    @foreach ($packages as $package)
                                                        <option value="{{ $package->id }}"
                                                            @if ($data->package_id == $package->id) selected @endif>
                                                            {{ $package->package_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 mt-3 form">
                                                <label for="exampleInputEmail1"> Status </label>
                                                <select name="status" id="" class="form-control">
                                                    <option value="1"
                                                        @if ($data->status == 1) selected @endif>
                                                        Active</option>
                                                    <option value="0"
                                                        @if ($data->status == 0) selected @endif>
                                                        Deactive</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="modal-footer form">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- </div> --}}
@endsection
