<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <style>
        .container {
            width: 90%;
            margin: auto;
        }

        .header-section {
            width: 100%;
            height: 100px;
            margin-top: -30px;
        }

        .header-text {
            width: 100%;
            float: left;
            text-align: center;
            margin-top: -15px
        }

        .header-text h1 {
            font-family: arial;
            margin-bottom: -6Px;
        }

        .header-text p {
            margin: 0px 10px;
        }

        .status p {
            width: 100%;
        }

        .body p {
            line-height: 30px;
            /* margin-top: 0px; */
        }

        /* table style ends here  */

        .Prepared {
            width: 70%;
            float: left;
        }

        .Prepared h4 {
            border-top: 2px solid black;
            width: 40%;
            text-align: center;
        }

        .Recipient {
            width: 30%;
            float: left;
            text-align: -webkit-right;
        }

        .Recipient h4 {
            border-top: 2px solid black;
            width: 90%;
            text-align: center;
        }

        /* body text start here  */
        .bodyInfo {
            display: flex;
            justify-content: space-between;
            display: block;
            /* padding: 15px 0px; */
            padding-bottom: 8px;
            width: 100%;
            height: 50px;
            /* background: #fb5200; */
        }

        .left-text {
            width: 25%;
            float: left;
            /* line-height: 10px; */
        }

        .middle-text {
            width: 55%;
            float: left;
            padding-left: 10%;
            margin-top: -12px;
            /* text-align: center; */
            /* line-height: 10px; */
        }

        .middle-text p {
            width: 50%;
            text-align: center;
            padding: 10px 5px;
            background: #000;
            border-radius: 20px;
            font-weight: 800;
            font-size: 20PX;
            color: white;
            font-family: cursive;
            /* line-height: 10px; */
        }

        .right-text {
            width: 20%;
            float: right;
            margin-bottom: -15px;
            line-height: 0px;
        }

        /* body text ends here  */
    </style>
</head>

<body>
    <div class="container">
        <div class="header-section row">
            <div class="col-2">
                <img src="{{ asset('admin/dist/img/logo.png') }}">
            </div>
            <div class="col-8">
                <div class="header-text">
                    <h1>{{ $customer->shop_name }}</h1>
                    <p>{{ $custDetails->address }}</p>
                    <p>{{ $custDetails->phone }}</p>
                    <p>{{ $customer->email }}</p>
                </div>
            </div>
            <div class="col-2"></div>

            <div class="header-text">
                <h1>{{ $customer->shop_name }}</h1>
                <p>{{ $custDetails->address }}</p>
                <p>{{ $custDetails->phone }}</p>
                <p>{{ $customer->email }}</p>
            </div>
        </div>

        <div class="bodyInfo">
            <div class="left-text">
                <p>MR No : {{ $inv->invoice_id }}</p>
            </div>
            <div class="middle-text">
                <p>Money Receipt</p>
            </div>

            <div class="right-text">
                <p style="margin-top: 0px">{!! DNS1D::getBarcodeHTML("$inv->invoice_id", 'C128', 1, 30) !!}</p>
                <p>Date :{{ date('m/d/y') }}</p>
            </div>
        </div>
        @php

            $amountWord = numtowords($inv->amount);
            $collectionWord = numtowords($inv->collection);
            $dueWord = numtowords(abs($inv->due));

            function numtowords(float $number)
            {
                $decimal = round($number - ($no = floor($number)), 2) * 100;
                $decimal_part = $decimal;
                $hundred = null;
                $hundreds = null;
                $digits_length = strlen($no);
                $decimal_length = strlen($decimal);
                $i = 0;
                $str = [];
                $str2 = [];
                $words = [
                    0 => '',
                    1 => 'One',
                    2 => 'Two',
                    3 => 'Three',
                    4 => 'Four',
                    5 => 'Five',
                    6 => 'Six',
                    7 => 'Seven',
                    8 => 'Eight',
                    9 => 'Nine',
                    10 => 'Ten',
                    11 => 'Eleven',
                    12 => 'Twelve',
                    13 => 'Thirteen',
                    14 => 'Fourteen',
                    15 => 'Fifteen',
                    16 => 'Sixteen',
                    17 => 'Seventeen',
                    18 => 'Eighteen',
                    19 => 'Nineteen',
                    20 => 'Twenty',
                    30 => 'Thirty',
                    40 => 'Forty',
                    50 => 'Fifty',
                    60 => 'Sixty',
                    70 => 'Seventy',
                    80 => 'Eighty',
                    90 => 'Ninety',
                ];
                $digits = ['', 'Hundred', 'Thousand', 'Lakh', 'Crore'];

                while ($i < $digits_length) {
                    $divider = $i == 2 ? 10 : 100;
                    $number = floor($no % $divider);
                    $no = floor($no / $divider);
                    $i += $divider == 10 ? 1 : 2;
                    if ($number) {
                        $plural = ($counter = count($str)) && $number > 9 ? 's' : null;
                        $hundred = $counter == 1 && $str[0] ? ' and ' : null;
                        $str[] =
                            $number < 21
                                ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred
                                : $words[floor($number / 10) * 10] .
                                    ' ' .
                                    $words[$number % 10] .
                                    ' ' .
                                    $digits[$counter] .
                                    $plural .
                                    ' ' .
                                    $hundred;
                    } else {
                        $str[] = null;
                    }
                }

                $d = 0;
                while ($d < $decimal_length) {
                    $divider = $d == 2 ? 10 : 100;
                    $decimal_number = floor($decimal % $divider);
                    $decimal = floor($decimal / $divider);
                    $d += $divider == 10 ? 1 : 2;
                    if ($decimal_number) {
                        $plurals = ($counter = count($str2)) && $decimal_number > 9 ? 's' : null;
                        $hundreds = $counter == 1 && $str2[0] ? ' and ' : null;
                        @$str2[] =
                            $decimal_number < 21
                                ? $words[$decimal_number] . ' ' . $digits[$decimal_number] . $plural . ' ' . $hundred
                                : $words[floor($decimal_number / 10) * 10] .
                                    ' ' .
                                    $words[$decimal_number % 10] .
                                    ' ' .
                                    $digits[$counter] .
                                    $plural .
                                    ' ' .
                                    $hundred;
                    } else {
                        $str2[] = null;
                    }
                }

                $takas = implode('', array_reverse($str));
                $paise = implode('', array_reverse($str2));
                $paise = $decimal_part > 0 ? $paise . ' Paise' : '';
                return ($takas ? $takas . 'Takas ' : '') . $paise;
            }

        @endphp

        <div class="body">
            <p>Received with thanks from mr./ms <strong><span style="border-bottom: 2px dotted #000; padding:0px 70px">
                        @if (isset($user->name) && !empty($user->name))
                            {{ $user->name }}
                        @endif
                    </span></strong> The
                sum of sales amount tk. (in words)
                <strong><span
                        style="border-bottom: 2px dotted #000; padding:0px 70px">{{ $amountWord ? $amountWord : 0 }}</span></strong>
                , Collection amount of tk. (in words)
                <strong><span
                        style="border-bottom: 2px dotted #000; padding:0px 70px">{{ $collectionWord ? $collectionWord : 0 }}</span></strong>
                @if ($amountWord)
                    and @if ($inv->due > 0)
                        advanced
                    @else
                        due
                    @endif amount of tk. (in words) <strong><span
                            style="border-bottom: 2px dotted #000; padding:0px 70px">{{ $dueWord ? $dueWord : 0 }}</span></strong>
                @endif
                Month of <strong><span style="border-bottom: 2px dotted #000; padding:0px 70px">
                        @if ($inv->month == 1)
                            January
                        @elseif ($inv->month == 2)
                            February
                        @elseif ($inv->month == 3)
                            March
                        @elseif ($inv->month == 4)
                            April
                        @elseif ($inv->month == 5)
                            May
                        @elseif ($inv->month == 6)
                            June
                        @elseif ($inv->month == 7)
                            July
                        @elseif ($inv->month == 8)
                            August
                        @elseif ($inv->month == 9)
                            September
                        @elseif ($inv->month == 10)
                            October
                        @elseif ($inv->month == 11)
                            November
                        @elseif ($inv->month == 12)
                            December
                        @endif {{ $inv->year }}
                    </span> </strong>.
                {{-- In Cash <strong><span style="border-bottom: 2px dotted #000; padding:0px 30px">
                        {{ $inv->collection }}</span></strong>. --}}
        </div>
        <div class="footer">
            <div class="Prepared">
                @php
                    $customer = App\Models\Customer::where('id', $inv->auth_id)->first();
                @endphp
                <p style=" margin-bottom:-20px; text-align:center; width:40%">
                    {{ $customer->name }}</p>
                <h4>Prepared by</h4>
            </div>
            <div class="Recipient">
                <p></p>
                <h4>Recipient Signature</h4>
            </div>
        </div>
    </div>
</body>

</html>
