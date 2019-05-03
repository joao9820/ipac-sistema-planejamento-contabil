<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 30/04/2019
 * Time: 13:56
 */

namespace App\adms\Models\funcoes;

use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class BuscandoUltimaAtivHoraInicioFim
{
    private $Data;
    private $FuncionarioId;
    private $HoraInicioFim;

    public function __construct($Data, $FuncionarioId)
    {
        $this->Data = date('Y-m-d', strtotime($Data));
        $this->FuncionarioId = (int) $FuncionarioId;

        $this->buscar();
    }

    private function buscar()
    {
        $dataHora = new AdmsRead();
        $dataHora->fullRead("SELECT hora_fim_planejado, hora_inicio_planejado,
                                    TIME_TO_SEC(hora_fim_planejado)  AS hora_fim_planejado_sc,
                                    TIME_TO_SEC(hora_inicio_planejado)  AS hora_inicio_planejado_sc
                                    FROM adms_atendimento_funcionarios 
                                    WHERE data_inicio_planejado=:data_inicio_planejado
                                    AND adms_funcionario_id=:adms_funcionario_id 
                                    ORDER BY id DESC LIMIT :limit", "data_inicio_planejado={$this->Data}&adms_funcionario_id={$this->FuncionarioId}&limit=1");
        if($dataHora->getResultado()) {
            $this->HoraInicioFim = $dataHora->getResultado()[0];
            if (!empty($this->HoraInicioFim['hora_fim_planejado_sc'])) {
                $this->HoraInicioFim['hora_fim_planejado_sc'] = (int)$this->HoraInicioFim['hora_fim_planejado_sc'];
            } else {
                $this->HoraInicioFim['hora_fim_planejado_sc'] = 0;
            }
            $this->HoraInicioFim['hora_inicio_planejado_sc'] = (int) $this->HoraInicioFim['hora_inicio_planejado_sc'];
            $this->HoraInicioFim['status'] = true;
        } else {
            $this->HoraInicioFim['status'] = false;
        }
    }

    public function getHoraInicioFim()
    {
        return $this->HoraInicioFim;
    }

}