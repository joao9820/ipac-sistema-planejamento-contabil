<?php

namespace App\adms\Controllers;

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
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarFunc = new \App\adms\Models\AdmsListarJorTrabFunc();
        $this->Dados['listFuncionarios'] = $listarFunc->listarFuncionarios();

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        
        $carregarView = new \Core\ConfigView("adms/Views/gerenciar/listarJornadaDeTrabalhoFuncionario", $this->Dados);
        $carregarView->renderizar();
    }

}
