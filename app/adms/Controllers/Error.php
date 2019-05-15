<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 21/01/2019
 * Time: 14:20
 */

namespace App\adms\Controllers;

use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class Error
{
    private $Dados;

    public function erro404()
    {
        $carregarView = new ConfigView("adms/Views/error/404", $this->Dados);
        $carregarView->renderizarErro404();
    }


}