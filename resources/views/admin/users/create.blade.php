@extends('layouts.admin')

@section('admin_content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card card-primary">
                              <div class="card-header ">
                                  <div class="row">
                                      <div class="col-lg-10 col-sm-12 pt-2">
                                        <h3 class="card-title">Users Entry form</h3>
                                      </div>
                                      <div class="col-lg-2 col-sm-12">
                                        <a href="{{ route('users.index') }}" class="btn btn-light text-dark">See Users
                                        </a>
                                      </div>
                                  </div>
                              </div>
                          </div>
                            <!-- /.card-header -->
                            <div class="card-body P-5">
                                <form action="{{ route('user.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3 mt-3">
                                        <label for="name" class="form-label">User Name:</label>
                                        <input type="text" class="form-control" value="{{ old('name') }}"
                                            name="name" id="name" placeholder="Enter User Name" required>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="phone" class="form-label">User Phone:</label>
                                        <input type="text" class="form-control" value="{{ old('Phone') }}"
                                            name="phone" id="phone" placeholder="Enter Phone">
                                    </div>

                                    <div class="mb-3 mt-3">
                                        <label for="email" class="form-label">User Email:</label>
                                        <input type="email" class="form-control" value="{{ old('email') }}"
                                            name="email" id="email" placeholder="Enter Valid Email">
                                    </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
