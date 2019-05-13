<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsVerUsuario;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class VerUsuarioModal
{
    private $Dados;
    private $DadosId;

    public function verUsuario($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verUsuario = new AdmsVerUsuario();
            $this->Dados['dados_usuario'] = $verUsuario->verUsuario($this->DadosId);

            $carregarView = new ConfigView("adms/Views/usuario/verUsuarioModal", $this->Dados);
            $carregarView->renderizarListar();
        }
    }




}
