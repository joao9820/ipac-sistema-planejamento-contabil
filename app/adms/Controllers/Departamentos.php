<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 25/03/2019
 * Time: 12:17
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsListarDepartamentos;
use App\adms\Models\AdmsMenu;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class Departamentos
{
    private $Dados;

    public function listar()
    {
        //Array botoes
        $botao = ['editar_dept' => ['menu_controller' => 'editar-departamento', 'menu_metodo' => 'editar'],
            'cad_usuario' => ['menu_controller' => 'cadastrar-usuario', 'menu_metodo' => 'cad-usuario']];
        //var_dump($botao);
        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);


        $listarDpt = new AdmsListarDepartamentos();
        $this->Dados['listarDepartamentos'] = $listarDpt->listar();


        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $carregarView = new ConfigView("adms/Views/departamento/listarDepartamentos", $this->Dados);
        $carregarView->renderizar();
    }

}