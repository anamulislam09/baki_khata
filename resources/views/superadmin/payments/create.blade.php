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
                                        <h3 class="card-title">Collection Entry Form</h3>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('collections.all') }}" class="btn btn-info btn-sm text-light"
                                            style="float: right">See All Collections</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('collection.store') }}" method="POST">
                            @csrf
                            <div class="card">
                                <div class="card-header P-5">
                                    <div class="mb-3 mt-3">
                                        <label for="exampleInputEmail1">Select Client </label>
                                        <select class="form-control form-control-sm select2" name="client_id" id="client_id" style="width: 100%;" required>
                                        <option value="" selected disabled>Select Once</option>
                                        @foreach ($client as $item)
                                            <option class="pb-3" value="{{ $item->id }}">
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label>Package Name</label>
                                        <input type="text" class="form-control" value="" id="package"
                                            name="package_name">
                                    </div>

                                    <div class="mb-3 mt-3">
                                        <label for="package_bill" class="form-label">Package Bill</label>
                                        <input type="text" class="form-control" value=""
                                            name="package_bill" id="package_bill">
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="amount" class="form-label">Collection Amount</label>
                                        <input type="text" class="form-control" value="{{ old('amount') }}"
                                            name="collection_amount" placeholder="Enter amount">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#client_id").change(function() {
                let client_id = $(this).val();
                // $("#package").html('<option value="">Select One</option>')
                $.ajax({    
                    url: '/admin/get-package',
                    type: 'post',
                    data: 'client_id=' + client_id + '&_token={{ csrf_token() }}',
                    success: function(result) {
                        $('#package').val(result.package.package_name);
                        $('#package_bill').val(result.package.amount);
                        // console.log(result);
                    }
                })
            })
        })
    </script>
@endsection
