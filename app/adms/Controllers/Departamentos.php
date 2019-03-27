<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 25/03/2019
 * Time: 12:17
 */

namespace App\adms\Controllers;

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
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);


        $listarDpt = new \App\adms\Models\AdmsListarDepartamentos();
        $this->Dados['listarDepartamentos'] = $listarDpt->listar();


        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $carregarView = new \Core\ConfigView("adms/Views/departamento/listarDepartamentos", $this->Dados);
        $carregarView->renderizar();
    }

}