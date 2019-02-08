<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 02/02/2019
 * Time: 20:03
 */

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class SincroPgNivAc
{

    public function sincroPgNivAc()
    {
        $sincroPgNivAc = new \App\adms\Models\AdmsSincroPgNivAc();
        $sincroPgNivAc->sincroPgNivAc();
        $UrlDestino = URLADM . "nivel-acesso/listar";
        header("Location: $UrlDestino");
    }

}