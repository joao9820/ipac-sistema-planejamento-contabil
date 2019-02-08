<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 05/02/2019
 * Time: 15:09
 */

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsArquivarAtendGerente
{

    private $DadosId;
    private $Dados;

    public function arquivar($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;

        $this->Dados['arquivado_gerente'] = 1;
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAtendi = new \App\adms\Models\helper\AdmsUpdate();
        $upAtendi->exeUpdate("adms_atendimentos", $this->Dados, "WHERE id =:id", "id={$this->DadosId}");
        if ($upAtendi->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-info'>Atendimento arquivado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi possível arquivar o atendimento selecionado!</div>";
            $this->Resultado = false;
        }
    }

    public function desarquivar($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;

        $this->Dados['arquivado_gerente'] = 2;
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