<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function Index()
    {
        // $ledger = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('date', date('Y-m-d'))->groupBy('user_id')->get();
        // $today_amount = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('date', date('Y-m-d'))->sum('amount');
        // $today_collection = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('date', date('Y-m-d'))->sum('collection');
        // $today_due = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('date', date('Y-m-d'))->sum('due');
        return view('admin.report.index');
    }
    public function AllReport(Request $request)
    {
        $data['ledger'] = Ledger::where('customer_id', Auth::guard('admin')->user()->id)
            ->whereBetween('date', [$request->start_date, $request->end_date])
            ->select(
                'ledgers.*',
                DB::raw('SUM(amount) as amount'),
                DB::raw('SUM(collection) as collection'),
                DB::raw('SUM(due) as due')
            )
            ->groupBy('user_id')
            ->get();

        foreach ($data['ledger'] as $key => $ledger)
            $data['ledger'][$key]->name = User::where('user_id',$ledger->user_id)->first()->name;
        $data['total_amount'] = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->whereBetween('date', [$request->start_date, $request->end_date])->sum('amount');
        $data['total_collection'] = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->whereBetween('date', [$request->start_date, $request->end_date])->sum('collection');
        $data['total_due'] = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->whereBetween('date', [$request->start_date, $request->end_date])->sum('due');
        return response()->json($data, 200);
    }
}
