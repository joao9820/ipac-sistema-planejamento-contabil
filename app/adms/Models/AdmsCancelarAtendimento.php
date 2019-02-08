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

class AdmsCancelarAtendimento
{
    private $DadosId;
    private $Dados;

    public function cancelar($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->Dados['cancelado_p_user'] = 1;
        $this->Dados['adms_sits_atendimento_id'] = 4;
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAtendi = new \App\adms\Models\helper\AdmsUpdate();
        $upAtendi->exeUpdate("adms_atendimentos", $this->Dados, "WHERE id =:id", "id={$this->DadosId}");
        if ($upAtendi->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Atendimento cancelado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi possível cancelar o atendimento selecionado!</div>";
            $this->Resultado = false;
        }
    }

}