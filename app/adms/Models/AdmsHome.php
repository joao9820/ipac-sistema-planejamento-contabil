<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 30/01/2019
 * Time: 15:44
 */

namespace App\adms\Models;


use App\adms\Models\helper\AdmsRead;

class AdmsHome
{
    private $Resultado;
    private $EmpId;

    public function getResultado()
    {
        return $this->Resultado;
    }

    public function verAtendimentos()
    {
        $ver = new AdmsRead();
        $ver->fullRead("SELECT atendi.adms_sits_atendimento_id id_status_aten, situacao.nome, count(atendi.id) as total 
                        FROM adms_atendimentos atendi
                        INNER JOIN adms_sits_atendimentos situacao ON situacao.id=atendi.adms_sits_atendimento_id 
                        GROUP BY atendi.adms_sits_atendimento_id;");
        $this->Resultado = $ver->getResultado();

        return $this->Resultado;
    }

    public function verTotUser($EmpId)
    {
        $this->EmpId = (int) $EmpId;

        $verTotUsuario = new AdmsRead();
        $verTotUsuario->fullRead("SELECT COUNT(id) AS num_result_user FROM adms_usuarios WHERE adms_empresa_id =:adms_empresa_id",
            "adms_empresa_id=".$this->EmpId);
        $this->Resultado = $verTotUsuario->getResultado();

    }

    public function verTotDemandas()
    {
        $verTotDemandas = new AdmsRead();
        $verTotDemandas->fullRead("SELECT COUNT(id) AS num_result_demanda FROM adms_demandas");
        $this->Resultado = $verTotDemandas->getResultado();
        return $this->Resultado;

    }

    /*
     * Ver total alocação gerentes
     */
    public function getAlocacao()
    {
        $alocacaoGerentes = new AdmsAlocacaoGerentes();
        $dadosGerentes = $alocacaoGerentes->getGerentes();

        if($dadosGerentes){
            $atividades = 0;
            $jornada = 0;

            foreach ($dadosGerentes as $gerente){
                $atividades += (int) $gerente['duracao_atividades'];
                $jornada += (int) $gerente['duracao_jornada'];
            }
            $resultado = $atividades > 0 ? ($atividades * 100) / $jornada : 0;
            return $resultado;
        } else {
            $resultado = 0;
            return $resultado;
        }
    }

}