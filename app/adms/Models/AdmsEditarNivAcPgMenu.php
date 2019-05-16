<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 02/02/2019
 * Time: 21:23
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

class AdmsEditarNivAcPgMenu
{

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verNivAcPg($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verNivAcPg = new AdmsRead();
        $verNivAcPg->fullRead("SELECT * FROM adms_nivacs_pgs
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verNivAcPg->getResultado();
        return $this->Resultado;
    }

    public function altMenu(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditMenu();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditMenu()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltNivAc = new AdmsUpdate();
        $upAltNivAc->exeUpdate("adms_nivacs_pgs", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltNivAc->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Item de menu da página atualizado!","success");
            $this->Resultado = true;
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("O item de menu da página não foi atualizado.","danger");
            $this->Resultado = false;
        }
    }

    /**
     * <b>Listar registros para chave estrangeira:</b> Buscar informações na tabela "adms_menus" para utilizar como chave estrangeira
     */
    public function listarCadastrar()
    {
        $listar = new AdmsRead();

        $listar->fullRead("SELECT id id_menu, nome nome_menu FROM adms_menus ORDER BY nome ASC");
        $registro['menu'] = $listar->getResultado();

        $this->Resultado = ['menu' => $registro['menu']];

        return $this->Resultado;
    }

}