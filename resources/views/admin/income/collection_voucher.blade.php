@extends('layouts.admin')

@section('admin_content')
    <style>
        input:focus {
            outline: none
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-12" style="border: 1px solid #ddd">
                                        <form action="{{ route('income.collection.all') }}" method="post">
                                            @csrf
                                            <div class="row my-4">
                                                <div class="col-lg-3">
                                                    <strong><span>Create voucher </span></strong>
                                                </div>
                                                <div class="col-lg-3">
                                                    {{-- <label for="" class="col-form-label">Select Year</label> --}}
                                                    <select name="year" class="form-control" id="" required>
                                                        <option value="" selected disabled>Select Year</option>
                                                        <option value="2023">Year 2023
                                                        </option>
                                                        <option value="2024">Year 2024
                                                        </option>
                                                        <option value="2025">Year 2025
                                                        </option>
                                                        <option value="2026">Year 2026
                                                        </option>
                                                        <option value="2027">Year 2027
                                                        </option>
                                                        <option value="2028">Year 2028
                                                        </option>
                                                        <option value="2029">Year 2029
                                                        </option>
                                                        <option value="2030">Year 2030
                                                        </option>
                                                    </select>
                                                </div>
                                                {{-- 'month', date('m'))->where('year', date('Y') --}}
                                                <div class="col-lg-3">
                                                    {{-- <label for="" class="col-form-label">Select Month</label> --}}
                                                    <select name="month" class="form-control" id="" required>
                                                        <option value="" selected disabled>Select Month </option>
                                                        <option value="1">January
                                                        </option>
                                                        <option value="2">February
                                                        </option>
                                                        <option value="3">March
                                                        </option>
                                                        <option value="4">April
                                                        </option>
                                                        <option value="5">May</option>
                                                        <option value="6">June
                                                        </option>
                                                        <option value="7">July
                                                        </option>
                                                        <option value="8">August
                                                        </option>
                                                        <option value="9">September
                                                        </option>
                                                        <option value="10">October
                                                        </option>
                                                        <option value="11">November
                                                        </option>
                                                        <option value="12">December
                                                        </option>
                                                    </select>
                                                </div>

                                                {{-- @if (Route::current()->getName() == 'income.create') --}}
                                                <div class="col-lg-2">
                                                    <label for="" class="col-form-label"></label>
                                                    <input type="submit" class="btn btn-primary" value="Submit">
                                                </div>
                                                {{-- @else --}}
                                                {{-- @endif --}}
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @php
                                    $data = Session::get('data');
                                    $months = Session::get('months');
                                @endphp

                                @if (isset($data) && !empty($data))
                                    {{-- @php   
                    @foreach ($data as $key => $item)
                    $month = Ap\Models\Income::where('month', $item->month)->where('year', $item->year)->where('customer_id', Auth::guard('admin')->user()->id)->first();
                    @endforeach
             @endphp --}}
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-10">
                                                    <strong> Total collection month of @if ($months->month == 1)
                                                            January
                                                        @elseif ($months->month == 2)
                                                            February
                                                        @elseif ($months->month == 3)
                                                            March
                                                        @elseif ($months->month == 4)
                                                            April
                                                        @elseif ($months->month == 5)
                                                            May
                                                        @elseif ($months->month == 6)
                                                            June
                                                        @elseif ($months->month == 7)
                                                            July
                                                        @elseif ($months->month == 8)
                                                            August
                                                        @elseif ($months->month == 9)
                                                            September
                                                        @elseif ($months->month == 10)
                                                            October
                                                        @elseif ($months->month == 11)
                                                            November
                                                        @elseif ($months->month == 12)
                                                            December
                                                        @endif </strong>
                                                </div>
                                                <div class="col-2">
                                                    <form action="{{ route('income.voucher.generateall') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="month" value="{{ $months->month }}">
                                                        <input type="hidden" name="year" value="{{ $months->year }}">

                                                        <label for="" class="col-form-label"></label>
                                                        <input type="submit" class="btn btn-info text-end"
                                                            value="Generate all">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <table id="dataTable" class="table table-bordered table-striped mt-3">
                                        <thead>
                                            <tr>
                                                <th style="width: 8%">SL</th>
                                                <th>Flat Name</th>
                                                <th style="width: 15%" class="text-center">Payable</th>
                                                <th style="width: 15%" class="text-center">Paid Amount</th>
                                                <th style="width: 15%" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($data as $key => $item)
                                                @php

                                                    $total = App\Models\Income::where('month', $item->month)
                                                        ->where('year', $item->year)
                                                        ->where('status', '!=', 0)
                                                        ->where('customer_id', Auth::guard('admin')->user()->id)
                                                        ->sum('paid');

                                                    $due = App\Models\Income::where('month', $item->month)
                                                        ->where('year', $item->year)
                                                        ->where('status', '!=', 0)
                                                        ->where('customer_id', Auth::guard('admin')->user()->id)
                                                        ->sum('due');

                                                    $month = Carbon\Carbon::now()->month;
                                                    $year = Carbon\Carbon::now()->year;
                                                    $previousMonthData = App\Models\Income::where('month', $item->month - 1)
                                                        ->where('year', $item->year)
                                                        ->where('flat_id', $item->flat_id)
                                                        ->where('customer_id', Auth::guard('admin')->user()->id)
                                                        ->first();

                                                    $data = App\Models\Income::where('month', $item->month)
                                                        ->where('year', $item->year)
                                                        ->where('customer_id', Auth::guard('admin')->user()->id)
                                                        ->where('flat_id', $item->flat_id)
                                                        ->first();
                                                    if (isset($previousMonthData->due)) {
                                                        $amount = $previousMonthData->due + $data->amount;
                                                    }

                                                @endphp
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->flat_name }}</td>
                                                    @if (isset($previousMonthData->due) && !empty($previousMonthData->due))
                                                        <td class="text-right"> {{ $amount }}</td>
                                                    @else
                                                        @if (isset($data->amount) && !empty($data->amount))
                                                            <td class="text-right"> {{ $data->amount }}</td>
                                                        @else
                                                        @endif
                                                    @endif
                                                    <td class="text-right"> {{ $item->paid }}</td>
                                                    <td class="text-center"><a
                                                            href="{{ route('income.voucher.generate', $item->id) }}"
                                                            class="btn btn-sm btn-info">Voucher</a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" class="text-right"> <strong>Total :</strong></td>
                                                <td class="text-right"><strong>{{ $total + $due }}</strong></td>
                                                <td class="text-right"><strong>{{ $total }}</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                @else
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
@endsection
