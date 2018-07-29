<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    
    
        public $timestamps = false;
        public function deposit(float $value) :Array
        {

            $total_before = $this->amount ? $this->amount : 0 ;
            $this->amount += number_format($value, 2, '.', '') ;
            $total_after = $this->amount;         
            $deposit = $this->save();

            $historic = auth()->user()->historics()->create([
                'type'          => 'I',
                'amount'        => $value,
                'total_before'  => $total_before ,
                'total_after'   => $total_after,
                'date'          => date('Ymd'),
            
            ]);
            if($deposit && $historic){
                return [
                    'success' => true,
                    'message' => 'Sucesso ao recarregar'
                ];

            }else{
            return [
                'success' => false,
                'message' => 'Falha ao recarregar'
            ];

            }
        }

}
