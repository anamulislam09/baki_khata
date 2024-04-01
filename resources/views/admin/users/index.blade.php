@extends('layouts.admin')

@section('admin_content')
    <style>
        a.disabled {
            pointer-events: none;
            cursor: default;
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
                            <div class="card card-primary">
                                <div class="card-header ">
                                    <div class="row">
                                        <div class="col-lg-10 col-md-10 col-sm-6 pt-2">
                                          <h3 class="card-title">All Users</h3>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-4">
                                          <a href="{{ route('user.create') }}" class="btn btn-light btn-sm text-dark">Add New
                                          </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>User Id</th>
                                        {{-- <th width="10%">Customer_Id</th> --}}
                                        <th>User Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th> Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $item)
                                       
                                        <tr>
                                            <td>{{ $item->user_id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>
                                                @if ($item->status == 0)
                                                    <span class="badge badge-danger">Deactive</span>
                                                @else
                                                    <span class="badge badge-primary">Active</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="" class="btn btn-sm btn-info edit"
                                                    data-id="{{ $item->user_id }}" data-toggle="modal"
                                                    data-target="#editUser"><i class="fas fa-edit"></i></a>
                                                <a href="{{ route('user.delete', $item->user_id) }}"
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
    {{-- </div> --}}
    </section>
    {{-- </div> --}}

    {{-- category edit model --}}
    <!-- Modal -->
    <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit User </h5>
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
            let user_id = $(this).data('id');
            $.get("/admin/user/edit/" + user_id, function(data) {
                $('#modal_body').html(data);

            })
        })
    </script>
@endsection
