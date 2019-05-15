<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 22/01/2019
 * Time: 14:08
 */

namespace App\adms\Models\helper;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsValCampoUnico
{

    private $Tabela;
    private $Campo;
    private $Resultado;
    private $EditarUnico;
    private $DadoId;
    private $Dados;


    function getResultado()
    {
        return $this->Resultado;
    }

    public function valCampo($Tabela, $Coluna, $Dados,$EditarUnico = null, $DadoId = null)
    {
        $this->Dados = (string) $Dados;
        $this->Tabela = (string) $Tabela;
        $this->Coluna = (string) $Coluna;
        $this->EditarUnico = $EditarUnico;
        $this->DadoId = $DadoId;

        $valCampo = new AdmsRead();
        if (!empty($this->EditarUnico) AND ($this->EditarUnico == true)) {

            $valCampo->fullRead("SELECT id FROM {$this->Tabela} WHERE {$this->Coluna} =:dados AND id <>:id LIMIT :limit", "dados={$this->Dados}&limit=1&id={$this->DadoId}");

        } else  {

            $valCampo->fullRead("SELECT id FROM {$this->Tabela} WHERE {$this->Coluna} =:dados LIMIT :limit", "dados={$this->Dados}&limit=1");

        }

        $this->Resultado = $valCampo->getResultado();
        if(!empty($this->Resultado)){
            //Se o $this->Resultado diferente de vazio significa que encontrou dados
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Dados já cadastrado!","danger");
            $this->Resultado = false;

        } else {
            $this->Resultado = true;
        }
    }

}