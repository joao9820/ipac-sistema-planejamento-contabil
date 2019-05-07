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
        $listarDemandas->fullRead("SELECT id, nome, descricao  
                        FROM adms_demandas 
                        ORDER BY nome ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$offset}");
        $this->Resultado = $listarDemandas->getResultado();
        //var_dump($this->Resultado);
        return $this->Resultado;
    }


}