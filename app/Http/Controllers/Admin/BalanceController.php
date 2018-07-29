<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Http\Requests\MoneyValidationFrom;
use Illuminate\Support\Facades\Redirect;

class BalanceController extends Controller
{
    public function index()
    {   
       $balance = auth()->user()->balance;

        $amount = $balance ? $balance->amount : '0';

        return view('admin.balance.index', compact('amount'));
    }

    public function deposit()
    {
        return view('admin.balance.deposit');
    }

    public function depositStore(MoneyValidationFrom $request)
    {

        $balance = auth()->user()->balance()->firstOrCreate([]);
        $retorno = $balance->deposit($request->value);
        if($retorno['success']){

            return redirect()
                        ->route('admin.balance')
                        ->with('success', $retorno['message']);
        }else{

            return redirect()
                        ->back()
                        ->with('error', $retorno['message']);

        }

    }


    public function withdraw()
    {
    
        return view('admin.balance.withdraw', compact(''));
    }


    public function withdrawStore(MoneyValidationFrom $request)
    {

        $balance = auth()->user()->balance()->firstOrCreate([]);
        $retorno = $balance->withdraw($request->value);
        if ($retorno['success']) {

            return redirect()
                ->route('admin.balance')
                ->with('success', $retorno['message']);
        } else {

            return redirect()
                ->back()
                ->with('error', $retorno['message']);

        }


    }



}
