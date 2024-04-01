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
                    <form action="{{ route('account.allbalancesheet') }}" method="post">
                      @csrf
                      <div class="row my-4">
                        <div class="col-lg-3">
                          <strong><span>Balance Sheet </span></strong>
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
                          <input type="submit" class="btn btn-primary" value="Generate">
                        </div>
                        {{-- @else --}}
                        {{-- @endif --}}
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              @php
                $data = Session::get('data');
                $months = Session::get('months');
              @endphp

              @if (isset($data) && !empty($data))

                <div class="card-header">
                  <div class="row">
                    <div class="col-lg-10 col-sm-12">
                      <h3 class="card-title">Balance Sheet month of
                        @if (date('m') == 1)
                          January
                        @elseif (date('m') == 2)
                          February
                        @elseif (date('m') == 3)
                          March
                        @elseif (date('m') == 4)
                          April
                        @elseif (date('m') == 5)
                          May
                        @elseif (date('m') == 6)
                          June
                        @elseif (date('m') == 7)
                          July
                        @elseif (date('m') == 8)
                          August
                        @elseif (date('m') == 9)
                          September
                        @elseif (date('m') == 10)
                          October
                        @elseif (date('m') == 11)
                          November
                        @elseif (date('m') == 12)
                          December
                        @endif
                      </h3>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th class="text-center">Total Income</th>
                        <th class="text-center">Total expense</th>
                        <th class="text-center">Balance</th>
                        <th class="text-center">Flag</th>
                    </thead>
                    <tbody>
                      @if ($data)
                        <tr>
                          <td class="text-right">{{ $data->total_income }}</td>
                          <td class="text-right">{{ $data->total_expense }}</td>
                          <td class="text-right">{{ $data->amount }}</td>
                          <td class="text-center">
                            @if ($data->flag == 1)
                              <span class="badge badge-primary">Profit</span>
                            @else
                              <span class="badge badge-danger">Loss</span>
                            @endif
                          </td>
                        </tr>
                      @else
                      @endif
                    </tbody>
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
