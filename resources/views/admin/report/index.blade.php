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
                                        <div class="row mb-2">
                                            <div class="col-12">
                                                <h3 class="m-0 d-flex justify-content-center">All Reports</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            {{-- <hr> --}}
                            <div class="card-body table-responsive row">
                                <div class="col-lg-3 col-md-4 col-sm-7">
                                    <h4><input value="{{ date('Y-m-d') }}" type="date" name="date"
                                            class="form-control" id="date"></h4>
                                </div>
                                <table id="dataTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr style="border-top: 1px solid #ddd">
                                            <th width="10%">SL</th>
                                            <th width="15%">Date</th>
                                            <th width="20%">Name</th>
                                            <th width="20%">Sales </th>
                                            <th width="15%">Collection</th>
                                            <th width="15%">Due</th>
                                        </tr>
                                    </thead>
                                    <tbody id="today_table">
                                        @foreach ($ledger as $key => $item)
                                            @php
                                                $users = App\Models\User::where(
                                                    'customer_id',
                                                    Auth::guard('admin')->user()->id,
                                                )
                                                    ->where('user_id', $item->user_id)
                                                    ->first();

                                                $amount = App\Models\Ledger::where(
                                                    'customer_id',
                                                    Auth::guard('admin')->user()->id,
                                                )
                                                    ->where('user_id', $item->user_id)
                                                    ->where('date', date('Y-m-d'))
                                                    ->sum('amount');
                                                $collection = App\Models\Ledger::where(
                                                    'customer_id',
                                                    Auth::guard('admin')->user()->id,
                                                )
                                                    ->where('user_id', $item->user_id)
                                                    ->where('date', date('Y-m-d'))
                                                    ->sum('collection');
                                                $due = App\Models\Ledger::where(
                                                    'customer_id',
                                                    Auth::guard('admin')->user()->id,
                                                )
                                                    ->where('user_id', $item->user_id)
                                                    ->where('date', date('Y-m-d'))
                                                    ->sum('due');
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->date }}</td>
                                                <td>{{ $users->name }}</td>
                                                <td>{{ $amount }}</td>
                                                <td>{{ $collection }}</td>
                                                <td>{{ $due }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tbody id="item-table"></tbody>

                                    <tfoot class="today_footer">
                                        <tr>
                                            <td colspan="3" class="text-center"><strong>Total =</strong></td>
                                            <td id="amount">{{ $total_amount }}</td>
                                            <td id="total_collection">{{ $total_collection }}</td>
                                            <td id="total_due">{{ $total_due }}</td>
                                        </tr>
                                    </tfoot>

                                    <tfoot class="date_footer">
                                        <tr>
                                            <td colspan="3" class="text-center"><strong>Total =</strong></td>
                                            <td id="amount"></td>
                                            <td id="total_collection"></td>
                                            <td id="total_due"></td>
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
        // $(function() {
        //     $("#item-table").hide();
        //     $(".date_footer").hide();
        //     var minlength = 4;
        //     $("#customer_id").change(function() {
        //         $("#item-table").show();
        //         customerLeader($(this).val());
        //     });
        // });

        //     function customerLeader(custID) {
        //         $.ajax({
        //             type: "GET",
        //             url: "{{ url('admin/get-customers') }}/" + custID,
        //             dataType: "json",
        //             success: function(res) {
        //                 $('#user').text(res.users.name + '`s');
    //             $('#amount').text(res.total_amount);
    //             $('#total_collection').text(res.total_collection);
    //             $('#total_due').text(res.total_due);

    //             var tbody = '';
    //             res.ledger.forEach((element, index) => {
    //                 url = '{{ url('admin/generate-invoice') }}/' + element.invoice_id;
    //                 tbody += '<tr>'
    //                 tbody += '<td>' + (index + 1) + '</td>'
    //                 tbody += '<td>' + element.date +'</td>'
    //                 tbody += '<td>' + element.amount + '</td>'
    //                 tbody += '<td>' + element.collection + '</td>'
    //                 tbody += '<td>' + element.due + '</td>'
    //                 tbody += '<td class="text-center"><a href="' + url +
    //                     '" target ="_blank"><span class="fa fa-book"></span></a></td>'
    //                 tbody += '</tr>'
    //             });
    //             $('#item-table').html(tbody);
    //         }
    //     });
    // }

    $(document).ready(function() {
        $("#item-table").hide();
        $(".date_footer").hide();
        $("#date").on('change', function() {
            $("#item-table").show();
            $("#date_footer").show();
            $("#today_table").hide();
            $(".today_footer").hide();
            var date = $(this).val();
            // alert(date);
            // $.ajax({
            //     type: "GET",
            //     url: "{{ url('admin/get-transaction') }}/" + date,
            //     dataType: "json",
            //     success: function(res) {
            //         $('#user').text(res.users.name + '`s');
            //             $('#amount').text(res.total_amount);
            //             $('#total_collection').text(res.total_collection);
            //             $('#total_due').text(res.total_due);

            //             var tbody = '';
            //             res.ledger.forEach((element, index) => {
            //                 url = '{{ url('admin/generate-invoice') }}/' + element
            //                     .invoice_id;
            //                 tbody += '<tr>'
            //                 tbody += '<td>' + (index + 1) + '</td>'
            //                 tbody += '<td>' + element.date + '</td>'
            //                 tbody += '<td>' + element.amount + '</td>'
            //                 tbody += '<td>' + element.collection + '</td>'
            //                 tbody += '<td>' + element.due + '</td>'
            //                 tbody += '<td class="text-center"><a href="' + url +
            //                     '" target ="_blank"><span class="fa fa-book"></span></a></td>'
            //                 tbody += '</tr>'
            //             });
            //             $('#item-table').html(tbody);
            //         }
            //     });
            });
        });
    </script>
@endsection
