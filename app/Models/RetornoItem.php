<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PJBank\Package\Models\Traits\SendQueue;

class RetornoItem extends Model
{
    use SendQueue;

    public $fillable = [
        'retorno_id',
        'recebimento_id',
        'operacao',
        'valor_cobranca',
        'valor_pago',
    ];

    public function getNameSendQueue()
    {
        return 'operacao.' . $this->operacao;
    }

    public function retorno()
    {
        return $this->belongsTo(Retorno::class);
    }

    public function sendQueue()
    {
        $obj = $this->toArray();

        return $obj + [
            'nomearquivo' => $this->retorno->banco_id . '/' . $this->retorno->nomearquivo,
            'hashfile' => sha1($this->retorno->nomearquivo . $this->id),
            'banco_id' => $this->retorno->banco_id
        ];
    }
}
