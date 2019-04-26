<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 27/01/2019
 * Time: 12:44
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsApagarUsuario;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class ApagarUsuario
{
    private $DadosId;

    public function apagarUsuario($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId))
        {

            $apagarUsuario = new AdmsApagarUsuario();
            $apagarUsuario->apagarUsuario($this->DadosId);

        }
        else {

            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessario selecionar um usuário!</div>";
            $this->Resultado = false;

        }
        $UrlDestino = URLADM .'usuarios/listar';
        header("Location: $UrlDestino");
    }

}