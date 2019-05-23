<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 16:27
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsCampoVazio;
use App\adms\Models\helper\AdmsRead;
use App\adms\Models\helper\AdmsUpdate;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsEditarSitUser
{

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verSitUser($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verSitUser = new AdmsRead();
        $verSitUser->fullRead("SELECT * FROM adms_sits_usuarios
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verSitUser->getResultado();
        return $this->Resultado;
    }

    public function altSitUser(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditSitUser();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditSitUser()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltSitUser = new AdmsUpdate();
        $upAltSitUser->exeUpdate("adms_sits_usuarios", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltSitUser->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Situação de usuário atualizada!","success");
            $this->Resultado = true;
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("A situação de usuário não foi atualizada.","danger");
            $this->Resultado = false;
        }
    }

    /**
     * <b>Listar registros para chave estrangeira:</b> Buscar informações na tabela "adms_cors" para utilizar como chave estrangeira
     */
    public function listarCadastrar()
    {
        $listar = new AdmsRead();

        $listar->fullRead("SELECT id id_cor, nome nome_cor FROM adms_cors ORDER BY nome ASC");
        $registro['cor'] = $listar->getResultado();

        $this->Resultado = ['cor' => $registro['cor']];

        return $this->Resultado;
    }

}