<?php

/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 08/04/2019
 * Time: 13:19
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsAtendimentoFuncionarioEditar;
use App\adms\Models\AdmsAtendimentoFuncionariosApagar;
use App\adms\Models\AdmsListarAtendGerente;
use Core\ConfigView;
use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsMenu;
use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\AdmsAtendimentoFuncionarios;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AtendimentoFuncionarios {

    private $Dados;
    private $Condicao;
    private $DadosForm;
    private $DadosId;
    private $DemandaId;
    private $data;
    private $AtendimentoId;

    public function listar($DadosId = null) {

        $this->DadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $atenId = $this->DadosForm['adms_atendimento_id'];
        $demandaId = $this->DadosForm['adms_demanda_id'];


        if (!empty($this->DadosForm)) {

            if (!empty($this->DadosForm['Registrar'])) {
                unset($this->DadosForm['Registrar']);

                $registrar = new AdmsAtendimentoFuncionarios();
                $registrar->registrar($this->DadosForm);
                //$this->data = date('d-m-Y', strtotime($this->DadosForm['data_inicio_planejado'])); //Necessário para inserir na sessão (convertendo o formato de exibição)
                // condição caso registre está dentro do método abaixo
                //$this->mensagemAlerta($registrar->getResultado(), $registrar->comparaJornada());
            }
        }

        $atendimento_id = filter_input(INPUT_GET, 'aten', FILTER_DEFAULT);
        $paginaAtendimentos = filter_input(INPUT_GET, 'pg', FILTER_DEFAULT);
        $this->Dados['pg'] = $paginaAtendimentos;

        $this->DadosId = (int) $DadosId;
        if (empty($this->DadosId) or empty($atendimento_id)) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Não foi possível buscar os funcionário do atendimento selecionado.","danger");
            $UrlDestino = URLADM . 'gerenciar-atendimento/listar/'.$paginaAtendimentos;
            header("Location: $UrlDestino");
        }

        //Array botoes
        $botao = ['em_andamento' => ['menu_controller' => 'atendimento-em-andamento', 'menu_metodo' => 'listar'],
            'vis' => ['menu_controller' => 'funcionario-ver-atendimento', 'menu_metodo' => 'ver'],
            'edit' => ['menu_controller' => 'funcionario-editar-atendimento', 'menu_metodo' => 'edit'],
            'conclu' => ['menu_controller' => 'func-concluir-atendimento', 'menu_metodo' => 'concluir']];
        //var_dump($botao);
        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        // Buscando dados do atendimeto
        $dadosAtendimento = new AdmsListarAtendGerente();
        $this->Dados['dadosAtendimento'] = $dadosAtendimento->BuscarDadosDoAtendimento($atendimento_id);

        $atendFunc = new AdmsAtendimentoFuncionarios();
        $atendFunc->listarFuncionarios();
        $this->Dados['funcionarios'] = $atendFunc->getResultado();

        $atendFunc->listarAtividadesDemanda($this->DadosId, $atendimento_id);
        $this->Dados['atividades'] = $atendFunc->getResultado();

        $atendFunc->listar($atendimento_id);
        $this->Dados['listarAtenFunc'] = $atendFunc->getResultado();

        $atendFunc->buscarDuracaoMinAtv($atendimento_id);
        $this->Dados['duracao_minAtv'] = $atendFunc->getResultado();

        $this->Dados['adms_demanda_id'] = $this->DadosId;
        $this->Dados['adms_atendimento_id'] = $atendimento_id;


        $carregarView = new ConfigView("adms/Views/gerenciar/funcionarios/atendimentoFuncionarios", $this->Dados);
        $carregarView->renderizar();
    }

    /**
     * @param null $DemandaId
     */
    public function excluir($DemandaId = null) {
        $this->DemandaId = (int) $DemandaId;
        $aten_id = filter_input(INPUT_GET, 'aten_id', FILTER_SANITIZE_NUMBER_INT);
        $func_id = filter_input(INPUT_GET, 'func_id', FILTER_SANITIZE_NUMBER_INT);
        $ativ_id = filter_input(INPUT_GET, 'ativ_id', FILTER_SANITIZE_NUMBER_INT);
        $id_aten_fun = filter_input(INPUT_GET, 'id_aten_fun', FILTER_SANITIZE_NUMBER_INT);
        $paginaAtendimentos = filter_input(INPUT_GET, 'pg', FILTER_DEFAULT);


        if (!empty($aten_id) and ! empty($func_id) and ! empty($ativ_id)) {

            $alert = new AdmsAlertMensagem();

            $excluAtendFunc = new AdmsAtendimentoFuncionariosApagar();
            $excluAtendFunc->excluirFuncionario($aten_id, $func_id, $ativ_id, $id_aten_fun);
            if ($excluAtendFunc->getResultado()) {
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Registro deletado com sucesso!", "success");
            } else {
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Registro não deletado.", "danger");
            }
            $UrlDestino = URLADM . 'atendimento-funcionarios/listar/' . $this->DemandaId . '?aten=' . $aten_id.'&pg='.$paginaAtendimentos;
            header("Location: $UrlDestino");
        }
    }

    public function verPlanejamento($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $aten_id = filter_input(INPUT_GET, 'aten', FILTER_DEFAULT);
        $func_id = filter_input(INPUT_GET, 'func', FILTER_DEFAULT);
        $data = filter_input(INPUT_GET, 'data', FILTER_DEFAULT);
        $paginaAtendimentos = filter_input(INPUT_GET, 'pg', FILTER_DEFAULT);
        $this->Dados['pg'] = $paginaAtendimentos;

        if (!empty($aten_id) and ! empty($func_id) and ! empty($data)) {

            //Array botoes
            $botao = ['em_andamento' => ['menu_controller' => 'atendimento-em-andamento', 'menu_metodo' => 'listar'],
                'vis' => ['menu_controller' => 'funcionario-ver-atendimento', 'menu_metodo' => 'ver'],
                'edit' => ['menu_controller' => 'funcionario-editar-atendimento', 'menu_metodo' => 'edit'],
                'conclu' => ['menu_controller' => 'func-concluir-atendimento', 'menu_metodo' => 'concluir']];
            //var_dump($botao);
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();


            $verPlan = new AdmsAtendimentoFuncionarios();
            $verPlan->verPlanejamentoFuncionario($func_id, $data);
            $this->Dados['verPlanFunc'] = $verPlan->getResultado();
            $verPlan->funcionarioPlanejamento($func_id);
            $this->Dados['funcionarioPlan'] = $verPlan->getResultado();
            $verPlan->jornadaTrabalho($func_id, $data);
            $this->Dados['jornadaTrabalho'] = $verPlan->getResultado();
            $verPlan->atividadeDuracao($func_id, $data);
            $this->Dados['atividadesDuracao'] = $verPlan->getResultado();


            $carregarView = new ConfigView("adms/Views/gerenciar/funcionarios/verPlanejamentoFuncionario", $this->Dados);
            $carregarView->renderizar();
        } else {
            $UrlDestino = URLADM . 'atendimento-funcionarios/listar/' . $this->DadosId . '?aten=' . $aten_id.'&pg='.$paginaAtendimentos;
            header("Location: $UrlDestino");
        }
    }

    private function mensagemAlerta($resultado, $resultadoJornada) {

        if ($resultado) {
            $alert = new AdmsAlertMensagem();
            if ($resultadoJornada['status']) { //Se for true inseriu e ainda não ultrapassou a jornada do funcionário
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Registro concluido", "success");
            } else {
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("A Atividade foi registrada no dia {$resultadoJornada['novaData']}", "warning");
            }
        }
    }

    public function editar($Pagina)
    {
        $pagina = (int) $Pagina;
        /*
         * Arry contendo:
         * verificar_mesmo_funcionario <- caso seja igual ao adms_funcionario_id, nada será atualizado
         * adms_atividade_id <- id da atividade
         * adms_demanda_id <- id da demanda
         * adms_atendimento_id <- id do atendimento
         * adms_funcionario_id <- id do funcionário
         * prioridade <- 1 [Sim] , 2 [Não]
         */
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        var_dump($this->Dados);
        //die();
        
        $adms_demanda_id = $this->Dados['adms_demanda_id'];
        $adms_atendimento_id = $this->Dados['adms_atendimento_id'];

        $alert = new AdmsAlertMensagem(); // Estanciando objeto para exibir alertas

        if (isset($this->Dados['EditAtividade'])) {
            unset($this->Dados['EditAtividade']);

            if ($this->Dados['verificar_mesmo_funcionario'] == $this->Dados['adms_funcionario_id'] && $this->Dados['prioridade'] == 2) { //Ou seja se tentar editar pro mesmo funcionário sem definir prioridade

                // Caso o funcionário não seja substituido e a prioridade continue a mesma nada será atualizado
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Nenhum dado atualizado", "warning");
                $UrlDestino = URLADM . 'atendimento-funcionarios/listar/' . $adms_demanda_id . '?aten=' . $adms_atendimento_id.'&pg='.$pagina;
                header("Location: $UrlDestino");
            } else {
                $this->Condicao['adms_atividade_id'] = $this->Dados['adms_atividade_id'];
                unset($this->Dados['adms_atividade_id']);
                $this->Condicao['id_aten_fun'] = $this->Dados['id_aten_fun'];
                unset($this->Dados['id_aten_fun']);
                $this->Condicao['adms_demanda_id'] = $this->Dados['adms_demanda_id'];
                unset($this->Dados['adms_demanda_id']);
                $this->Condicao['adms_atendimento_id'] = $this->Dados['adms_atendimento_id'];
                unset($this->Dados['adms_atendimento_id']);
                $this->Condicao['adms_funcionario_id'] = $this->Dados['adms_funcionario_id'];
       
                $this->Condicao['adms_funcionario_id_ant'] = $this->Dados['verificar_mesmo_funcionario']; //Verificar o funcionário antigo para deletar o registro e mover para o outro
                
                unset($this->Dados['verificar_mesmo_funcionario']); // Retirando do array o funcionário antigo
                
                $upAtividade = new AdmsAtendimentoFuncionarioEditar();
                $upAtividade->setAtividade($this->Dados, $this->Condicao); //A prioridade está inclusa
                // Receber um array de dados contendo o status
                if ($upAtividade->getAtividade()['status']) { // Se o status for true então a condição será verdadeira
                    $_SESSION['msg'] = $alert->alertMensagemJavaScript($upAtividade->getAtividade()['msg'], "success");
                    $UrlDestino = URLADM . 'atendimento-funcionarios/listar/' . $adms_demanda_id . '?aten=' . $adms_atendimento_id.'&pg='.$pagina;
                    header("Location: $UrlDestino");
                } else {
                    $_SESSION['msg'] = $alert->alertMensagemJavaScript($upAtividade->getAtividade()['msg'], "danger");
                    $UrlDestino = URLADM . 'atendimento-funcionarios/listar/' . $adms_demanda_id . '?aten=' . $adms_atendimento_id.'&pg='.$pagina;
                    header("Location: $UrlDestino");
                }
            }
        }
    }

}
