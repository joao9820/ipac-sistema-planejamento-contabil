<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 02/02/2019
 * Time: 20:03
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsSincroPgNivAc;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class SincroPgNivAc
{

    public function sincroPgNivAc()
    {
        $sincroPgNivAc = new AdmsSincroPgNivAc();
        $sincroPgNivAc->sincroPgNivAc();
        $UrlDestino = URLADM . "nivel-acesso/listar";
        header("Location: $UrlDestino");
    }

}