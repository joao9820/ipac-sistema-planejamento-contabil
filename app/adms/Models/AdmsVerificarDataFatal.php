<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 29/04/2019
 * Time: 15:19
 */

namespace App\adms\Models;


use App\adms\Models\funcoes\BuscandoUltimaAtivHoraInicioFim;
use App\adms\Models\funcoes\BuscarDuracaoAtividades;
use App\adms\Models\funcoes\BuscarDuracaoJornadaT;
use App\adms\Models\funcoes\Funcoes;
use App\adms\Models\funcoes\VerDuracaoAtividadeId;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsVerificarDataFatal
{
    private $Funcionario_id;
    private $DataFatal;
    private $AtividadeId;
    private $PermissaoResult;
    private $Duracao_ativ_do_dia;
    private $Duracao_jornada;
    private $AtividadeSendoRegister;
    private $HoraFimUltimaAtiv = null;
    private $FimJornadaTrabalho;

    public function __construct($Funcionario_id, $DataFatal, $AtividadeId)
    {
        $this->Funcionario_id = (int) $Funcionario_id;
        $this->DataFatal = date('Y-m-d',strtotime($DataFatal));
        $this->AtividadeId = (int) $AtividadeId;

        $this->verificar();
    }

    public function getPermissaoResult()
    {
        return $this->PermissaoResult;
    }

    /*
     * Verificar se a data fatal escolhida pode ser definida ao funcionário
     * O calulo é feito com base na soma das atividades pendentes até a
     * data fatal escolhida.
     * Caso essa soma ainda tenha tempo livre para adicionar a tividade,
     * um status ok será retornando e a atividade poderá ser registrada
     * com a data fatal informada.
     */
    private function verificar()
    {

        // buscando a duração das atividades
        $buscar_duracao_ati = new BuscarDuracaoAtividades($this->Funcionario_id, $this->DataFatal, $this->AtividadeId);
        if (($buscar_duracao_ati->getDuracaoAtividade()['status']) and ($buscar_duracao_ati->getDuracaoAtividade()['duracao_atividade_sc'] > 0)){
            $this->Duracao_ativ_do_dia = (int)$buscar_duracao_ati->getDuracaoAtividade()['duracao_atividade_sc'];

            // Pegar a hora de inicio, fim da ultima atividade do funcionário
            $ultima_atividade = new BuscandoUltimaAtivHoraInicioFim($this->DataFatal, $this->Funcionario_id);
            $dados_ultima_atividade = $ultima_atividade->getHoraInicioFim();
            if ($dados_ultima_atividade['status']) {

                // Pegar duração da atividade que está sendo cadastrada
                $atividade_register = new VerDuracaoAtividadeId($this->AtividadeId);
                $this->AtividadeSendoRegister = $atividade_register->getDuracaoAtividade()['duracao_atividade_id'];

                $somar_ativ = new Funcoes();
                $this->HoraFimUltimaAtiv = $somar_ativ->somar_time_in_hours($this->AtividadeSendoRegister, $dados_ultima_atividade['hora_fim_planejado']);

            }
        } else {
            $this->Duracao_ativ_do_dia = 0;
        }

        // buscar jornada de trabalho
        $buscar_jornada = new BuscarDuracaoJornadaT($this->Funcionario_id, $this->DataFatal);
        if ($buscar_jornada->getDuracaoJornada()['status']) {
            $this->Duracao_jornada = $buscar_jornada->getDuracaoJornada()['total'];
            $this->FimJornadaTrabalho = $buscar_jornada->getDuracaoJornada()['hora_termino2'];

            /*
             * Comparar se a duração da soma total das atividades é menor que a jornada de trabalho e
             * verificar se a hora da ultima atividade registrada não ultrapassa a hora de termino da jornada
             */
            if ($this->Duracao_ativ_do_dia < $this->Duracao_jornada) {
                if (empty($this->HoraFimUltimaAtiv)){

                    //echo "ok prossiga";
                    $this->PermissaoResult['status'] = true;

                } elseif ($this->HoraFimUltimaAtiv < $this->FimJornadaTrabalho){

                    //echo "ok prossiga";
                    $this->PermissaoResult['status'] = true;

                } else {

                    //echo "Definir para outro dia";
                    $this->PermissaoResult['status'] = false;

                }
            } else {
                //echo "Definir para outro dia";
                $this->PermissaoResult['status'] = false;
            }
        }
    }

}