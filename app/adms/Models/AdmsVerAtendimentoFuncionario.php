<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 14:08
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsVerAtendimentoFuncionario
{

    private $Resultado;
    private $DadosId;


    public function verAtendimento($DadosId)
    {
        $this->DadosId = (int) $DadosId;

        $verAtendimento = new AdmsRead();
        $verAtendimento->fullRead("SELECT aten.id, aten.adms_funcionario_id funcionario, aten.descricao, aten.created, 
                            aten.modified, aten.prioridade, aten.duracao_atendimento, aten.inicio_atendimento, 
                            aten.fim_atendimento, aten.arquivado_gerente, aten.cancelado_p_user, aten.at_tempo_restante,aten.at_iniciado, aten.at_pausado, aten.at_tempo_excedido,
                        demanda.nome nome_demanda, demanda.id id_demanda, 
                        situacao.nome nome_situacao, situacao.id id_situacao, 
                        cr.cor, 
                        sitAtenFun.id id_sits_aten_func, sitAtenFun.nome nome_sits_aten_func, 
                        cor_sitAtenFun.cor cor_sit_aten_func,
                        user.nome cliente,  
                        emp.fantasia, emp.nome emp_nome 
                        FROM adms_atendimentos aten 
                        LEFT JOIN adms_usuarios func ON func.id=aten.adms_funcionario_id 
                        INNER JOIN adms_usuarios user ON user.id=aten.adms_usuario_id 
                        INNER JOIN adms_empresas emp ON emp.id=aten.adms_empresa_id 
                        INNER JOIN adms_demandas demanda ON demanda.id=aten.adms_demanda_id 
                        INNER JOIN adms_sits_atendimentos situacao ON situacao.id=aten.adms_sits_atendimento_id 
                        INNER JOIN adms_cors cr ON cr.id=situacao.adms_cor_id 
                        INNER JOIN adms_sits_atendimentos_funcionario sitAtenFun ON sitAtenFun.id=aten.adms_sits_atendimentos_funcionario_id 
                        INNER JOIN adms_cors cor_sitAtenFun ON cor_sitAtenFun.id=sitAtenFun.adms_cor_id 
                        WHERE aten.id=:id AND aten.adms_funcionario_id =:usuario 
                        ORDER BY created DESC LIMIT :limit", "usuario={$_SESSION['usuario_id']}&id={$this->DadosId}&limit=1");
        $this->Resultado = $verAtendimento->getResultado();
        return $this->Resultado;
    }

    public function verTotalHoras($DadosDemandaId)
    {
        $this->DadosDemandaId = (int) $DadosDemandaId;

        $qtdHoras = new AdmsRead();
        $qtdHoras->fullRead("SELECT time_format( SEC_TO_TIME( SUM( TIME_TO_SEC( duracao ) ) ),'%H:%i:%s') 
                                    AS total_horas FROM adms_atividades where adms_demanda_id=:adms_demanda_id", "adms_demanda_id={$this->DadosDemandaId}");
        $this->Resultado = $qtdHoras->getResultado();
        return $this->Resultado;
    }
}