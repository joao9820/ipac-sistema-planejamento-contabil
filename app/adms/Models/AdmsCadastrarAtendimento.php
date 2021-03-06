<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 31/01/2019
 * Time: 14:39
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsCampoVazio;
use App\adms\Models\helper\AdmsCreate;
use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsCadastrarAtendimento
{

    private $Resultado;
    private $Dados;
    private $UltimoIdInserido;


    function getResultado()
    {
        return $this->Resultado;
    }

    public function listarDemandas()
    {
        $listarDemandas = new AdmsRead();
        $listarDemandas->fullRead("SELECT id, nome  
                        FROM adms_demandas 
                        ORDER BY nome ASC");
        $this->Resultado = $listarDemandas->getResultado();
        //var_dump($this->Resultado);
        return $this->Resultado;
    }

    public function listarEmpresas()
    {
        $listarEmp = new AdmsRead();
        $listarEmp->fullRead("SELECT id id_empresa, nome nome_empresa
                                    FROM adms_empresas ORDER BY nome_empresa ASC ");
        $this->Resultado = $listarEmp->getResultado();
        return $this->Resultado;
    }




    public function cadAtendimento(array $Dados)
    {
        $this->Dados = $Dados;


        $valCampoVazio = new AdmsCampoVazio();
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {

            $this->inserirAtendimento();

        }
        else {
            $this->Resultado = false;
        }
    }

    private function inserirAtendimento()
    {
        //var_dump($this->Dados);

        $this->Dados['adms_sits_atendimento_id'] = 1;
        if ($_SESSION['adms_niveis_acesso_id'] > 3) {

            $this->Dados['adms_empresa_id'] = $_SESSION['adms_empresa_id'];

        }
        $this->Dados['adms_usuario_id'] = $_SESSION['usuario_id'];
        $this->Dados['created'] = date("Y-m-d H:i:s");

        //var_dump($this->Dados);

        $cadDemanda = new AdmsCreate();
        $cadDemanda->exeCreate("adms_atendimentos", $this->Dados);

        if ($cadDemanda->getResultado())
        {

            $this->UltimoIdInserido = $cadDemanda->getResultado();
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Atendimento solicitado!","success");
            $this->Resultado = true;

        }
        else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("O atendiemento não foi registrado.","danger");
            $this->Resultado = false;

        }
    }



}