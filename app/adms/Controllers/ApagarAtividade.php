<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 27/01/2019
 * Time: 12:44
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsApagarAtividade;
use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsRead;

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
        $dadosAtividade = new AdmsRead();
        $dadosAtividade->fullRead("SELECT adms_demanda_id FROM adms_atividades WHERE id =:id LIMIT :limit","id={$this->Dados}&limit=1");
        $this->Dados = $dadosAtividade->getResultado();

        if (!empty($this->DadosId))
        {

            $apagarAtividade = new AdmsApagarAtividade();
            $apagarAtividade->apagarAtividade($this->DadosId);

        }
        else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Necessario selecionar uma demanda!","danger");

        }

        //var_dump($this->Dados);
        $this->DadosIdDemanda = $this->Dados[0]['adms_demanda_id'];
        //echo $this->DadosIdDemanda;
        $UrlDestino = URLADM .'ver-demanda/ver-demanda/'.$this->DadosIdDemanda;
        header("Location: $UrlDestino");
    }

}