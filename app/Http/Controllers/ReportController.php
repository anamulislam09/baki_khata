<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class ReportController extends Controller
{
    public function Index()
    {
        $ledger = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('date', date('Y-m-d'))->groupBy('user_id')->get();
        $total_amount = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('date', date('Y-m-d'))->sum('amount');
        $total_collection = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('date', date('Y-m-d'))->sum('collection');
        $total_due = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('date', date('Y-m-d'))->sum('due');
        return view('admin.report.index', compact('ledger', 'total_amount', 'total_collection', 'total_due'));
    }
}
