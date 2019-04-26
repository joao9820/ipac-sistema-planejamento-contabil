<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarCarousel
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class ApagarCarousel
{

    private $DadosId;

    public function apagarCarousel($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
           $apagarCarousel = new \App\sts\Models\StsApagarCarousel();
           $apagarCarousel->apagarCarousel($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um slide do carousel!</div>";
        }
        $UrlDestino = URLADM . 'carousel/listar';
        header("Location: $UrlDestino");
    }

}
