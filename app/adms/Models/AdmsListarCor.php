<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 13:46
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsPaginacao;
use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsListarCor
{

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg()
    {
        return $this->ResultadoPg;
    }


    public function listarCor($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new AdmsPaginacao(URLADM . 'cor/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_cors", "ordem=".$_SESSION['ordem_nivac']);
        $this->ResultadoPg = $paginacao->getResultado();

        $listarCor = new AdmsRead();
        $listarCor->fullRead("SELECT id, nome, cor FROM adms_cors ORDER BY id ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarCor->getResultado();
        return $this->Resultado;
    }

}