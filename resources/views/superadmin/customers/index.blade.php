@extends('layouts.admin')
@section('admin_content')
    <style>
        #dataTable {
            font-size: 15px;
        }

        @media only screen and (max-width: 600px) {
            .shop_name h3 {
                font-size: 17px !important;
            }

            table tr td {
                font-size: 13px !important;
            }

            table tr th {
                font-size: 13px !important;
            }

            .edit {
                font-size: 12px !important;
                padding: 4px !important;
            }
        }

        @media only screen and (min-width: 600px) {
            .shop_name h3 {
                font-size: 18px !important;
            }

            table tr td {
                font-size: 13px !important;
            }

            table tr th {
                font-size: 13px !important;
            }

            .edit {
                font-size: 12px !important;
                padding: 4px !important;
            }
        }

        @media only screen and (min-width: 768px) {
            .shop_name h3 {
                font-size: 19px !important;
            }

            table tr td {
                font-size: 14px !important;
            }

            table tr th {
                font-size: 14px !important;
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

            table tr td {
                font-size: 15px !important;
            }

            table tr th {
                font-size: 16px !important;
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

            table tr td {
                font-size: 16px !important;
            }

            table tr th {
                font-size: 16px !important;
            }

            .edit {
                font-size: 14px !important;
                padding: 4px !important;
            }
        }
    </style>

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header shop_name">
                            <h3 class="m-0 d-flex justify-content-center"> All Clients</h3>
                        </div>
                        <div class="card-body table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr style="border-top: 1px solid #ddd">
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Verification Status</th>
                                        <th>Package</th>
                                        <th>Validation Status</th>
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
                                            $package = App\Models\Package::where('id', $item->package_id)->first();
                                            // dd($package->package_name)
                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
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

                                            <td>
                                                @if (!empty($package->package_name))
                                                    {{ $package->package_name }}
                                                @endempty
                                        </td>


                                        @php
                                            $today = Carbon\Carbon::today()->toDateString();
                                            $datetime1 = new DateTime($item->package_start_date);
                                            $datetime2 = new DateTime($today);
                                            $difference = $datetime1->diff($datetime2);
                                        @endphp

                                        <td>
                                            @if (!empty($package))
                                                @if ($difference->days > $package->duration)
                                                    <span class="badge badge-danger">Expired</span>
                                                @elseif ($package->duration - $difference->days <= 30)
                                                    <span class="badge badge-warning">Expeired Soon</span>
                                                @else
                                                    <span class="badge badge-primary">Done</span>
                                                @endif
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
                                            <a href="{{ route('client.edit', $item->id) }}"
                                                class="btn btn-sm btn-info edit"><i class="fas fa-edit"></i></a>
                                            <a href="{{ route('client.delete', $item->id) }}"
                                                class="btn btn-sm btn-danger edit"><i class="fas fa-trash"></i></a>
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
