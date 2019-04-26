<?php

namespace App\adms\Controllers;

use \Core\ConfigView;

use \App\adms\Models\AdmsBotao;
use \App\adms\Models\AdmsMenu;
use \App\adms\Models\AdmsListarJorTrabFunc;


if (!defined('URL')) {
    header("Location: /");
    exit();
}

class JornadaDeTrabalho
{

    private $Dados;

    public function listar()
    {
        //Array botoes
        $botao = ['editar_jornada' => ['menu_controller' => 'editar-jornada-de-trabalho', 'menu_metodo' => 'editar'],
            'cad_usuario' => ['menu_controller' => 'cadastrar-usuario', 'menu_metodo' => 'cad-usuario']];
        //var_dump($botao);
        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarFunc = new AdmsListarJorTrabFunc();
        $this->Dados['listFuncionarios'] = $listarFunc->listarFuncionarios();

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        
        $carregarView = new ConfigView("adms/Views/gerenciar/listarJornadaDeTrabalhoFuncionario", $this->Dados);
        $carregarView->renderizar();
    }

}
