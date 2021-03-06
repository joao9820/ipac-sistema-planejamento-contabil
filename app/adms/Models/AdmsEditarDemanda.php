<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 15:34
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsCampoVazio;
use App\adms\Models\helper\AdmsRead;
use App\adms\Models\helper\AdmsUpdate;
use App\adms\Models\helper\AdmsValCampoUnico;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsEditarDemanda
{

    private $Resultado;
    private $Dados;
    private $DadosId;

    public function getResultado()
    {
        return $this->Resultado;
    }

    public function verDemanda($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verUsuario = new AdmsRead();
        $verUsuario->fullRead("SELECT dmd.* 
                        FROM adms_demandas dmd 
                        WHERE dmd.id =:id LIMIT :limit",
            "id={$this->DadosId}&limit=1");
        $this->Resultado = $verUsuario->getResultado();
        return $this->Resultado;
    }

    public function altDemanda(array $Dados)
    {
        $this->Dados = $Dados;
        //var_dump($this->Dados);

        $valCampos = new AdmsCampoVazio();
        $valCampos->validarDados($this->Dados);

        if ($valCampos->getResultado()) {
            // se retornar true
            $this->valCampos();

        }
        else {

            $this->Resultado = false;
        }

    }


    private function valCampos()
    {
        $EditarUnico = true;

        $valCampoUnico = new AdmsValCampoUnico();
        $valCampoUnico->valCampo("adms_demandas", "nome",$this->Dados['nome'], $EditarUnico, $this->Dados['id']);

        if ($valCampoUnico->getResultado()){

            $this->updateEditDemanda();

        }
        else {

            $this->Resultado = false;
        }


    }


    private function updateEditDemanda()
    {
        $this->Dados['modified'] = date('Y-m-d H:i:s');


        $upEditDemanda = new AdmsUpdate();
        //var_dump($this->Dados);
        $upEditDemanda->exeUpdate("adms_demandas", $this->Dados, "WHERE id =:id", "id={$this->Dados['id']}");
        if ($upEditDemanda->getResultado())
        {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Demanda atualizada!","success");
            $this->Resultado = true;

        }
        else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("A demanda não foi atualizada.","danger");
            $this->Resultado = false;

        }

    }

}