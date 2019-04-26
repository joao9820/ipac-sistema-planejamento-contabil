<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 27/03/2019
 * Time: 15:34
 */

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsHoraExtra
{

    private $Resultado;
    private $UserId;
    private $PageId;
    private $LimiteResultado = 10;
    private $ResultadoPg;
    private $Dados;
    private $DataInicial;
    private $DataFinal;
    private $HoraExtraId;

    function getResultadoPg()
    {
        return $this->ResultadoPg;
    }

    function getResultado()
    {
        return $this->Resultado;
    }


    public function listar($UserId = null, $PageId = null)
    {
        $this->PageId = (int) $PageId;
        $this->UserId = (int) $UserId;
        $dataInicial = date('Y-m-d');

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'hora-extra/listar/', "?func=" . $this->UserId);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_hora_extra 
                              WHERE adms_usuario_id=:adms_usuario_id 
                              AND (data >= :dataInicial) ", "adms_usuario_id={$this->UserId}&dataInicial={$dataInicial}");
        $this->ResultadoPg = $paginacao->getResultado();


        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id id_hora_extra, total, data 
                          FROM adms_hora_extra 
                          WHERE adms_usuario_id=:adms_usuario_id
                          AND (data >= :dataInicial)
                          ORDER BY data DESC LIMIT :limit OFFSET :offset", "adms_usuario_id={$this->UserId}&dataInicial={$dataInicial}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listar->getResultado();
        return $this->Resultado;
    }

    public function filtrarHoraExtra($UserId = null, $DataInicial = null, $DataFinal = null)
    {
        $this->UserId = (int) $UserId;
        $this->DataInicial = $DataInicial;
        $this->DataFinal = $DataFinal;



        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id id_hora_extra, total, data 
                          FROM adms_hora_extra 
                          WHERE adms_usuario_id=:adms_usuario_id
                          AND (data >= :dataInicial) AND (data <= :dataFinal) 
                          ORDER BY data DESC", "adms_usuario_id={$this->UserId}&dataInicial={$this->DataInicial}&dataFinal={$this->DataFinal}");
        $this->Resultado = $listar->getResultado();

        return $this->Resultado;
    }

    public function verFuncionario($UserId = null)
    {
        $this->UserId = (int) $UserId;

        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id id_funcionario, nome nome_funcionario
                          FROM adms_usuarios 
                          WHERE id=:id LIMIT :limit", "id={$this->UserId}&limit=1");
        $this->Resultado = $listar->getResultado();
        return $this->Resultado;
    }

    public function registrarHoraExtra($Dados = null)
    {
        $this->Dados = $Dados;

        $this->Dados['created'] = date("Y-m-d H:i:s");


        $cadHoraExtra = new \App\adms\Models\helper\AdmsCreate();
        $cadHoraExtra->exeCreate("adms_hora_extra", $this->Dados);


        if ($cadHoraExtra->getResultado())
        {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagemSimples("Hora extra agendada com sucesso!", "success");
            $this->Resultado = true;

        }
        else {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagem("Desculpe! Ocorreu um erro.","A hora extra não foi agendada.", "danger");
            $this->Resultado = false;

        }
    }

    public function deletarHoraExtra($HoraExtraId = null)
    {
        $this->HoraExtraId = (int) $HoraExtraId;


        $deletarHoraExtra = new \App\adms\Models\helper\AdmsDelete();
        $deletarHoraExtra->exeDelete("adms_hora_extra", "id=:id", "id={$this->HoraExtraId}");
        if ($deletarHoraExtra->getResultado()) {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagemSimples("Agendamento de hora extra excluído com sucesso!", "info");
            $this->Resultado = true;

        } else {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagem("Desculpe! Ocorreu um erro.","A hora extra não foi deletada.", "danger");
            $this->Resultado = false;

        }
    }

}