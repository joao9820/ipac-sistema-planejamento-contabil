<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 04/02/2019
 * Time: 12:55
 */

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsDesarquivarAtendimento
{
    private $DadosId;
    private $Dados;

    public function desarquivar($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;

        $this->Dados['arquivado'] = 2;
        $this->Dados['modified'] = date("Y-m-d H:i:s");

        $upAtendi = new \App\adms\Models\helper\AdmsUpdate();
        $upAtendi->exeUpdate("adms_atendimentos", $this->Dados, "WHERE id =:id", "id={$this->DadosId}");
        if ($upAtendi->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-info'>Atendimento desarquivado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi possível desarquivar o atendimento selecionado!</div>";
            $this->Resultado = false;
        }
    }

}