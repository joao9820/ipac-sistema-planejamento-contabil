<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 03/06/2019
 * Time: 17:21
 */

namespace App\adms\Models;

use App\adms\Models\funcoes\Funcoes;
use App\adms\Models\helper\AdmsRead;
use App\adms\Models\helper\AdmsUpdate;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsCalcularAlocacaoAtividade
{
    private $AtividadeId;
    private $FuncionarioId;
    private $DuracaoAtividade;
    private $TempoRestante;
    private $TempoExcedido;
    private $ResultadoAlocacao;
    private $AlocacaoReal;

    function getResultadoAlocacao()
    {
        return $this->ResultadoAlocacao;
    }

    /*
     * Função que calcula a alocação da atividade concluída, no momento em que o
     * funcionário finaliza a atividade.
     */
    public function __construct($AtividadeId, $FuncionarioId)
    {
        $this->AtividadeId = (int) $AtividadeId;
        $this->FuncionarioId = (int) $FuncionarioId;

        $this->buscarDadosAtividadeFuncionario(); // Busca dados da atividade
        $this->calcularAlocacao(); // Calcula alocação real
        $this->updateAlocacaoAtividade(); // Atualiza no banco a aloção real da atividade
    }

    private function buscarDadosAtividadeFuncionario()
    {
        $select = new AdmsRead();
        $select->fullRead("SELECT duracao_atividade, at_tempo_restante, at_tempo_excedido FROM adms_atendimento_funcionarios 
                WHERE id=:id AND adms_funcionario_id =:adms_funcionario_id", "id={$this->AtividadeId}&adms_funcionario_id={$this->FuncionarioId}");
        $resultado = $select->getResultado();
        if (!empty($resultado)) {
            $resultado = $resultado[0];

            $funcao = new Funcoes();

            $this->DuracaoAtividade = $funcao->hora_to_segundos($resultado['duracao_atividade']); // Duração prevista da atividade

            $this->TempoRestante = !empty($resultado['at_tempo_restante']) ? $funcao->hora_to_segundos($resultado['at_tempo_restante']) : null; // Transformar tempo restante em segundos se houver

            $this->TempoExcedido = !empty($resultado['at_tempo_excedido']) ? $funcao->hora_to_segundos($resultado['at_tempo_excedido']) : null; // Transformar tempo excedido em segundos se houver;
        } else {
            $this->ResultadoAlocacao = false;
        }
    }

    private function calcularAlocacao()
    {
        // Verificar se teve tempo restante
        if ($this->TempoRestante != null){
            // Calcular alocação real subtraindo o tempo restante
            $this->AlocacaoReal = $this->DuracaoAtividade - $this->TempoRestante;
            // Trasformar segundos em time H:i:s
            $this->AlocacaoReal = gmdate('H:i:s', $this->AlocacaoReal);

        } else {
            // Se não houve tempo restante, verificar se teve tempo excedido
            if ($this->TempoExcedido != null){
                // Calcular alocação real somando com o tempo excedido
                $this->AlocacaoReal = $this->DuracaoAtividade + $this->TempoExcedido;
                // Trasformar segundos em time H:i:s
                $this->AlocacaoReal = gmdate('H:i:s', $this->AlocacaoReal);

            } else {
                // Se não houve tempo restante e nem excedido, a alocação real será a duração prevista da atividade
                $this->AlocacaoReal = gmdate('H:i:s', $this->DuracaoAtividade);
            }
        }
    }

    private function updateAlocacaoAtividade()
    {
        $Dados['alocacao_atividade'] = $this->AlocacaoReal;
        $update = new AdmsUpdate();
        $update->exeUpdate("adms_atendimento_funcionarios",$Dados,"WHERE id =:id","id={$this->AtividadeId}");
        $resultado = $update->getResultado();
        if ($resultado){
            $this->ResultadoAlocacao = true;
        } else {
            $this->ResultadoAlocacao = false;
        }
    }

}