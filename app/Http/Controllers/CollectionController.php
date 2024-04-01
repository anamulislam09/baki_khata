<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class CollectionController extends Controller
{
    public function Index(){
        $users = User::where('customer_id', Auth::guard('admin')->user()->id)->get();
        return view('admin.due_collection.index' , compact('users'));
    }
}
