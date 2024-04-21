@extends('layouts.admin')
@section('admin_content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card">
                            <div class="card-header ">
                                <div class="row">
                                    <div class="col-6">
                                        <h3 class="card-title">Package Entry form</h3>
                                    </div>
                                    <div class="col-6">
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
                                    <div class="mb-3 mt-3">
                                        <label for="package_name" class="form-label">Package Name</label>
                                        <input type="text" class="form-control" value="{{ old('package_name') }}"
                                            name="package_name" placeholder="Enter Package Name" required>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="amount" class="form-label">Package Amount</label>
                                        <input type="text" class="form-control" value="{{ old('amount') }}"
                                            name="amount" placeholder="Enter amount">
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="duration" class="form-label">Package Duration <sub
                                                style="color: #ee8049">(days)</sub></label>
                                        <input type="text" class="form-control" value="{{ old('duration') }}"
                                            name="duration" placeholder="Enter Package Duration">
                                        <span style="font-size: 14px">Note: Duration will days.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
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
