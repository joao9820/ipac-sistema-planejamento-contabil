<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 23/05/2019
 * Time: 16:14
 */

namespace App\adms\Models;

use App\adms\Models\funcoes\BuscarDuracaoAtividades;
use App\adms\Models\funcoes\BuscarDuracaoJornadaT;
use App\adms\Models\funcoes\Funcoes;
use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsAlocacaoFuncionarioData
{

    private $DadosAlocacao;
    private $FuncionarioId;
    private $Data;

    public function __construct($FuncionarioId, $Data = null)
    {
        $this->FuncionarioId = (int) $FuncionarioId;
        if (empty($Data)) {
            $this->Data = date('Y-m-d');
        } else {
            $this->Data = date('Y-m-d', strtotime($Data));
        }
        $this->buscarAlocacao();
    }

    /*
     * Array com os resultados
     */
    public function getDadosAlocacao()
    {
        return $this->DadosAlocacao;
    }

    private function buscarAlocacao()
    {
        $select = new AdmsRead();
        $select->fullRead("SELECT aten.id id_aten_func, aten.duracao_atividade, aten.created, aten.inicio_atendimento, aten.at_tempo_restante, aten.at_iniciado, aten.at_tempo_excedido, aten.data_fatal, aten.hora_inicio_planejado, aten.hora_fim_planejado, aten.data_inicio_planejado,
            ativi.nome nome_atividade, ativi.descricao descricao_atividade,
            demanda.nome nome_demanda, demanda.descricao descricao_demanda,
            at.id id_atendimento, at.created data_solicitacao, at.descricao descricao_atendimento,
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
            AND aten.data_inicio_planejado =:data_inicio
            ORDER BY created ASC ","usuario=".$this->FuncionarioId."&data_inicio=".$this->Data);
        $resultado = $select->getResultado();
        //var_dump($resultado);
        //die;
        $this->DadosAlocacao = $resultado;
    }

    public function getNomeFuncionario()
    {
        $select = new AdmsRead();
        $select->fullRead("SELECT nome FROM adms_usuarios WHERE id =:id LIMIT :limit", "id={$this->FuncionarioId}&limit=1");
        return $select->getResultado();
    }

    public function getAlocacaoAtividades()
    {
        // Buscando duração total das atividades
        $duracaoAtividades = new BuscarDuracaoAtividades($this->FuncionarioId, $this->Data);
        $resultado = $duracaoAtividades->getDuracaoAtividade();
        $DuracaoAtividades = $resultado['duracao_atividade_sc'] ? $resultado['duracao_atividade_sc'] : 0;
        $DuracaoAtividades = $DuracaoAtividades / 60;

        // Buscando o total da jornada na data informada
        $jornadaTrabalho = new BuscarDuracaoJornadaT($this->FuncionarioId, $this->Data);
        $resultado = $jornadaTrabalho->getDuracaoJornada();
        $JornadaTrabalho = $resultado['total'] ? $resultado['total'] : null;
        $JornadaTrabalho = $JornadaTrabalho / 60;

        $percentual_alocacao = ($DuracaoAtividades * 100) / $JornadaTrabalho;

        return $percentual_alocacao;

    }
}