<?php

namespace App\adms\Models;

//use App\adms\Models\helper\AdmsAlertMensagem;
//use App\adms\Models\helper\AdmsCreateRow;
use App\adms\Models\helper\AdmsDelete;
use App\adms\Models\helper\AdmsRead;
use DateTime;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsAtendimentoFuncionariosApagar {

    private $AtenId;
    private $FuncId;
    private $AtivId;
    private $Resultado;
    private $atenFuncId;

    public function getResultado() {
        return $this->Resultado;
    }

    public function excluirFuncionario($aten_id, $func_id, $ativ_id, $id_aten_fun) {
        
        $this->AtenId = $aten_id;
        $this->FuncId = $func_id;
        $this->AtivId = $ativ_id;
        $this->atenFuncId = $id_aten_fun;
        
        $buscarOrdem = new \App\adms\Models\AdmsAtendimentoFuncionariosReordenar();
            
        $buscarOrdem->buscarUltOrdemAtvFunc($this->FuncId);          
        $ultimaOrdem = (int) $buscarOrdem->getResultado()[0]['ordem']; 
        
        $buscarOrdem->buscarOrdem($this->atenFuncId); //Apenas obtém os dados necessários antes de serem deletados e os atribuem na classe
        $ordemApagada = $buscarOrdem->getResultado();
        
        $exFunc = new AdmsDelete();
        $exFunc->exeDelete("adms_atendimento_funcionarios", "adms_atendimento_id=:adms_atendimento_id AND adms_funcionario_id=:adms_funcionario_id AND adms_atividade_id=:adms_atividade_id", "adms_atendimento_id={$this->AtenId}&adms_funcionario_id={$this->FuncId}&adms_atividade_id={$this->AtivId}");
         
        $this->Resultado = $exFunc->getResultado();
        
        if ($this->Resultado) { //se conseguir apagar verficará se deve reordenenar
            
            if ($ordemApagada < $ultimaOrdem) { //Se não for a ultima ordem, reordena.
                $buscarOrdem->reordenarAtv(); //O FuncId e atenFuncId foram passados nos métodos anteriores
            }
        }

        return $this->Resultado;
    }
}
