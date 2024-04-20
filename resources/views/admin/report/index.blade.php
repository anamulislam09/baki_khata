@extends('layouts.admin')

@section('admin_content')
    <style>
        #dataTable {
            font-size: 15px;
        }
    </style>
    <!-- Main content -->
    <section class="  content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="content-header">
                            <div class="container-fluid">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-12">
                                                <h3 class="m-0 d-flex justify-content-center">Sales Report</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card" style="margin-top: -20px !important">
                            <div class="content-header" style="margin: -10px 5px !important">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 col-sm-5">
                                            <label for="">From</label>
                                            <input value="{{ date('Y-m-d') }}" type="date" name="start_date"
                                                id="start_date" class="form-control date">
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-5">
                                            <label for="">To</label>
                                            <input value="{{ date('Y-m-d') }}" type="date" name="end_date" id="end_date"
                                                class="form-control date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <table id="dataTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr style="border-top: 1px solid #ddd">
                                            <th width="10%">SL</th>
                                            <th width="15%">Date</th>
                                            <th width="20%">Name</th>
                                            <th width="20%">Sales Amount</th>
                                            <th width="15%">Receive Amount</th>
                                            <th width="15%">Due Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="item-table"></tbody>

                                    <tfoot class="today_footer">
                                        <tr>
                                            <td colspan="3" class="text-center"><strong>Total =</strong></td>
                                            <td id="amount">0</td>
                                            <td id="total_collection">0</td>
                                            <td id="total_due">0</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- </div> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var searchRequest = null;

        function reports() {
            $.ajax({
                type: "POST",
                url: "{{ route('report.show') }}",
                data: {
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val(),
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'JSON',
                success: function(res) {
                    console.log(res);
                    var tbody = '';
                    res.ledger.forEach((element, index) => {
                        tbody += '<tr>'
                        tbody += '<td>' + (index + 1) + '</td>'
                        tbody += '<td>' + element.date + '</td>'
                        tbody += '<td>' + element.name + '</td>'
                        tbody += '<td>' + element.amount + '</td>'
                        tbody += '<td>' + element.collection + '</td>'
                        tbody += '<td>' + element.due + '</td>'
                        tbody += '</tr>'
                    });
                    $('#item-table').html(tbody);
                    $('#amount').text(res.total_amount);
                    $('#total_collection').text(res.total_collection);
                    $('#total_due').text(res.total_due);
                }
            });
        }

        $(document).ready(function() {
            reports();
            $('.date').on('change', function() {
                reports();
            });
        });
    </script>
@endsection
