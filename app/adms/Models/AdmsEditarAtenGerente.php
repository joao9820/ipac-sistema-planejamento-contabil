<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 15:34
 */

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsEditarAtenGerente
{

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $DadosDemandaId;

    public function getResultado()
    {
        return $this->Resultado;
    }

    public function verAtendimento($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verUsuario = new \App\adms\Models\helper\AdmsRead();
        $verUsuario->fullRead("SELECT id, adms_demanda_id, adms_sits_atendimento_id, adms_funcionario_id, prioridade, adms_sits_atendimentos_funcionario_id situacao_funcionario, data_fatal 
                              FROM adms_atendimentos WHERE id =:id LIMIT :limit","id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verUsuario->getResultado();
        return $this->Resultado;
    }

    public function listarCadastrar()
    {
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id id_demanda, nome nome_demanda FROM adms_demandas ORDER BY nome ASC");

        $registro['deman'] = $listar->getResultado();

        $listar->fullRead("SELECT aten.id id_sits_aten, aten.nome nome_sits_aten, cores.cor cores_sits_aten FROM adms_sits_atendimentos aten 
                            INNER JOIN adms_cors cores ON cores.id=aten.adms_cor_id 
                            ORDER BY id_sits_aten ASC");
        $registro['sitsat'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_func, nome nome_func FROM adms_usuarios 
                            WHERE adms_niveis_acesso_id=:adms_niveis_acesso_id AND adms_empresa_id=:adms_empresa_id 
                            ORDER BY nome ASC", "adms_niveis_acesso_id=4&adms_empresa_id=1");
        $registro['func'] = $listar->getResultado();

        $this->Resultado = ['deman' => $registro['deman'], 'sitsat' => $registro['sitsat'], 'func' => $registro['func']];

        return $this->Resultado;
    }



    public function altAtendimento(array $Dados)
    {
        $this->Dados = $Dados;


        if ($this->Dados['prioridade'] != 1) {
            $this->Dados['prioridade'] = 2;
        }


        if (empty($this->Dados['data_fatal'])) {
            unset($this->Dados['data_fatal']);
        }

        $valCampos = new \App\adms\Models\helper\AdmsCampoVazio();
        $valCampos->validarDados($this->Dados);

        if ($valCampos->getResultado()) {

            $this->updateEditDemanda();

        } else {

            $this->Resultado = false;
        }




    }


    private function updateEditDemanda()
    {

        if (!isset($this->Dados['adms_funcionario_id'])){
            $this->Dados['adms_funcionario_id'] = null;
        }
        $this->Dados['modified'] = date('Y-m-d H:i:s');

        $demandaId = $this->Dados['adms_demanda_id'];

        $this->verTotalHoras($demandaId);
        $this->Dados['duracao_atendimento'] = $this->Resultado[0]['total_horas'];


        $upEditDemanda = new \App\adms\Models\helper\AdmsUpdate();
        $upEditDemanda->exeUpdate("adms_atendimentos", $this->Dados, "WHERE id =:id", "id={$this->Dados['id']}");
        if ($upEditDemanda->getResultado())
        {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagemSimples("Atendimento editado com sucesso", "success");
            $this->Resultado = true;

        } else {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagem("Desculpe! Ocorreu um erro.","O atendimento não foi atualizado", "danger");
            $this->Resultado = false;

        }

    }

    public function verTotalHoras($DadosDemandaId)
    {
        $this->DadosDemandaId = (int) $DadosDemandaId;

        $qtdHoras = new \App\adms\Models\helper\AdmsRead();
        $qtdHoras->fullRead("SELECT time_format( SEC_TO_TIME( SUM( TIME_TO_SEC( duracao ) ) ),'%H:%i:%s') 
                                    AS total_horas FROM adms_atividades where adms_demanda_id=:adms_demanda_id", "adms_demanda_id={$this->DadosDemandaId}");
        $this->Resultado = $qtdHoras->getResultado();
        return $this->Resultado;
    }







}