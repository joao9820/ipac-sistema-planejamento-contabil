<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 26/02/2019
 * Time: 16:35
 */

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsArtigos
{

    private $Resultado;


    public function visualizarArtigo()
    {

        $visualizarArt = new \App\adms\Models\helper\AdmsRead();
        $visualizarArt->fullRead('SELECT id, titulo, conteudo, descricao, imagem FROM sts_artigos 
                ORDER BY id DESC
                LIMIT :limit', "limit=4");
        $this->Resultado = $visualizarArt->getResultado();
        return $this->Resultado;
    }

}