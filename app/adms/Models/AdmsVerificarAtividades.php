<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\adms\Models;

use \App\adms\Models\helper\AdmsRead;

/**
 * Description of AdmsVerificarAtividades
 *
 * @author joao.victor
 */
class AdmsVerificarAtividades {

    private $data_inicial;
    private $data_final;
    private $resultado;
    private $pageId;
    private $limiteResultado = 20;
    private $resultadoPg;
    private $Dados;
    private $query;
    private $parseString;
    private $queryDemEmp;
    private $paginacao;

    function getResultadoPg() {
        return $this->resultadoPg;
    }

    public function listarAtividades($pageId = null, array $busca = null, $data_inicial = null) {

        //Incrementar a lógica da paginação do outro método neste
        $this->pageId = (int) $pageId;

        $this->data_inicial = isset($data_inicial) ? $data_inicial : date('Y-m-d'); //no caso de a pagina esta sendo carregada sem o envio dos inputs
        //echo $this->data_inicial;
        //$dataInicial = date('Y-m-d');

        $listar = new AdmsRead();

        $this->query = "SELECT aten_func.adms_atendimento_id, aten_func.duracao_atividade, aten_func.data_fatal, aten_func.adms_funcionario_id, aten_func.data_inicio_planejado, aten_func.adms_sits_atendimentos_funcionario_id as aten_sit,
                           users.nome as nome_func, 
                           atv.nome as nome_atv ,atv.descricao, 
                           dem.nome as nome_demanda, dem.id,
                           emp.fantasia,
                           info_sit_aten.nome as nome_sit, adms_cors.cor
                           FROM adms_atendimento_funcionarios aten_func 
                           INNER JOIN adms_atividades atv ON atv.id = aten_func.adms_atividade_id 
                           INNER JOIN adms_usuarios users ON users.id = aten_func.adms_funcionario_id 
                           INNER JOIN adms_demandas dem ON aten_func.adms_demanda_id = dem.id 
                           INNER JOIN adms_sits_atendimentos_funcionario info_sit_aten ON aten_func.adms_sits_atendimentos_funcionario_id = info_sit_aten.id
                           INNER JOIN adms_cors ON info_sit_aten.adms_cor_id = adms_cors.id
                           INNER JOIN adms_atendimentos ON adms_atendimentos.id = aten_func.adms_atendimento_id
                           INNER JOIN adms_empresas emp ON emp.id = adms_atendimentos.adms_empresa_id
                           WHERE aten_func.data_inicio_planejado >= :data_inicio_planejado ";

        if ($this->verificarFiltro($busca)) {
            if (!empty($this->Dados['adms_demanda_id']) && !empty($this->Dados['adms_empresa_id'])) {
                $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . "verificar-atividades/listar", "?data_inicio={$this->data_inicial}&dem={$this->Dados['adms_demanda_id']}&emp={$this->Dados['adms_empresa_id']}");
            } else if (!empty($this->Dados['adms_demanda_id'])) {
                $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . "verificar-atividades/listar", "?data_inicio={$this->data_inicial}&dem={$this->Dados['adms_demanda_id']}");
            } else if (!empty($this->Dados['adms_empresa_id'])) {
                $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . "verificar-atividades/listar", "?data_inicio={$this->data_inicial}&emp={$this->Dados['adms_empresa_id']}");
            }

            $paginacao->condicao($this->pageId, $this->limiteResultado);
            $paginacao->paginacao("SELECT COUNT(aten_func.id) AS num_result FROM adms_atendimento_funcionarios aten_func INNER JOIN adms_atendimentos ON adms_atendimentos.id = aten_func.adms_atendimento_id
                   WHERE aten_func.data_inicio_planejado >= :data_inicial $this->queryDemEmp", "data_inicial={$this->data_inicial}&$this->parseString");
            $this->paginacao = $paginacao->getOffset();
            $this->resultadoPg = $paginacao->getResultado();
        } else {
  
            $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . "verificar-atividades/listar", "?data_inicio={$this->data_inicial}");
            $paginacao->condicao($this->pageId, $this->limiteResultado);
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_atendimento_funcionarios WHERE data_inicio_planejado >= :data_inicio_planejado", "data_inicio_planejado={$this->data_inicial}");
            $this->paginacao = $paginacao->getOffset();
            $this->resultadoPg = $paginacao->getResultado();
        }
        
        $this->query .= "ORDER BY aten_func.data_inicio_planejado ASC, users.nome ASC LIMIT :limit OFFSET :offset";

        
        //print_r($this->query);
        //var_dump($this->paginacao);
        //die();

        if (isset($this->parseString)) {
            $listar->fullRead($this->query, "limit={$this->limiteResultado}&offset={$this->paginacao}&data_inicio_planejado={$this->data_inicial}&$this->parseString");
        } else {
            $listar->fullRead($this->query, "limit={$this->limiteResultado}&offset={$this->paginacao}&data_inicio_planejado={$this->data_inicial}");
        }

        $this->resultado = $listar->getResultado();

        /*
          var_dump($this->resultado);
          die();
         */
        return $this->resultado;
    }

    public function filtrarAtividades($pageId = null, array $busca, $datas = null, $ParseString = null) {

        //var_dump($busca['dataInicial']);
        //die();

        $this->pageId = (int) $pageId;

        //echo 'Num pág' . $this->pageId;
        //die();

        $this->data_inicial = $datas['dataInicial'];
        $this->data_final = $datas['dataFinal'];

        $listar = new AdmsRead();


        $this->query = "SELECT aten_func.adms_atendimento_id, aten_func.duracao_atividade, aten_func.data_fatal, aten_func.adms_funcionario_id, aten_func.data_inicio_planejado, aten_func.adms_sits_atendimentos_funcionario_id as aten_sit,
                           users.nome as nome_func, 
                           atv.nome as nome_atv ,atv.descricao, 
                           dem.nome as nome_demanda, dem.id,
                           emp.fantasia,
                           info_sit_aten.nome as nome_sit, adms_cors.cor 
                           FROM adms_atendimento_funcionarios aten_func 
                           INNER JOIN adms_atividades atv ON atv.id = aten_func.adms_atividade_id 
                           INNER JOIN adms_usuarios users ON users.id = aten_func.adms_funcionario_id 
                           INNER JOIN adms_demandas dem ON aten_func.adms_demanda_id = dem.id
                           INNER JOIN adms_sits_atendimentos_funcionario info_sit_aten ON aten_func.adms_sits_atendimentos_funcionario_id = info_sit_aten.id
                           INNER JOIN adms_cors ON info_sit_aten.adms_cor_id = adms_cors.id 
                           INNER JOIN adms_atendimentos ON adms_atendimentos.id = aten_func.adms_atendimento_id
                           INNER JOIN adms_empresas emp ON emp.id = adms_atendimentos.adms_empresa_id
                           WHERE aten_func.data_inicio_planejado >= :data_inicial AND aten_func.data_inicio_planejado <= :data_final ";


        if ($this->verificarFiltro($busca)) { //A criação da query continua neste método, se for falso a demanda e empresa não foram definidas
            $this->gerarConstructPag();
        } else {
            $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . "verificar-atividades/listar", "?data_inicio={$this->data_inicial}&data_fim={$this->data_final}");
            $paginacao->condicao($this->pageId, $this->limiteResultado);
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_atendimento_funcionarios WHERE data_inicio_planejado >= :data_inicial AND data_inicio_planejado <= :data_final ", "data_inicial={$this->data_inicial}&data_final={$this->data_final}");
            $this->paginacao = $paginacao->getOffset();
            $this->resultadoPg = $paginacao->getResultado();
        }

        $this->query .= "ORDER BY aten_func.data_inicio_planejado ASC , users.nome ASC LIMIT :limit OFFSET :offset";

        //print_r($this->query);
        //die();
        /*  
          var_dump($this->Dados);
          echo $this->queryDemEmp;
          /*
          if(!empty($this->Dados['adms_demanda_id']) || !empty($this->Dados['adms_empresa_id'])){


          }else{

          }
         */

        //$paginacao->condicao($this->pageId, $this->limiteResultado);



        /*
          print_r($this->query);
          var_dump($this->parseString);
          die();

         */
        if (isset($this->parseString)) {
            $listar->fullRead($this->query, "limit={$this->limiteResultado}&offset={$this->paginacao}&data_inicial={$this->data_inicial}&data_final={$this->data_final}&$this->parseString");
        } else {
            $listar->fullRead($this->query, "limit={$this->limiteResultado}&offset={$this->paginacao}&data_inicial={$this->data_inicial}&data_final={$this->data_final}");
        }

        $this->resultado = $listar->getResultado();
        //var_dump($this->resultado);
        //die();
          //var_dump($this->paginacao);
        //die();

        if ($this->resultado == NULL) {
            $_SESSION['erro_filtro'] = 1;
        }

        return $this->resultado;
    }

    private function verificarFiltro(array $dados) {

        $this->Dados = $dados;

        if (!empty($this->Dados['adms_demanda_id']) || !empty($this->Dados['adms_empresa_id'])) {

            $this->queryDemEmp = '';

            foreach ($this->Dados as $key => $value) {

                if (isset($this->parseString) && !empty($this->Dados["$key"])) { //não passa pela primeira vez
                    $this->parseString .= "&";
                }

                if (!empty($this->Dados["$key"])) {

                    $this->queryDemEmp .= "AND adms_atendimentos.$key = :$key ";
                    $this->parseString .= "$key=$value";
                }
            }
            $this->query .= $this->queryDemEmp;

            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function gerarConstructPag() {

        if (!empty($this->Dados['adms_demanda_id']) && !empty($this->Dados['adms_empresa_id'])) {
            $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . "verificar-atividades/listar", "?data_inicio={$this->data_inicial}&data_fim={$this->data_final}&dem={$this->Dados['adms_demanda_id']}&emp={$this->Dados['adms_empresa_id']}");
        } else if (!empty($this->Dados['adms_demanda_id'])) {
            $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . "verificar-atividades/listar", "?data_inicio={$this->data_inicial}&data_fim={$this->data_final}&dem={$this->Dados['adms_demanda_id']}");
        } else if (!empty($this->Dados['adms_empresa_id'])) {
            $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . "verificar-atividades/listar", "?data_inicio={$this->data_inicial}&data_fim={$this->data_final}&emp={$this->Dados['adms_empresa_id']}");
        }

        $paginacao->condicao($this->pageId, $this->limiteResultado);
        $paginacao->paginacao("SELECT COUNT(aten_func.id) AS num_result FROM adms_atendimento_funcionarios aten_func INNER JOIN adms_atendimentos ON adms_atendimentos.id = aten_func.adms_atendimento_id
                   WHERE aten_func.data_inicio_planejado >= :data_inicial AND aten_func.data_inicio_planejado <= :data_final $this->queryDemEmp", "data_inicial={$this->data_inicial}&data_final={$this->data_final}&$this->parseString");
        $this->paginacao = $paginacao->getOffset();
        $this->resultadoPg = $paginacao->getResultado();
    }

}
