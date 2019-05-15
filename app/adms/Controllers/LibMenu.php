<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 01/02/2019
 * Time: 14:53
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsLibMenu;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class LibMenu
{
    private $DadosId;
    private $NivId;
    private $PageId;

    public function libMenu($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->NivId = filter_input(INPUT_GET, "niv", FILTER_SANITIZE_NUMBER_INT);
        $this->PageId = filter_input(INPUT_GET, "pg", FILTER_SANITIZE_NUMBER_INT);
        if (!empty($this->DadosId) AND ! empty($this->NivId) AND ! empty($this->PageId)) {
            $libMenu = new AdmsLibMenu();
            $libMenu->libMenu($this->DadosId);
            $UrlDestino = URLADM . "permissoes/listar/{$this->PageId}?niv={$this->NivId}";
            header("Location: $UrlDestino");
        } else {
            $UrlDestino = URLADM . 'nivel-acesso/listar';
            header("Location: $UrlDestino");
        }
    }


}