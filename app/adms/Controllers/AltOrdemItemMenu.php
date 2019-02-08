<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 01:28
 */

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AltOrdemItemMenu
{

    private $DadosId;

    public function altOrdemItemMenu($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $altOrdemMenu = new \App\adms\Models\AdmsAltOrdemItemMenu();
            $altOrdemMenu->altOrdemMenu($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um item de menu!</div>";
        }
        $UrlDestino = URLADM . 'menu/listar';
        header("Location: $UrlDestino");
    }

}