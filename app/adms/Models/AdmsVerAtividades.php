<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 14:08
 */

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsVerAtividades
{

    private $Resultado;
    private $DadosId;
    private $ResultHoras;

    public function getResultHoras()
    {
        return $this->ResultHoras;
    }

    public function verAtividade($DadosId)
    {
        $this->DadosId = (int) $DadosId;

        $qtdHoras = new \App\adms\Models\helper\AdmsRead();
        $qtdHoras->fullRead("SELECT time_format( SEC_TO_TIME( SUM( TIME_TO_SEC( duracao ) ) ),'%H:%i:%s') 
                                    AS total_horas FROM adms_atividades where adms_demanda_id=:adms_demanda_id", "adms_demanda_id={$this->DadosId}");
        $this->ResultHoras = $qtdHoras->getResultado();


        $verAtividade = new \App\adms\Models\helper\AdmsRead();
        $verAtividade->fullRead("SELECT ativ.id, ativ.nome, ativ.duracao, ativ.ordem, ativ.descricao ,
                        antecessora.nome nome_ante
                        FROM adms_atividades ativ 
                        INNER JOIN adms_demandas dmd ON dmd.id=ativ.adms_demanda_id 
                        LEFT JOIN adms_atividades antecessora ON antecessora.atividade_sucessora_id=ativ.id 
                        WHERE ativ.adms_demanda_id =:adms_demanda_id 
                        ORDER BY ativ.ordem ASC ", "adms_demanda_id={$this->DadosId}");
        $this->Resultado = $verAtividade->getResultado();

        return $this->Resultado;
        //var_dump($this->Resultado);
    }
}