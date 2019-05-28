<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 09/05/2019
 * Time: 12:38
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsAlocacaoFuncionario;
use App\adms\Models\AdmsAlocacaoFuncionarioData;
use App\adms\Models\AdmsAlocacaoFuncionariosGerente;
use App\adms\Models\AdmsAlocacaoGerentes;
use App\adms\Models\AdmsMenu;
use App\adms\Models\funcoes\Funcoes;
use App\adms\Models\funcoes\ValidarTipoDeUsuario;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class Alocacao
{

    private $Dados;
    private $DataInicio;
    private $DataFim;

    // Index da alocação, mostrar todos os gerentes
    public function listar()
    {

        $alocacaoGerentes = new AdmsAlocacaoGerentes();
        $dadosGerentes = $alocacaoGerentes->getGerentes();

        if($dadosGerentes){
            $this->Dados['gerentes'] = $dadosGerentes;
        } else {
            $this->Dados['gerentes'] = "";
        }

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();


        $carregarView = new ConfigView("adms/Views/alocacao/index", $this->Dados);
        $carregarView->renderizar();
    }


    // Index alocação do gerente, mostrar todos os funcionários
    public function gerente($GerenteId = null)
    {

        // Verificar se o id informado pertence a um gerente
        $verificar = new ValidarTipoDeUsuario("Gerente", $GerenteId);
        if (!$verificar->getResultado()){
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Gerente não encontrado!", "danger");
            $UrlDestino = URLADM . 'alocacao/listar';
            header("Location: $UrlDestino");
        } else {

            $DataInicio = filter_input(INPUT_GET, "data_inicio", FILTER_DEFAULT);
            $DataFim = filter_input(INPUT_GET, "data_fim", FILTER_DEFAULT);
            if (empty($DataInicio)) {
                $novaData = new Funcoes();
                $this->DataInicio = date('Y-m-d');
                $this->DataFim = $novaData->dia_in_data(date('Y-m-d'),7);
            } else {
                $this->DataInicio = date('Y-m-d', strtotime($DataInicio));
                $this->DataFim = date('Y-m-d', strtotime($DataFim));
            }

            $alocacao = new AdmsAlocacaoFuncionariosGerente($GerenteId, $this->DataInicio, $this->DataFim);
            $this->Dados['alocacao'] = $alocacao->getDadosAlocacao();

            $this->Dados['DataInicio'] = $this->DataInicio;
            $this->Dados['DataFim'] = $this->DataFim;

            $this->Dados['gerente'] = $verificar->getResultado()[0];

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();


            $carregarView = new ConfigView("adms/Views/alocacao/gerente/index", $this->Dados);
            $carregarView->renderizar();
        }
    }


    // Index alocação do funcionário, mostrar todas as atividades
    public function funcionario($FuncionarioId = null)
    {
        $GerenteId = filter_input(INPUT_GET, 'gerente', FILTER_DEFAULT);
        $DataInicio = filter_input(INPUT_GET, "data_inicio", FILTER_DEFAULT);
        $DataFim = filter_input(INPUT_GET, "data_fim", FILTER_DEFAULT);
        if (empty($DataInicio)) {
            $novaData = new Funcoes();
            $this->DataInicio = date('Y-m-d');
            $this->DataFim = $novaData->dia_in_data(date('Y-m-d'),7);
        } else {
            $this->DataInicio = date('Y-m-d', strtotime($DataInicio));
            $this->DataFim = date('Y-m-d', strtotime($DataFim));
        }

        // Verificar se o id informado pertence a um funcionário
        $verificar = new ValidarTipoDeUsuario("Funcionario", $FuncionarioId);
        if (!$verificar->getResultado()){
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Funcionário não encontrado!", "danger");
            $UrlDestino = URLADM . 'alocacao/gerente/' . $GerenteId;
            header("Location: $UrlDestino");
        } else {

            $this->Dados['funcionario'] = $verificar->getResultado()[0];

            $alocacaoFuncionario = new AdmsAlocacaoFuncionario($FuncionarioId, $this->DataInicio, $this->DataFim);
            $this->Dados['alocacao'] = $alocacaoFuncionario->getDadosAlocacao();

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();


            $carregarView = new ConfigView("adms/Views/alocacao/gerente/funcionario/index", $this->Dados);
            $carregarView->renderizar();
        }
    }

    public function funcionarioData($FuncionarioId = null)
    {

        $Funcionario = $FuncionarioId;
        $GerenteId = filter_input(INPUT_GET, 'gerente', FILTER_DEFAULT);
        $DataInicio = filter_input(INPUT_GET, "data_inicio", FILTER_DEFAULT);
        $Data = filter_input(INPUT_GET, "data", FILTER_DEFAULT);
        $DataFim = filter_input(INPUT_GET, "data_fim", FILTER_DEFAULT);

        $this->Dados['url']['gerente'] = $GerenteId;
        $this->Dados['url']['data_inicio'] = $DataInicio;
        $this->Dados['url']['data_fim'] = $DataFim;
        $this->Dados['url']['funcionario'] = $FuncionarioId;

        $DataAlocacao = isset($DataAlocacao) ? $DataAlocacao : date('Y-m-d');

        $alocacaoFuncionarioData = new AdmsAlocacaoFuncionarioData($FuncionarioId, $Data);
        $this->Dados['alocacao'] = $alocacaoFuncionarioData->getDadosAlocacao();
        $this->Dados['funcionarioNome'] = $alocacaoFuncionarioData->getNomeFuncionario();
        $this->Dados['percentual_alocacao'] = $alocacaoFuncionarioData->getAlocacaoAtividades();

        //$alocacaoFuncionario = new AdmsAlocacaoFuncionario($FuncionarioId, $this->DataInicio, $this->DataFim);
        //$this->Dados['alocacao'] = $alocacaoFuncionario->getDadosAlocacao();

        $this->Dados['dataFiltro'] = $Data;

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();


        $carregarView = new ConfigView("adms/Views/alocacao/gerente/funcionario/listarAtividadesData", $this->Dados);
        $carregarView->renderizar();

    }

}