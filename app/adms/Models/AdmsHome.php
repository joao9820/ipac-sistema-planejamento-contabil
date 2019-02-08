<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 30/01/2019
 * Time: 15:44
 */

namespace App\adms\Models;


class AdmsHome
{
    private $Resultado;
    private $EmpId;

    public function getResultado()
    {
        return $this->Resultado;
    }


    public function verTotUser($EmpId)
    {
        $this->EmpId = (int) $EmpId;

        $verTotUsuario = new \App\adms\Models\helper\AdmsRead();
        $verTotUsuario->fullRead("SELECT COUNT(id) AS num_result_user FROM adms_usuarios WHERE adms_empresa_id =:adms_empresa_id",
            "adms_empresa_id=".$this->EmpId);
        $this->Resultado = $verTotUsuario->getResultado();

    }

    public function verTotDemandas()
    {
        $verTotDemandas = new \App\adms\Models\helper\AdmsRead();
        $verTotDemandas->fullRead("SELECT COUNT(id) AS num_result_demanda FROM adms_demandas");
        $this->Resultado = $verTotDemandas->getResultado();
        return $this->Resultado;

    }

}