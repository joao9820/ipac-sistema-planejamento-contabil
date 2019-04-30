<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 05/02/2019
 * Time: 16:18
 */

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsVerAtendGerente
{

    private $Resultado;
    private $DadosId;
    private $DadosDemandaId;



    public function visualizar($DadosId)
    {
        $this->DadosId = (int) $DadosId;

        $verAtendimento = new \App\adms\Models\helper\AdmsRead();
        $verAtendimento->fullRead("SELECT aten.id, aten.descricao, aten.created,
                                        aten.modified, aten.prioridade, aten.duracao_atendimento, aten.inicio_atendimento, 
                                        aten.fim_atendimento, aten.arquivado_gerente, aten.cancelado_p_user,
                                        demanda.nome nome_demanda, demanda.id id_demanda, 
                                        situacao.nome nome_situacao, situacao.id id_situacao, 
                                        cr.cor, 
                                        user.nome cliente, 
                                        emp.fantasia, emp.nome emp_nome 
                                        FROM adms_atendimentos aten 
                                        INNER JOIN adms_usuarios user ON user.id=aten.adms_usuario_id 
                                        INNER JOIN adms_empresas emp ON emp.id=aten.adms_empresa_id 
                                        INNER JOIN adms_demandas demanda ON demanda.id=aten.adms_demanda_id 
                                        INNER JOIN adms_sits_atendimentos situacao ON situacao.id=aten.adms_sits_atendimento_id 
                                        INNER JOIN adms_cors cr ON cr.id=situacao.adms_cor_id 
                                        WHERE aten.id=:id 
                                        ORDER BY created DESC LIMIT :limit", "id={$this->DadosId}&limit=1");
        $this->Resultado = $verAtendimento->getResultado();
        return $this->Resultado;
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