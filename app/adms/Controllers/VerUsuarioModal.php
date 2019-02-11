<?php

namespace App\adms\Controllers;

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
            $verUsuario = new \App\adms\Models\AdmsVerUsuario();
            $this->Dados['dados_usuario'] = $verUsuario->verUsuario($this->DadosId);

            $carregarView = new \Core\ConfigView("adms/Views/usuario/verUsuarioModal", $this->Dados);
            $carregarView->renderizarListar();
        }
    }




}
