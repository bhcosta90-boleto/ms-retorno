<?php

namespace App\Services;

use App\Models\Retorno as Model;
use PJBank\Package\Services\ValidateTrait;

final class RetornoService
{
    use ValidateTrait;

    public function __construct(private Model $repository)
    {
    }

    public function cadastrarRetorno($data)
    {
        $ret = [];

        $bancoId = $data['banco_id'] ?? 'a';

        $dataRetorno = $this->validate($data, [
            'nome' => "required|min:1|max:150|unique:retornos,nomearquivo,null,null,banco_id,{$bancoId}",
            'banco_id' => 'required|uuid',
            'cobrancas' => 'required|array|min:1',
            'cobrancas.*.id' => 'required|numeric|min:1',
            'cobrancas.*.operacao' => 'required|string|min:1|max:3',
            'cobrancas.*.valor' => 'required|numeric|min:0.01',
            'cobrancas.*.valor_pago' => 'required|numeric|min:0.01',
        ]);

        $ret = $this->repository->create($dataRetorno + [
            'nomearquivo' => $dataRetorno['nome'],
        ]);

        foreach ($dataRetorno['cobrancas'] as $rs) {
            $this->getRetornoItemService()->store($rs + [
                'retorno_id' => $ret->id,
                'recebimento_id' => $rs['id'],
                'valor_cobranca' => $rs['valor'],
            ]);
        }

        return $ret;
    }

    private function getRetornoItemService(): RetornoItemService
    {
        return app(RetornoItemService::class);
    }
}
