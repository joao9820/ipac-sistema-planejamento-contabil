<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsApagarPagina;
use App\adms\Models\helper\AdmsAlertMensagem;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarNivAc
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class ApagarPagina
{

    private $DadosId;

    public function apagarPagina($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
           $apagarPagina = new AdmsApagarPagina();
           $apagarPagina->apagarPagina($this->DadosId);
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Necessário selecionar uma página!", "danger");
            $UrlDestino = URLADM . 'pagina/listar';
            header("Location: $UrlDestino");
        }
    }

}

