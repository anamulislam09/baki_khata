@extends('layouts.admin')

@section('admin_content')
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
                                        <form action="{{ route('incomesall.month') }}" method="post">
                                            @csrf
                                            <div class="row my-4">
                                                <div class="col-lg-3">
                                                    <strong><span>Monthly Income </span></strong>
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

                            @php
                                $data = Session::get('monthly_income');
                                $months = Session::get('months');
                                $opening_balance = Session::get('opening_balance');
                                $others_income = Session::get('others_income');
                            @endphp

                            @if (isset($data) && !empty($data))
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-8 col-sm-6">
                                            <h3 class="card-title">Total Income month of
                                                @if ($months->month == 1)
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
                                                @endif
                                            </h3>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            @if (isset($opening_balance) && !empty($data))
                                                @if ($opening_balance->flag == 1)
                                                    <h3 class="card-title"><strong>Opening Balance
                                                            {{ $opening_balance->profit }}</strong></h3>
                                                @else
                                                    <h3 class="card-title"><strong>Opening Loss
                                                            ({{ $opening_balance->loss }})</strong></h3>
                                                @endif
                                            @else
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="8%">Sl</th>
                                                <th>Income Head</th>
                                                <th width="20%">Total Income</th>
                                                {{-- <th class="text-center">Total expense</th>
                        <th class="text-center">Balance</th>
                        <th class="text-center">Flag</th> --}}
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td class="text-left">{{ $months->charge }}</td>
                                                <td class="text-right">{{ $data }}</td>
                                            </tr>
                                            @foreach ($others_income as $key => $item)
                                                @php
                                                    $others_total = App\Models\OthersIncome::where(
                                                        'month',
                                                        $item->month,
                                                    )
                                                        ->where('year', $item->year)
                                                        ->where('customer_id', Auth::guard('admin')->user()->id)
                                                        ->sum('amount');
                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $key + 2 }}</td>
                                                    <td class="text-left">{{ $item->income_info }}</td>
                                                    <td class="text-right">{{ $item->amount }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                @if (isset($opening_balance))
                                                    <td colspan="2" class="text-right"><strong>Total Income without O/P:
                                                        </strong></td>
                                                    @if (isset($others_total))
                                                        <td colspan="2" class="text-right">
                                                            <strong>{{ $data + $others_total }}</strong>
                                                        </td>
                                                    @else
                                                        <td colspan="2" class="text-right">
                                                            <strong>{{ $data }}</strong>
                                                        </td>
                                                    @endif
                                                @else
                                                    <td colspan="2" class="text-right"><strong>Total Income :
                                                        </strong></td>
                                                    @if (isset($others_total))
                                                        <td colspan="2" class="text-right">
                                                            <strong>{{ $data + $others_total }}</strong>
                                                        </td>
                                                    @else
                                                        <td colspan="2" class="text-right">
                                                            <strong>{{ $data }}</strong>
                                                        </td>
                                                    @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                @if (isset($opening_balance))
                                                    <td colspan="2" class="text-right"><strong>Total with O/P: </strong>
                                                    </td>

                                                    @if (isset($others_total) && isset($opening_balance) && !empty($data))
                                                        @if ($opening_balance->flag == 1)
                                                            <td colspan="2" class="text-right">
                                                                <strong>{{ $data + $others_total + $opening_balance->profit }}</strong>
                                                            </td>
                                                        @else
                                                            <td colspan="2" class="text-right">
                                                                <strong>{{ $data + $others_total - $opening_balance->loss }}</strong>
                                                            </td>
                                                        @endif
                                                    @elseif(isset($others_total) && !isset($opening_balance) && !empty($data))
                                                        <td colspan="2" class="text-right">
                                                            <strong>{{ $data + $others_total }}</strong>
                                                        </td>
                                                    @elseif(!isset($others_total) && isset($opening_balance) && !empty($data))
                                                        @if ($opening_balance->flag == 1)
                                                            <td colspan="2" class="text-right">
                                                                <strong>{{ $data + $opening_balance->profit }}</strong>
                                                            </td>
                                                        @else
                                                            <td colspan="2" class="text-right">
                                                                <strong>{{ $data - $opening_balance->loss }}</strong>
                                                            </td>
                                                        @endif
                                                    @endif
                                                @else
                                                @endif

                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @else
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
