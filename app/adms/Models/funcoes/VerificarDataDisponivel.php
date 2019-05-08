<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 02/05/2019
 * Time: 17:45
 */

namespace App\adms\Models\funcoes;

use DateTime;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class VerificarDataDisponivel
{

    private $FuncionarioId;
    private $VerificarData;
    private $DataAtual;


    /*
     * Chamar função tempo excedente, duração hora de almoço.
     * Essa classa vai ser responsável por definir qual data será definida para o registro de uma nova atividade
     */
    public function __construct($FuncionarioId, $Data = null)
    {
        $this->FuncionarioId = (int) $FuncionarioId;
        if (!isset($Data) or $Data == null) {
            $this->DataAtual = date('Y-m-d');
        } else {
            $this->DataAtual = $Data;
        }

        //Chamando a função
        $this->defineData();
    }

    /*
     * Retornando a data disponível para registrar atividade e tempo excedente se houver;
     */
    public function getVertificarDataDisponivel()
    {
        return $this->VerificarData;
    }

    private function defineData()
    {
        $novaData = $this->DataAtual;
        $condicao = true;

        // Verificar se é fim de semanda ou não
        $data = getdate(strtotime($novaData));
        if (($data['wday'] == 6) or ($data['wday'] == 0)) {
            if ($data['wday'] == 6){
                // se for sabado
                $dias = 2;
            } else {
                // se for domingo
                $dias = 1;
            }
            $novodia = new Funcoes();
            $novaData = $novodia->dia_in_data($novaData,$dias,"+");
        } else {

            // Verificando se é feriado
            $feriado = new Funcoes();
            while ($feriado->isFeriado($novaData)) {
                // enquanto for feriado será somado mais um dia
                $novaData = $feriado->dia_in_data($novaData, 1, "+");
                //echo "teve feriado";
            }
        }

        do {
            //var_dump($novaData);

            // Pegando duração total das atividades registradas na data informada para o funcionário
            $buscarDuraAtivs = new BuscarDuracaoAtividades($this->FuncionarioId, $novaData);
            $DuracaoTotalAtividades = $buscarDuraAtivs->getDuracaoAtividade()['duracao_atividade_sc'];
            //echo "Total duração atividades <br>";
            //var_dump($DuracaoTotalAtividades);
            //var_dump($buscarDuraAtivs->getDuracaoAtividade());
            //die;

            // Pegando dados da jornada de trabalho
            $buscarJornada = new BuscarDuracaoJornadaT($this->FuncionarioId, $novaData);
            $DuracaoTotalJornadaT = $buscarJornada->getDuracaoJornada()['total'];
            $HoraTermino2Sc = $buscarJornada->getDuracaoJornada()['hora_termino2_sc'];
            //echo "Total duração jornada de trabalho <br>";
            //var_dump($DuracaoTotalJornadaT);
            //var_dump($HoraTermino2Sc);
            //var_dump($buscarJornada->getDuracaoJornada());
            //die;

            // Pegando dados da ultima atividade do funcionáro na data informada
            $buscarUltAtiv = new BuscandoUltimaAtivHoraInicioFim($novaData, $this->FuncionarioId);
            if (isset($buscarUltAtiv->getHoraInicioFim()['hora_fim_planejado_sc'])) {
                $HoraFimUltimaAtivSc = $buscarUltAtiv->getHoraInicioFim()['hora_fim_planejado_sc'];
            } else {
                $HoraFimUltimaAtivSc = 0;
            }
            //echo "Hora fim planejado ultima atividade <br>";
            //var_dump($HoraFimUltimaAtivSc);
            //var_dump($buscarUltAtiv->getHoraInicioFim());


            if (($DuracaoTotalJornadaT > $DuracaoTotalAtividades) and ($HoraTermino2Sc > $HoraFimUltimaAtivSc)) {

                //Ok: definir a data para registrar atividade, logo abaixo verificar se tem hora excedente.
                $this->VerificarData['data_inicio_nova_atividade'] = $novaData;

                /*
                 * Se a novaData for maior ($novaData > $this->DataAtual) que a DataAtual
                 * então significa que foi somando 1 dia
                 * e sendo assim, deve verificar se tem
                 * tempo excedente da atividade anterio
                 */
                if ($novaData > $this->DataAtual) {
                    // Tem excedente da atividade anterior, chamar função para calcular excedente
                    $this->tempoExcedido($novaData);
                } else {
                    $this->VerificarData['tempo_excedido_sc'] = false;
                }

                break; // Objetivo alcançado, sair do laço
            }

            // Se chegar nessa parte somar 1 dia a data atual a cada laço de repetição
            $data = new DateTime(date('Y-m-d', strtotime($novaData)));
            $data->modify('+1 day');
            $novaData = $data->format('Y-m-d');

            // Verificar se é fim de semanda ou não
            $data = getdate(strtotime($novaData));
            if (($data['wday'] == 6) or ($data['wday'] == 0)) {
                if ($data['wday'] == 6){
                    // se for sabado
                    $dias = 2;
                } else {
                    // se for domingo
                    $dias = 1;
                }
                $novodia = new Funcoes();
                $novaData = $novodia->dia_in_data($novaData,$dias,"+");
            } else {

                // Verificando se é feriado
                $feriado = new Funcoes();
                while ($feriado->isFeriado($novaData)) {
                    // enquanto for feriado será somado mais um dia
                    $novaData = $feriado->dia_in_data($novaData, 1, "+");
                    //echo "teve feriado";
                }

            }



        } while ($condicao);

    }

    /*
     * Calcular tempo excedido
     */
    private function tempoExcedido($Data)
    {
        // Pegar data do dia anterior
        $data = new DateTime(date('Y-m-d', strtotime($Data)));
        $data->modify('-1 day');
        $diaAnterior = $data->format('Y-m-d');

        // Verificar se é fim de semanda ou não
        $data = getdate(strtotime($diaAnterior));
        if (($data['wday'] == 6) or ($data['wday'] == 0)) {
            if ($data['wday'] == 6){
                // se for sabado
                $dias = 1;
            } else {
                // se for domingo
                $dias = 2;
            }
            $novodia = new Funcoes();
            $diaAnterior = $novodia->dia_in_data($diaAnterior,$dias,"-");
        }


        // Pegando dados da ultima atividade do funcionáro na data informada
        $buscarUltAtivAnterior = new BuscandoUltimaAtivHoraInicioFim($diaAnterior, $this->FuncionarioId);
        $HoraFimUltimaAtivAntSc = $buscarUltAtivAnterior->getHoraInicioFim()['hora_fim_planejado_sc'];

        // Pegando dados da jornada de trabalho
        $buscarJornada = new BuscarDuracaoJornadaT($this->FuncionarioId, $diaAnterior);
        $HoraTerminoExpediente = $buscarJornada->getDuracaoJornada()['hora_termino2_sc'];

        // Calculando o tempo excedido
        $resultadoTime = $HoraFimUltimaAtivAntSc - $HoraTerminoExpediente;

        $this->VerificarData['tempo_excedido_sc'] = (int) $resultadoTime;

        //var_dump($this->VerificarData);
        //echo $diaAnterior;
    }
}