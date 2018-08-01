<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Http\Requests\MoneyValidationFrom;
use Illuminate\Support\Facades\Redirect;
use App\User;
use App\Models\Historic;




class BalanceController extends Controller
{

    private $totalPage = 2;


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
    public function transfer()
    {
    
        return view('admin.balance.transfer', compact(''));
    }
    public function confirmTransfer(Request $request, User $user)
    {
    
      $sender = $user->getSender($request->sender);
        if(empty($sender)){
            return redirect()
                    ->back()
                    ->with('error', 'Usuario não encontrado!');
        }else if($sender->id === auth()->user()->id){

            return redirect()
                ->back()
                ->with('error', 'Não pode transferir para você mesmo!');

           
        }else{

            $balance = auth()->user()->balance;
            return view('admin.balance.transfer-confirm', compact('sender', 'balance'));
        }
    }


    public function transferStore(MoneyValidationFrom $request, User $user){

        $balance = auth()->user()->balance()->firstOrCreate([]);
        $userRecebedor = $user->find($request->sender_id);

        // dd($userRecebedor);
        if (empty($userRecebedor)) {

            return redirect()
                ->route('admin.transfer')
                ->with('success', 'Recebedor não encontrado!');
        }


        $retorno = $balance->transfer($request->value, $userRecebedor);
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

    public function historic(Historic $historic)
    {
        $historics = auth()->user()
                                ->historics()
                                ->with(['userSender'])
                                ->paginate($this->totalPage);
        // dd($historics);
        $types = $historic->type();
        return view('admin.balance.historics',compact('historics', 'types'));
    }


    public function searchHistoric(Request $request, Historic $historic)
    {
        $dataForm = $request->except('_token');

        $historics = $historic->search($dataForm, $this->totalPage);
        $types = $historic->type();

        // dd($dateForm);
        return view('admin.balance.historics', compact('historics', 'types', 'dataForm'));

    }

}
