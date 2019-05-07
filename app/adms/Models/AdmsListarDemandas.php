<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 25/01/2019
 * Time: 16:56
 */

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsListarDemandas
{
    private $Resultado;
    private $PageId;
    private $LimiteResultado = 30; // Define a quantidade de registro por páginas
    private $ResultadoPg;


    public function getResultadoPg()
    {
        return $this->ResultadoPg;
    }



    public function listarDemandas($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'demandas/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result
                     FROM adms_demandas");
        $this->ResultadoPg = $paginacao->getResultado();
        $offset = $paginacao->getOffset();


        $listarDemandas = new \App\adms\Models\helper\AdmsRead();
        $listarDemandas->fullRead("SELECT dem.id, dem.nome, dem.descricao, ativ.duracao_total_atividade
                    FROM adms_demandas dem
                    LEFT JOIN (SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(duracao))) as duracao_total_atividade, adms_demanda_id FROM adms_atividades GROUP BY adms_demanda_id) ativ ON ativ.adms_demanda_id = dem.id
                    ORDER BY dem.nome ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$offset}");
        $this->Resultado = $listarDemandas->getResultado();
        //var_dump($this->Resultado);
        return $this->Resultado;
    }


}