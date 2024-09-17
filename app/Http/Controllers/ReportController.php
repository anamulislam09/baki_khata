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

        // Check if a specific user is selected or all users
        if ($request->user_id != 0) {
            $query->where('user_id', $request->user_id);
        }

        // Calculate totals based on the query
        $totalsQuery = clone $query;
        $data['total_amount'] = $totalsQuery->sum('amount');
        $data['total_collection'] = $totalsQuery->sum('collection');
        $data['total_due'] = $totalsQuery->sum('due');

        // Fetch and aggregate data for display in the ledger
        $data['ledger'] = $query->select(
            'ledgers.*',
            DB::raw('SUM(amount) as amount'),
            DB::raw('SUM(collection) as collection'),
            DB::raw('SUM(due) as due')
        )
            ->groupBy('user_id')
            ->orderBy('date', 'asc')
            ->get();

        // Attach user names to the ledger data
        foreach ($data['ledger'] as $ledger) {
            $ledger->name = User::where('user_id', $ledger->user_id)->value('name');
        }

        return response()->json($data, 200);
    }
}
