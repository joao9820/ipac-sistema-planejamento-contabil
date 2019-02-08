<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 01/02/2019
 * Time: 22:11
 */

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AltOrdemMenu
{

    private $DadosId;
    private $NivId;
    private $PageId;

    public function altOrdemMenu($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        $this->NivId = filter_input(INPUT_GET, "niv", FILTER_SANITIZE_NUMBER_INT);
        $this->PageId = filter_input(INPUT_GET, "pg", FILTER_SANITIZE_NUMBER_INT);
        if (!empty($this->DadosId) AND ! empty($this->NivId) AND ! empty($this->PageId)) {
            $altOrdemMenu = new \App\adms\Models\AdmsAltOrdemMenu();
            $altOrdemMenu->altOrdemMenu($this->DadosId);
            $UrlDestino = URLADM . "permissoes/listar/{$this->PageId}?niv={$this->NivId}";
            header("Location: $UrlDestino");
        } else {
            $UrlDestino = URLADM . 'nivel-acesso/listar';
            header("Location: $UrlDestino");
        }

    }

}