@extends('layouts.admin')

@section('admin_content')
<style>
    #dataTable {
        font-size: 15px;
    }

    @media only screen and (max-width: 600px) {
        .menubar h3 {
            font-size: 17px !important;
        }

        table tr td {
            font-size: 13px !important;
        }

        table tr th {
            font-size: 13px !important;
        }

        .editmodel {
            font-size: 15px !important;
        }

        .modl-body {
            margin: -35px 0px !important;
        }

        .sales h5{
            font-size: 17px !important;
            /* padding: 4px !important; */
        }

        .formlabel label {
            font-size: 13px !important;
        }

        .formlabel input {
            font-size: 13px !important;
        }

        .formlabel button {
            font-size: 13px !important;
            margin-top:-35px !important; 
        }

        .formlabel a {
            font-size: 13px !important;
            margin-top:0px !important; 
        }
    }

    @media only screen and (min-width: 600px) {
        .menubar h3 {
            font-size: 18px !important;
        }

        table tr td {
            font-size: 13px !important;
        }

        table tr th {
            font-size: 13px !important;
        }

        .editmodel {
            font-size: 16px !important;
        }

        .modl-body {
            margin: -35px 0px !important;
        }

        .sales h5{
            font-size: 18px !important;
            /* padding: 4px !important; */
        }

        .formlabel label {
            font-size: 13px !important;
        }

        .formlabel input {
            font-size: 13px !important;
        }

        .formlabel button {
            font-size: 13px !important;
            /* margin-top:-35px !important;  */
        }
        .formlabel a {
            font-size: 14px !important;
        }
    }

    @media only screen and (min-width: 768px) {
        .menubar h3 {
            font-size: 19px !important;
        }

        table tr td {
            font-size: 14px !important;
        }

        table tr th {
            font-size: 14px !important;
        }

        .editmodel {
            font-size: 17px !important;
        }

        .modl-body {
            margin: -35px 0px !important;
        }

        .sales h5{
            font-size: 19px !important;
            /* padding: 4px !important; */
        }

        .formlabel label {
            font-size: 14px !important;
        }

        .formlabel input {
            font-size: 14px !important;
        }

        .formlabel button {
            font-size: 13px !important;
            /* margin-top:-35px !important;  */
        }
        .formlabel a {
            font-size: 14px !important;
        }
    }

    @media only screen and (min-width: 992px) {
        .menubar h3 {
            font-size: 20px !important;
        }

        table tr td {
            font-size: 15px !important;
        }

        table tr th {
            font-size: 16px !important;
        }

        .editmodel {
            font-size: 18px !important;
        }

        .modl-body {
            margin: -35px 0px !important;
        }

        .sales h5{
            font-size: 20px !important;
            /* padding: 4px !important; */
        }

        .formlabel label {
            font-size: 15px !important;
        }

        .formlabel input {
            font-size: 15px !important;
        }

        .formlabel button {
            font-size: 15px !important;
        }
        .formlabel a {
            font-size: 14px !important;
        }
    }

    @media only screen and (min-width: 1200px) {
        .menubar h3 {
            font-size: 22px !important;
        }

        table tr td {
            font-size: 16px !important;
        }

        table tr th {
            font-size: 16px !important;
        }

        .editmodel {
            font-size: 19px !important;
        }

        .modl-body {
            margin: -35px 0px !important;
        }

        .sales h5{
            font-size: 22px !important;
            /* padding: 4px !important; */
        }

        .formlabel label {
            font-size: 16px !important;
        }

        .formlabel input {
            font-size: 16px !important;
        }

        .formlabel button {
            font-size: 16px !important;
        }
        .formlabel a {
            font-size: 14px !important;
        }
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
                                            <div class="col-12 menubar">
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
                                        <div class="col-lg-3 col-md-4 col-sm-5 formlabel">
                                            <label for="">From</label>
                                            <input value="{{ date('Y-m-d') }}" type="date" name="start_date"
                                                id="start_date" class="form-control date">
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-5 formlabel">
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
                    $('#amount').text(parseFloat(res.total_amount).toFixed(2));
                    $('#total_collection').text(parseFloat(res.total_collection).toFixed(2));
                    $('#total_due').text(parseFloat(res.total_due).toFixed(2));
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
