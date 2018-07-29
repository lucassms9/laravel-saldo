<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

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
