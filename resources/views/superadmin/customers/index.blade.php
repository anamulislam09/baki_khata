@extends('layouts.admin')

@section('admin_content')
    {{-- <div class="content-wrapper"> --}}
    <!-- Main content -->
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-10 col-sm-12">
                                    <h3 class="card-title">All Clients</h3>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row ml-3">
                                <div class="col-3 form-group">
                                    <label for="">Status</label>
                                    <select name="status" class="form-control submitable" id="status">
                                        <option value="">All</option>
                                        <option value="0">Inactive</option>
                                        <option value="1">Active</option>
                                    </select>
                                </div>
                            </div> --}}
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="dataTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Client Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Total Due / Advanced</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        @php
                                            $details = App\Models\CustomerDetail::where(
                                                'customer_id',
                                                $item->id,
                                            )->get();
                                            $total_due = App\Models\Ledger::where('customer_id', $item->id)->sum('due');
                                            // dd($details);
                                        @endphp
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            @foreach ($details as $detail)
                                                <td>{{ $detail->phone }}</td>
                                                <td>{{ $detail->address }}</td>
                                            @endforeach
                                            <td>
                                                @if ($total_due > 0)
                                                    <span class="badge badge-success">{{ $total_due }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ $total_due }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->status == 1)
                                                    <span class="badge badge-primary">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Deactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="" class="btn btn-sm btn-primary"><i
                                                        class="fas fa-eye"></i></a>
                                                <a href="{{ route('client.edit', $item->id) }}"
                                                    class="btn btn-sm btn-info edit"><i class="fas fa-edit"></i></a>
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
    {{-- </div> --}}
@endsection
