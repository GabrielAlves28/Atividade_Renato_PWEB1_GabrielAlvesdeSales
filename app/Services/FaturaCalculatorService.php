<?php

namespace App\Services;

use App\Models\ConfiguracaoTaxa;

/**
 * Responsável exclusivamente pelo cálculo do valor de uma fatura.
 * Aplica o princípio de Single Responsibility (SOLID).
 */
class FaturaCalculatorService
{
    /**
     * Calcula o valor total da fatura com base no consumo em m³ e nas taxas configuradas.
     *
     * @param float $consumoM3 Consumo em metros cúbicos no período.
     * @return float Valor total calculado da fatura.
     */
    public function calcular(float $consumoM3): float
    {
        $taxa = ConfiguracaoTaxa::first();

        $valorTotal = $taxa->taxa_fixa;

        if ($consumoM3 > 10) {
            $valorTotal += (($consumoM3 - 10) * $taxa->valor_excedente);
        }

        return $valorTotal;
    }
}
