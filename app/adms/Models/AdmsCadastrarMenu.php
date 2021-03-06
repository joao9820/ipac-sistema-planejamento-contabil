<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 00:44
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

class AdmsCadastrarMenu
{

    private $Resultado;
    private $Dados;
    private $UltimoMenu;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function cadMenu(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirMenu();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirMenu()
    {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $this->verUltimoMenu();
        $this->Dados['ordem'] = $this->UltimoMenu[0]['ordem'] + 1;
        $cadNivAc = new AdmsCreate;
        $cadNivAc->exeCreate("adms_menus", $this->Dados);
        if ($cadNivAc->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Item de menu cadastrado!","success");
            $this->Resultado = true;
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("O item de menu não foi cadastrado.","danger");
            $this->Resultado = false;
        }
    }

    private function verUltimoMenu()
    {
        $verMenu = new AdmsRead();
        $verMenu->fullRead("SELECT ordem FROM adms_menus ORDER BY ordem DESC LIMIT :limit", "limit=1");
        $this->UltimoMenu = $verMenu->getResultado();
    }

    /**
     * <b>Listar registros para chave estrangeira:</b> Buscar informações na tabela "adms_sits" para utilizar como chave estrangeira
     */
    public function listarCadastrar()
    {
        $listar = new AdmsRead();

        $listar->fullRead("SELECT id id_sit, nome nome_sit FROM adms_sits ORDER BY nome ASC");
        $registro['sit'] = $listar->getResultado();

        $this->Resultado = ['sit' => $registro['sit']];

        return $this->Resultado;
    }

}