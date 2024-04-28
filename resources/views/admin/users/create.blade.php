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

        .form label {
            font-size: 13px !important;
        }

        .form input {
            font-size: 13px !important;
        }
        .form button {
            font-size: 13px !important;
        }
        .card-body {
            margin:-35px 0px !important;
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

        .form label {
            font-size: 13px !important;
        }

        .form input {
            font-size: 13px !important;
        }
        .form button {
            font-size: 13px !important;
        }
        .card-body {
            margin:-35px 0px !important;
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

        .form label {
            font-size: 14px !important;
        }

        .form input {
            font-size: 14px !important;
        }
        .form button {
            font-size: 14px !important;
        }
        .card-body {
            margin:-35px 0px !important;
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

        .form label {
            font-size: 15px !important;
        }

        .form input {
            font-size: 15px !important;
        }
        .form button {
            font-size: 15px !important;
        }
        .card-body {
            margin:-35px 0px !important;
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

        .form label {
            font-size: 16px !important;
        }

        .form input {
            font-size: 16px !important;
        }
        .form button {
            font-size: 16px !important;
        }
        .card-body {
            margin:-35px 0px !important;
        }
    }
</style>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card">
                              <div class="card-header ">
                                  <div class="menubar">
                                    <div class="shop_name pt-2">
                                        <h3 class="card-title">Customer Entry form</h3>
                                    </div>
                                    <div class="shop_name">
                                        <a href="{{ route('customers.index') }}" class="btn btn-info text-light">See Customer
                                        </a>
                                    </div>
                                </div>
                              </div>
                          </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ route('customers.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3 mt-3 form">
                                        <label for="name" class="form-label">Customer Name:</label>
                                        <input type="text" class="form-control" value="{{ old('name') }}"
                                            name="name" id="name" placeholder="Enter Customer Name" required>
                                    </div>
                                    <div class="mb-3 mt-3 form">
                                        <label for="phone" class="form-label">Customer Phone:</label>
                                        <input type="text" class="form-control" value="{{ old('Phone') }}"
                                            name="phone" id="phone" placeholder="Enter Phone">
                                    </div>

                                    <div class="mb-3 mt-3 form">
                                        <label for="email" class="form-label">Customer Email:</label>
                                        <input type="email" class="form-control" value="{{ old('email') }}"
                                            name="email" id="email" placeholder="Enter Valid Email">
                                    </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix form">
                                <button type="submit" class="btn btn-primary" style="float: right">Submit</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    {{-- </div> --}}
@endsection
