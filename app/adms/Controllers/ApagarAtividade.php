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

class ApagarAtividade
{
    private $DadosId;
    private $Dados;
    private $DadosIdDemanda;

    public function apagarAtividade($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;

        $this->Dados = (int) $DadosId;
        $dadosAtividade = new \App\adms\Models\helper\AdmsRead();
        $dadosAtividade->fullRead("SELECT adms_demanda_id FROM adms_atividades WHERE id =:id LIMIT :limit","id={$this->Dados}&limit=1");
        $this->Dados = $dadosAtividade->getResultado();

        if (!empty($this->DadosId))
        {

            $apagarAtividade = new \App\adms\Models\AdmsApagarAtividade();
            $apagarAtividade->apagarAtividade($this->DadosId);

        }
        else {

            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessario selecionar uma atividade!</div>";
            $this->Resultado = false;

        }

        //var_dump($this->Dados);
        $this->DadosIdDemanda = $this->Dados[0]['adms_demanda_id'];
        //echo $this->DadosIdDemanda;
        $UrlDestino = URLADM .'ver-demanda/ver-demanda/'.$this->DadosIdDemanda;
        header("Location: $UrlDestino");
    }

}