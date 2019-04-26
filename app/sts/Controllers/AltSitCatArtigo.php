<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AltSitCatArtigo
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class AltSitCatArtigo
{

    private $DadosId;

    public function altSitCatArtigo($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $altSitCatArtigo = new \App\sts\Models\StsAltSitCatArtigo();
            $altSitCatArtigo->altSitCatArtigo($this->DadosId);
        }

        $UrlDestino = URLADM . "cat-artigo/listar";
        header("Location: $UrlDestino");
    }

}
