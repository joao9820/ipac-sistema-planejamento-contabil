<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 15:05
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsCadastrarUsuario;
use App\adms\Models\AdmsMenu;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class CadastrarUsuario
{

    private $Dados;

    public function cadUsuario()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->Dados['CadUsuario']))
        {

            unset($this->Dados['CadUsuario']);
            //var_dump($this->Dados);
            $this->Dados['imagem_nova'] = ($_FILES['imagem_nova'] ? $_FILES['imagem_nova'] : null);
            $cadUsuario = new AdmsCadastrarUsuario();
            $cadUsuario->cadUsuario($this->Dados);
            if ($cadUsuario->getResultado())
            {

                $UrlDestino = URLADM .'usuarios/listar';
                header("Location: $UrlDestino");

            }
            else {

                $this->Dados['form'] = $this->Dados;

                $this->cadUsuarioViewPriv();

            }

        } else {

            $this->cadUsuarioViewPriv();

        }

    }


    private function cadUsuarioViewPriv()
    {
        //Dados do Select
        $listarSelect = new AdmsCadastrarUsuario();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $botao = ['list_usuario' => ['menu_controller' => 'usuarios', 'menu_metodo' => 'listar']];
        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        //Carregar Menu
        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        //Carregar a view
        $carregarView = new ConfigView("adms/Views/usuario/cadUsuario", $this->Dados);
        $carregarView->renderizar();

    }

}