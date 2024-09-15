<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function Index()
    {
        $data['customers'] = User::where('customer_id', Auth::guard('admin')->user()->id)->get();
        return view('admin.report.index', compact('data'));
    }

    public function AllReport(Request $request)
    {
        // Initialize query with optional filters
        $query = Ledger::where('customer_id', Auth::guard('admin')->user()->id);

        // Filter by date range if provided
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        // Filter by user_id if provided (0 means all users)
        if ($request->user_id != 0) {
            $query->where('user_id', $request->user_id);
        }

        // Fetch and aggregate data
        $data['ledger'] = $query->select(
            'ledgers.*',
            DB::raw('SUM(amount) as amount'),
            DB::raw('SUM(collection) as collection'),
            DB::raw('SUM(due) as due')
        )
            ->groupBy('user_id')
            ->get();

        foreach ($data['ledger'] as $key => $ledger) {
            $data['ledger'][$key]->name = User::where('user_id', $ledger->user_id)->first()->name;
        }

        // Summing the totals
        $data['total_amount'] = $query->sum('amount');
        $data['total_collection'] = $query->sum('collection');
        $data['total_due'] = $query->sum('due');

        return response()->json($data, 200);
    }
}
