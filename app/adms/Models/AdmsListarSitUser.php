<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 16:17
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsPaginacao;
use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsListarSitUser
{

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 40;
    private $ResultadoPg;

    function getResultadoPg()
    {
        return $this->ResultadoPg;
    }


    public function listarSitUser($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new AdmsPaginacao(URLADM . 'situacao-user/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_sits_usuarios");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarSitUser = new AdmsRead();
        $listarSitUser->fullRead("SELECT sit.*,
                cr.cor cor_cr
                FROM adms_sits_usuarios sit 
                INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id
                ORDER BY sit.nome ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarSitUser->getResultado();
        return $this->Resultado;
    }

}