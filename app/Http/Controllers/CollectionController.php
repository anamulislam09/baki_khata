<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Ledger;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Response;

class CollectionController extends Controller
{
    public function Index()
    {
        $users = User::where('customer_id', Auth::guard('admin')->user()->id)->get();
        return view('admin.due_collection.index', compact('users'));
    }

    public function GetUser($id)
    {
        $data['users'] = User::where('customer_id', Auth::guard('admin')->user()->id)->where('user_id', $id)->first();
        $data['ledger'] = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('user_id', $id)->get();
        // $data['invoice'] = Invoice::where('customer_id', Auth::guard('admin')->user()->id)->where('user_id', $id)->first();
        return response()->json($data);
        // $data = [$users, $invoice];
        // return Response::json($data,200);
    }
    public function storeInvoice(Request $request)
    {
        $data = $request->all();
        $v_id = 1;
        $isExist = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->exists();

        if ($isExist) {
            $invoice_id = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->max('invoice_id');
            $invoice_id = explode('-', $invoice_id)[1];
            $data['invoice_id'] = 'INV-' . $this->formatSrl(++$invoice_id);
        } else {
            $data['invoice_id'] = 'INV-' . $this->formatSrl($v_id);
        }
        
        $data['customer_id'] = Auth::guard('admin')->user()->id;
        $data['auth_id'] = Auth::guard('admin')->user()->id;
        $data['user_id'] = $request->user_id;
        $data['amount'] = $request->amount;
        $data['collection'] = $request->collection;
        $data['due'] = $request->amount - $request->collection;
        $data['date'] = date('d');
        $data['month'] = date('m');
        $data['year'] = date('Y');
        $ledger = Ledger::create($data);
        if ($ledger) {
            $ledgers = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->latest()->first();

            $data['customer_id'] = $ledgers->id;
            $data['auth_id'] = $ledgers->id;
            $data['user_id'] = $ledgers->user_id;
            $data['invoice_id'] = $ledgers->invoice_id;
            $data['amount'] = $ledgers->amount;
            $data['collection'] = $ledgers->collection;
            $data['due'] = $ledgers->due;
            $data['date'] = date('d');
            $data['month'] = date('m');
            $data['year'] = date('Y');
            Invoice::create($data);
        }

        return Response::json(true,200);
    }

    public function dueCollection(Request $request){
        $data = $request->all();
        $v_id = 1;
        $isExist = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->exists();
        if ($isExist) {
            $invoice_id = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->max('invoice_id');
            $data['invoice_id'] = $this->formatSrl(++$invoice_id);
        } else {
            $data['invoice_id'] = 'INV-' . $this->formatSrl($v_id);
        }
        $data['customer_id'] = Auth::guard('admin')->user()->id;
        $data['auth_id'] = Auth::guard('admin')->user()->id;
        $data['user_id'] = $request->user_id;
        $data['collection'] = $request->collection;
        $data['due'] = $request->collection;
        $data['date'] = date('d');
        $data['month'] = date('m');
        $data['year'] = date('Y');
        $ledger = Ledger::create($data);
        if ($ledger) {
            $ledgers = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->latest()->first();

            $data['customer_id'] = $ledgers->id;
            $data['auth_id'] = $ledgers->id;
            $data['user_id'] = $ledgers->user_id;
            $data['invoice_id'] = $ledgers->invoice_id;
            $data['amount'] = $ledgers->amount;
            $data['collection'] = $ledgers->collection;
            $data['due'] = $ledgers->due;
            $data['date'] = date('d');
            $data['month'] = date('m');
            $data['year'] = date('Y');
            Invoice::create($data);
        }
        return Response::json(true,200);
    }

    // unique id serial function
    public function formatSrl($srl)
    {
        switch (strlen($srl)) {
            case 1:
                $zeros = '000000';
                break;
            case 2:
                $zeros = '00000';
                break;
            case 3:
                $zeros = '0000';
                break;
            case 4:
                $zeros = '000';
                break;
            case 5:
                $zeros = '00';
                break;
            default:
                $zeros = '0';
                break;
        }
        return $zeros . $srl;
    }
}
