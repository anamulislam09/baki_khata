@extends('layouts.admin')
@section('admin_content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="m-0 d-flex justify-content-center"> All Clients</h3>
                        </div>
                        <div class="card-body table-responsive">
                            <table id="dataTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr style="border-top: 1px solid #ddd">
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        {{-- <th>Total Due / Advanced</th> --}}
                                        <th>Verification Status</th>
                                        <th>Payment Status</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $item)
                                        @php
                                            $details = App\Models\CustomerDetail::where(
                                                'customer_id',
                                                $item->id,
                                            )->get();
                                            // $total_due = App\Models\Ledger::where('customer_id', $item->id)->sum('due');
                                            // dd($details);
                                        @endphp
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            @foreach ($details as $detail)
                                                <td>{{ $detail->phone }}</td>
                                                <td>{{ $detail->address }}</td>
                                            @endforeach
                                            {{-- <td>
                                                @if ($total_due > 0)
                                                    <span class="badge badge-success">{{ $total_due }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ $total_due }}</span>
                                                @endif
                                            </td> --}}
                                            <td>
                                                @if ($item->isVerified == 1)
                                                    <span class="badge badge-primary">Verified</span>
                                                @else
                                                    <span class="badge badge-danger">Not Verified</span>
                                                @endif
                                            </td>
                                            
                                            <td></td>
                                            <td>
                                                @if ($item->status == 1)
                                                    <span class="badge badge-primary">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Deactive</span>
                                                @endif
                                            </td>
                                            <td>
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
