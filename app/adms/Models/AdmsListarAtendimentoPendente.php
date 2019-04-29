<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 31/01/2019
 * Time: 16:08
 */

namespace App\adms\Models;

use \App\adms\Models\helper\AdmsRead;
use \App\adms\Models\helper\AdmsPaginacao;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsListarAtendimentoPendente
{

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 10; // Define a quantidade de usuarios por páginas
    private $ResultadoPg;


    public function getResultadoPg()
    {
        return $this->ResultadoPg;
    }

    public function verCargaHoraria()
    {
        $hoje = date('Y-m-d');
        $verJornada = new AdmsRead();
        $verJornada->fullRead("SELECT usuario.nome, usuario.jornada_de_trabalho, time_format(SEC_TO_TIME(SUM(TIME_TO_SEC( extra.total ))),'%H:%i:%s') 
                                    AS hora_extra
                                    FROM adms_usuarios usuario, adms_hora_extra extra
                                    WHERE usuario.id =:id  AND usuario.id=extra.adms_usuario_id AND extra.data =:hoje
                                    LIMIT :limit", "id=".$_SESSION['usuario_id']."&hoje=".$hoje."&limit=1");
        $this->Resultado = $verJornada->getResultado();

        return $this->Resultado[0];
    }

    public function listarAtendimento($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new AdmsPaginacao(URLADM . 'atendimento-pendente/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(aten.id) AS num_result
                     FROM adms_atendimento_funcionarios aten
                     INNER JOIN adms_atendimentos at ON at.id = aten.adms_atendimento_id
                     WHERE aten.adms_funcionario_id =:usuario AND at.adms_sits_atendimento_id <>:adms_sits_atendimento_id AND at.prioridade <>:prioridade", "usuario=".$_SESSION['usuario_id']."&adms_sits_atendimento_id=4&prioridade=1");
        $this->ResultadoPg = $paginacao->getResultado();
        $offset = $paginacao->getOffset();


        $listarAtendimento = new AdmsRead();
        $listarAtendimento->fullRead("SELECT aten.id id_aten_func, aten.duracao_atividade, aten.created, aten.inicio_atendimento, aten.at_tempo_restante, aten.at_iniciado, aten.at_tempo_excedido, aten.data_fatal, aten.hora_inicio_planejado, aten.hora_fim_planejado, aten.data_inicio_planejado,
        ativi.nome nome_atividade, ativi.descricao descricao_atividade,
        demanda.nome demanda, 
        at.id id_atendimento, at.created data_solicitacao,
        emp.nome nome_empresa, emp.fantasia fantasia_empresa, 
        situacao.nome nome_situacao, situacao.id id_situacao, 
        cr.cor,
        sitAtenFun.id id_sits_aten_func, sitAtenFun.nome nome_sits_aten_func, 
        cor_sitAtenFun.cor cor_sit_aten_func
        FROM adms_atendimento_funcionarios aten 
        INNER JOIN adms_atividades ativi ON ativi.id = aten.adms_atividade_id
        INNER JOIN adms_demandas demanda ON demanda.id=aten.adms_demanda_id 
        INNER JOIN adms_atendimentos at ON at.id = aten.adms_atendimento_id
        INNER JOIN adms_empresas emp ON emp.id = at.adms_empresa_id 
        INNER JOIN adms_sits_atendimentos situacao ON situacao.id=at.adms_sits_atendimento_id 
        INNER JOIN adms_cors cr ON cr.id=situacao.adms_cor_id 
        INNER JOIN adms_sits_atendimentos_funcionario sitAtenFun ON sitAtenFun.id=aten.adms_sits_atendimentos_funcionario_id 
        INNER JOIN adms_cors cor_sitAtenFun ON cor_sitAtenFun.id=sitAtenFun.adms_cor_id 
        WHERE aten.adms_funcionario_id =:usuario 
        AND (at.adms_sits_atendimento_id <>:adms_sits_atendimento_id AND at.adms_sits_atendimento_id <>:adms_sits_atendimento_conclu) 
        AND at.prioridade <>:prioridade 
        AND aten.adms_sits_atendimentos_funcionario_id <>:adms_s_atend_func_id 
        AND aten.adms_sits_atendimentos_funcionario_id <>:interrompido
        ORDER BY created ASC LIMIT :limit OFFSET :offset", "usuario=".$_SESSION['usuario_id']."&adms_sits_atendimento_id=4&adms_sits_atendimento_conclu=3&prioridade=1&adms_s_atend_func_id=4&interrompido=5&limit={$this->LimiteResultado}&offset={$offset}");
        $this->Resultado = $listarAtendimento->getResultado();
        //var_dump($this->Resultado);
        return $this->Resultado;


    }


    public function atendimentoInterrompido()
    {
        $listarInterrompido = new AdmsRead();
        $listarInterrompido->fullRead("SELECT aten.id id_aten_func, aten.duracao_atividade, aten.created, aten.inicio_atendimento, aten.at_tempo_restante, aten.at_iniciado, aten.at_tempo_excedido, aten.data_fatal, 
        ativi.nome nome_atividade,
        demanda.nome demanda, 
        at.id,
        emp.nome nome_empresa, emp.fantasia fantasia_empresa, 
        situacao.nome nome_situacao, situacao.id id_situacao, 
        cr.cor,
        sitAtenFun.id id_sits_aten_func, sitAtenFun.nome nome_sits_aten_func, 
        cor_sitAtenFun.cor cor_sit_aten_func
        FROM adms_atendimento_funcionarios aten 
        INNER JOIN adms_atividades ativi ON ativi.id = aten.adms_atividade_id
        INNER JOIN adms_demandas demanda ON demanda.id=aten.adms_demanda_id 
        INNER JOIN adms_atendimentos at ON at.id = aten.adms_atendimento_id
        INNER JOIN adms_empresas emp ON emp.id = at.adms_empresa_id 
        INNER JOIN adms_sits_atendimentos situacao ON situacao.id=at.adms_sits_atendimento_id 
        INNER JOIN adms_cors cr ON cr.id=situacao.adms_cor_id 
        INNER JOIN adms_sits_atendimentos_funcionario sitAtenFun ON sitAtenFun.id=aten.adms_sits_atendimentos_funcionario_id 
        INNER JOIN adms_cors cor_sitAtenFun ON cor_sitAtenFun.id=sitAtenFun.adms_cor_id 
        WHERE aten.adms_funcionario_id =:usuario
        AND (at.adms_sits_atendimento_id <>:adms_sits_atendimento_id AND at.adms_sits_atendimento_id <>:adms_sits_atendimento_conclu) 
        AND at.prioridade <>:prioridade
        AND aten.adms_sits_atendimentos_funcionario_id =:adms_s_atend_func_id
        ORDER BY created ASC", "usuario=".$_SESSION['usuario_id']."&adms_sits_atendimento_id=4&adms_sits_atendimento_conclu=3&prioridade=1&adms_s_atend_func_id=5");
        $this->Resultado = $listarInterrompido->getResultado();
        //var_dump($this->Resultado);
        return $this->Resultado;
    }

}