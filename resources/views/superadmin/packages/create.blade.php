@extends('layouts.admin')
@section('admin_content')

<style>
    a.disabled {
        pointer-events: none;
        cursor: default;
    }

    @media only screen and (max-width: 600px) {
        .shop_name h3 {
            font-size: 16px !important;
            margin-top: 6px;
        }
        .shop_name a {
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
            font-size: 16px !important;
            margin-top: 6px;
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

        .edit {
            font-size: 12px !important;
            padding: 4px !important;
        }
    }

    @media only screen and (min-width: 768px) {
        .shop_name h3 {
            font-size: 17px !important;
            margin-top: 6px;
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

        .edit {
            font-size: 13px !important;
            padding: 4px !important;
        }
    }

    @media only screen and (min-width: 992px) {
        .shop_name h3 {
            font-size: 20px !important;
            margin-top: 4px;
        }
        .shop_name a {
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
            font-size: 21px !important;
            /* margin-top: 6px; */
        }
        .shop_name a {
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
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card">
                            <div class="card-header ">
                                <div class="row">
                                    <div class="col-6 shop_name">
                                        <h3 class="card-title">Package Entry form</h3>
                                    </div>
                                    <div class="col-6 shop_name">
                                        <a href="{{ route('packages.all') }}" class="btn btn-info btn-sm text-light"
                                            style="float: right">See Packages</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('package.store') }}" method="POST">
                            @csrf
                            <div class="card">
                                <div class="card-header P-5">
                                    <div class="mb-3 mt-3 form">
                                        <label for="package_name" class="form-label">Package Name</label>
                                        <input type="text" class="form-control" value="{{ old('package_name') }}"
                                            name="package_name" placeholder="Enter Package Name" required>
                                    </div>
                                    <div class="mb-3 mt-3 form">
                                        <label for="amount" class="form-label">Package Amount</label>
                                        <input type="text" class="form-control" value="{{ old('amount') }}"
                                            name="amount" placeholder="Enter amount">
                                    </div>
                                    <div class="mb-3 mt-3 form">
                                        <label for="duration" class="form-label">Package Duration <sub
                                                style="color: #ee8049">(days)</sub></label>
                                        <input type="text" class="form-control" value="{{ old('duration') }}"
                                            name="duration" placeholder="Enter Package Duration">
                                        <span style="font-size: 14px">Note: Duration will days.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer clearfix form">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- </div> --}}
@endsection
