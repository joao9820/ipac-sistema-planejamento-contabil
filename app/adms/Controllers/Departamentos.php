<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 25/03/2019
 * Time: 12:17
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsDepartamentos;
use App\adms\Models\AdmsListarGerentes;
use App\adms\Models\AdmsMenu;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;
use http\Client\Request;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class Departamentos
{
    private $Dados;

    /*
     * Listar departamentos
     */
    public function listar()
    {
        //Array botoes
        $botao = ['editar_dept' => ['menu_controller' => 'editar-departamento', 'menu_metodo' => 'editar'],
            'cad_usuario' => ['menu_controller' => 'cadastrar-usuario', 'menu_metodo' => 'cad-usuario']];
        //var_dump($botao);
        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarDpt = new AdmsDepartamentos();
        $this->Dados['listarDepartamentos'] = $listarDpt->listar();

        $listaDeGerentes = new AdmsListarGerentes();
        $this->Dados['listaDeGerentes'] = $listaDeGerentes->getResultado();


        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $carregarView = new ConfigView("adms/Views/departamentos/listarDepartamentos", $this->Dados);
        $carregarView->renderizar();
    }

    /*
     * Exibir página de cadastro
     */
    /*
    public function cadastrar(){

        $listarDpt = new AdmsDepartamentos();
        $this->Dados['listarDepartamentos'] = $listarDpt->listar();


        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $carregarView = new ConfigView("adms/Views/departamentos/listarDepartamentos", $this->Dados);
        $carregarView->renderizar();

    }
    */

    /*
     * Cadastrar departamento
     */
    public function store(){
        $request = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (empty($request)){
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Formulário vazio! Nenhum departamento foi cadastrado.","warning");
            $UrlDestino = URLADM . 'departamentos/listar';
            header("Location: $UrlDestino");
        }
        var_dump($request);
    }

}