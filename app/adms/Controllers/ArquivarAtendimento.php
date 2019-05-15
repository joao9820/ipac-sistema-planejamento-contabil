<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 04/02/2019
 * Time: 12:15
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsArquivarAtendimento;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class ArquivarAtendimento
{

    private $DadosId;
    private $PageId;

    public function arquivar($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        $this->PageId = filter_input(INPUT_GET, "pg",FILTER_SANITIZE_NUMBER_INT);
        if (!empty($this->DadosId) AND !empty($this->PageId))
        {
            $cancelar = new AdmsArquivarAtendimento();
            $cancelar->arquivar($this->DadosId);
            $UrlDestino = URLADM . "atendimento/listar/{$this->PageId}";
            header("Location: $UrlDestino");
        } else {
            $UrlDestino = URLADM . 'atendimento/listar';
            header("Location: $UrlDestino");
        }
    }

}