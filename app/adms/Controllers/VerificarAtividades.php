<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsVerificarAtividades;
use App\adms\Models\AdmsCadastrarAtendimento;
use App\adms\Models\AdmsMenu;
use App\adms\Models\AdmsBotao;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerificarAtividades
 *
 * @author joao.victor
 */
class VerificarAtividades {

    private $Dados;
    private $DataAtvIntervalo;
    private $pageId;
    private $DadosBusca;

    public function listar($pageId = null) {

        if (isset($_SESSION['erro_filtro'])) {
            unset($_SESSION['erro_filtro']);
        }
        //var_dump($_GET);
        //die();
        $this->DataAtvIntervalo['dataInicial'] = filter_input(INPUT_GET, "data_inicio", FILTER_DEFAULT);
        $this->DataAtvIntervalo['dataFinal'] = filter_input(INPUT_GET, "data_fim", FILTER_DEFAULT);
        $this->DataAtvIntervalo['filtro'] = filter_input(INPUT_GET, "filtro", FILTER_DEFAULT);
        
        //var_dump($this->DataAtvIntervalo['filtro']);
        //die();
        
        $this->pageId = ((int) $pageId && is_null($this->DataAtvIntervalo['filtro'])) ? $pageId : 1;
        
        //die();
        
        $this->DadosBusca['adms_demanda_id'] = filter_input(INPUT_GET, "dem", FILTER_DEFAULT);
        $this->DadosBusca['adms_empresa_id'] = filter_input(INPUT_GET, "emp", FILTER_DEFAULT);
        
        //var_dump($this->DadosBusca);
        //die();
        $listarAtividades = new AdmsVerificarAtividades();
        $listarEmpresasDemandas = new AdmsCadastrarAtendimento();

        $this->Dados['empresas'] = $listarEmpresasDemandas->listarEmpresas();
        $this->Dados['demandas'] = $listarEmpresasDemandas->listarDemandas();

        if (!empty($this->DataAtvIntervalo['dataFinal'])) {
            
            //echo $this->DataAtvIntervalo['dataFinal'];
            //die();
            
            $busca = filter_input_array(INPUT_GET, FILTER_DEFAULT);

            if (!empty($busca['data_inicio']) && !empty($busca['data_fim']) && is_null($this->DataAtvIntervalo['filtro'])) {
                $this->DataAtvIntervalo['dataInicial'] = $busca['data_inicio'];
                $this->DataAtvIntervalo['dataFinal'] = $busca['data_fim'];
            } else if (empty($this->DataAtvIntervalo['dataInicial'])) {
                $this->DataAtvIntervalo['dataInicial'] = date('Y-m-d');
            }
            
            
            
            if(!empty($busca['dem']) && is_null($this->DataAtvIntervalo['filtro'])){
                $this->DadosBusca['adms_demanda_id'] = $busca['dem'];
            }
            
            if(!empty($busca['emp']) && is_null($this->DataAtvIntervalo['filtro'])){
                $this->DadosBusca['adms_empresa_id'] = $busca['emp'];
            }
            
            unset($this->DataAtvIntervalo['filtro']);   
            /*
              if(empty($this->DataAtvIntervalo['dataFinal'])){
              $this->DataAtvIntervalo['dataFinal'] = $this->DataAtvIntervalo['dataInicial'];
              }
             */

            //$this->listarBusca();

            if (isset($this->DataAtvIntervalo)) {
                
                /*
                if (!empty($this->DataAtvIntervalo['adms_demanda_id'])) {
                    
                    foreach ($this->DadosBusca as $key => $values) {
                        $termos[] = $key . '= :' . $key;
                    }

                    $termos = implode(', ', $termos);

                    echo $termos;
                    die();
                }
                */
                $this->Dados['listaAtividades'] = $listarAtividades->filtrarAtividades($this->pageId, $this->DadosBusca, $this->DataAtvIntervalo);

                if (!isset($_SESSION['erro_filtro'])) {
                    $this->Dados['dataInicial'] = $this->DataAtvIntervalo['dataInicial'];
                    $this->Dados['dataFinal'] = $this->DataAtvIntervalo['dataFinal'];
                }
            }
        } else {    
            
            $this->Dados['listaAtividades'] = $listarAtividades->listarAtividades($this->pageId, $this->DadosBusca ,$this->DataAtvIntervalo['dataInicial']); //TESTE COM GET
            $this->Dados['dataInicial'] = $this->DataAtvIntervalo['dataInicial'];
        }

        $botao = ["vis_atendimento" => ["menu_controller" => "atendimento-funcionarios", "menu_metodo" => "listar"]];

        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $this->Dados['paginacao'] = $listarAtividades->getResultadoPg();

        //var_dump($this->Dados);
        //die();

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $carregarView = new ConfigView("adms/Views/verificarAtividades/verificarAtividades", $this->Dados);
        $carregarView->renderizar();
    }

}
