<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 27/01/2019
 * Time: 12:44
 */

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class ApagarDemanda
{
    private $DadosId;

    public function apagarDemanda($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId))
        {

            $apagarDemanda = new \App\adms\Models\AdmsApagarDemanda();
            $apagarDemanda->apagarDemanda($this->DadosId);

        }
        else {

            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessario selecionar uma demanda!</div>";
            $this->Resultado = false;

        }
        $UrlDestino = URLADM .'demandas/listar';
        header("Location: $UrlDestino");
    }

}