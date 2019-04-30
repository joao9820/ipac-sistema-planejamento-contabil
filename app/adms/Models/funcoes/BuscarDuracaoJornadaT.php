<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 29/04/2019
 * Time: 17:43
 */

namespace App\adms\Models\funcoes;

use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class BuscarDuracaoJornadaT
{

    private $FuncionarioId;
    private $Data;
    private $HoraExtra;
    private $Jornada;

    public function __construct($FuncionarioId, $Data)
    {
        $this->FuncionarioId = (int) $FuncionarioId;
        $this->Data = date('Y-m-d', strtotime($Data));

        $this->buscar();
    }

    /*
     * Buscar duração total da jornada de trabalho do funcionário na data especifica
     */
    private function buscar()
    {
        $this->verificarHoraExtra();

        $jornadaDia = new AdmsRead();

        if ($this->HoraExtra) { //Soma as horas extras para aquele dia do funcionario e o resultado é somado com sua jornada normal
            $jornadaDia->fullRead("SELECT TIME_TO_SEC(planejamento.jornada_trabalho) + SUM(TIME_TO_SEC(hora_extra.total)) as total, planejamento.hora_termino2, planejamento.hora_inicio2, planejamento.hora_termino
                                            FROM adms_hora_extra hora_extra 
                                            INNER JOIN adms_planejamento planejamento 
                                            ON hora_extra.adms_usuario_id = planejamento.adms_funcionario_id
                                            WHERE hora_extra.adms_usuario_id = :usuario and hora_extra.data = :data
                                            GROUP BY planejamento.hora_termino2", "usuario={$this->FuncionarioId}&data={$this->Data}"
            );
        } else { //Traz apenas a jornada normal do funcionário cadastrado
            $jornadaDia->fullRead("SELECT TIME_TO_SEC(planejamento.jornada_trabalho) as total, planejamento.hora_termino2, planejamento.hora_inicio2, planejamento.hora_termino
                                        FROM adms_planejamento planejamento
                                        WHERE adms_funcionario_id = :funcionario
                                        GROUP BY planejamento.hora_termino2", "funcionario={$this->FuncionarioId}"
            );
        }


        if ($jornadaDia->getResultado()) {
            $this->Jornada = $jornadaDia->getResultado()[0];
            $this->Jornada['total'] = (int) $this->Jornada['total'];
            $this->Jornada['status'] = true;
        } else {
            $this->Jornada['status'] = false;
        }

    }

    /*
     * Verificar se existe hora extra
     */
    private function verificarHoraExtra() {
        $verificar = new AdmsRead();
        $verificar->fullRead("SELECT *
                                    FROM adms_hora_extra 
                                    WHERE adms_usuario_id =:id
                                    AND data =:data_d", "id={$this->FuncionarioId}&data_d={$this->Data}");
        $this->HoraExtra = $verificar->getResultado();
    }

    /*
     * Retorna array contendo dados e status
     */
    public function getDuracaoJornada()
    {
        return $this->Jornada;
    }

}