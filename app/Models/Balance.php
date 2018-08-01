<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\User;

class Balance extends Model
{


    public $timestamps = false;
  

    public function withdraw(float $value) : array
    {
        if ($this->amount < $value) {
            return [
                'success' => false,
                'message' => 'Saldo Insuficiente'
            ];
        }
        DB::beginTransaction();

        $total_before = $this->amount ? $this->amount : 0;
        $this->amount -= number_format($value, 2, '.', '');
        $total_after = $this->amount;
        $withdraw = $this->save();

        $historic = auth()->user()->historics()->create([
            'type' => 'O',
            'amount' => $value,
            'total_before' => $total_before,
            'total_after' => $total_after,
            'date' => date('Ymd'),

        ]);
        if ($withdraw && $historic) {
            DB::commit();
            return [
                'success' => true,
                'message' => 'Sucesso ao Saque'
            ];

        } else {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Falha ao Saque'
            ];

        }

    }
    public function transfer(float $value, \App\User $sender) : array    {
        if ($this->amount < $value) {
            return [
                'success' => false,
                'message' => 'Saldo Insuficiente'
            ];
        }
        DB::beginTransaction();

        /******************************************************
         *  Atualiza o proprio saldo
         *  **************************************************/

        $total_before = $this->amount ? $this->amount : 0;
        $this->amount -= number_format($value, 2, '.', '');
        $total_after = $this->amount;
        $transfer = $this->save();

        $historic = auth()->user()->historics()->create([
            'type'                 => 'T',
            'amount'               => $value,
            'total_before'         => $total_before,
            'total_after'          => $total_after,
            'date'                 => date('Ymd'),
            'user_id_transaction'  => $sender->id

        ]);



        /******************************************************
         *  Atualiza o saldo do recebedor 
         *  **************************************************/

        $senderBalance = $sender->balance()->firstOrCreate([]);

        $total_beforeSender = $senderBalance->amount ? $senderBalance->amount : 0;
        $senderBalance->amount += number_format($value, 2, '.', '');
        $total_afterSender = $senderBalance->amount;
        $transferSender = $senderBalance->save();

        $historicSender = $sender->historics()->create([
            'type' => 'I',
            'amount' => $value,
            'total_before' => $total_beforeSender,
            'total_after' => $total_afterSender,
            'date' => date('Ymd'),
            'user_id_transaction' => auth()->user()->id

        ]);


        if ($transfer && $historic && $transferSender && $historicSender ) {
            DB::commit();
            return [
                'success' => true,
                'message' => 'Sucesso ao Transferir'
            ];

        } else {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Falha ao Transferir'
            ];

        }
    }
    public function deposit(float $value) : array
    {
        DB::beginTransaction();

        $total_before = $this->amount ? $this->amount : 0;
        $this->amount += number_format($value, 2, '.', '');
        $total_after = $this->amount;
        $deposit = $this->save();

        $historic = auth()->user()->historics()->create([
            'type' => 'I',
            'amount' => $value,
            'total_before' => $total_before,
            'total_after' => $total_after,
            'date' => date('Ymd'),

        ]);
        if ($deposit && $historic) {
            DB::commit();
            return [
                'success' => true,
                'message' => 'Sucesso ao recarregar'
            ];

        } else {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Falha ao recarregar'
            ];

        }
    }

}
