<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarRobots
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class ApagarRobots
{

    private $DadosId;

    public function apagarRobots($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
           $apagarRobots = new \App\sts\Models\StsApagarRobots();
           $apagarRobots->apagarRobots($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um robots de página!</div>";
        }
        $UrlDestino = URLADM . 'robots/listar';
        header("Location: $UrlDestino");
    }

}
