<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 14:05
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsMenu;
use App\adms\Models\AdmsVerUsuario;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class VerUsuario
{

    private $Dados;
    private $DadosId;

    public function verUsuario($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        //echo $this->DadosId;
        if (!empty($this->DadosId)) {

            $verUsuario = new AdmsVerUsuario();
            $this->Dados['dados_usuario'] = $verUsuario->verUsuario($this->DadosId);

            $botao = ['list_usuario' => ['menu_controller' => 'usuarios', 'menu_metodo' => 'listar'],
                'edit_usuario' => ['menu_controller' => 'editar-usuario', 'menu_metodo' => 'edit-usuario'],
                'edit_senha' => ['menu_controller' => 'editar-senha', 'menu_metodo' => 'edit-senha'],
                'del_usuario' => ['menu_controller' => 'apagar-usuario', 'menu_metodo' => 'apagar-usuario']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new ConfigView('adms/Views/usuario/verUsuario', $this->Dados);
            $carregarView->renderizar();

        } else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Usuário não encontrado!","danger");
            $UrlDestino = URLADM . 'usuarios/listar';
            header("Location: $UrlDestino");

        }


    }

}