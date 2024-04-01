@extends('layouts.admin')
@section('admin_content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.6.0/bootstrap-tagsinput.css"
        integrity="sha512-3uVpgbpX33N/XhyD3eWlOgFVAraGn3AfpxywfOTEQeBDByJ/J7HkLvl4mJE1fvArGh4ye1EiPfSBnJo2fgfZmg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
    <style>
        .bootstrap-tagsinput .tag {
            background: #428bca;
            border: 1px solid white;
            padding: 1.6px;
            padding-left: 2px;
            margin-right: 2px;
            color: white;
            border-radius: 4px
        }
        .img {
            font-size: 16px !important;
        }
    </style>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Due Collections</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Collections</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- form start -->
                <form action="{{ route('collections.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-primary">
                        <div class="card-header ">
                            <div class="row">
                                <div class="col-lg-10 col-sm-12 pt-2">
                                    <h3 class="card-title">Add Due Collection</h3>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <a href="{{ route('collections.index') }}" class="btn btn-light text-dark">See all</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- left column -->
                            <div class="col-lg-12">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> Users</label>
                                                <select name="user_id" id="user_id"
                                                    class="form-control @error('user_id') is-invalid @enderror">
                                                    <option value="" selected disabled>Select Once</option>
                                                    @foreach ($users as $item)
                                                        <option value="{{ $item->user_id }}">{{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Collect Amount</label>
                                                <input type="text" name="amount" value="{{ old('amount') }}"
                                                    class="form-control" id="" placeholder="Enter Amount">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary ml-5">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js"></script>
    <script src="{{ asset('admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.6.0/bootstrap-tagsinput.min.js"></script>

    {{-- CHECKBOX  --}}
    <script>
        $('.dropify').dropify(); //dropify image 
        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });
    </script>
    {{-- get product from category wise using ajax  --}}
    <script>
        $(document).ready(function() {
            // get subcategory 
            $("#category").change(function() {
                let categoryid = $(this).val();
                $("#product").html('<option value="">Select One</option>')
                $.ajax({
                    url: '/admin/product',
                    type: 'post',
                    data: 'categoryid=' + categoryid + '&_token={{ csrf_token() }}',
                    success: function(result) {
                        $('#product').html(result);
                    }
                })
            })
        });
    </script>

    <script type="text/javascript">
        $('#btn-add').on('click', function() {
            var tbody = '';
            product = $('#product').val();
            qty = $('#product_quantity').val();
            qty_rate = $('#product_unit_per_rate').val();
            // discount_rate = $('#discount_rate').val();
            tbody += '<tr>'
            tbody += '<td class="serial"></td>'
            tbody += '<td>' + product + '</td>'
            tbody += '<td>' + qty + '</td>'
            tbody += '<td>' + qty_rate + '</td>'
            // tbody += '<td>' + discount_rate + '</td>'
            tbody += '<input type="hidden" name="product[]" value="' + product + '" />'
            tbody += '<input type="hidden" name="qty[]" value="' + qty + '" />'
            tbody += '<input type="hidden" name="qty_rate[]" value="' + qty_rate + '" />'
            tbody += '</tr>'
            $('.item-table').append(tbody);
            setSerial();
            $('#product').val('');
            $('#product_quantity').val('');
            $('#product_unit_per_rate').val('');
        });

        function setSerial() {
            var i = 1;
            $('.serial').each(function(key, element) {
                $(element).html(i++);
            });
        }
    </script>
@endsection
