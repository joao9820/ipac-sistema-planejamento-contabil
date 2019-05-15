<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 20/02/2019
 * Time: 13:23
 */

namespace App\adms\Models\helper;
if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsAlertMensagem
{
    private $TextoNegrito;
    private $Texto;
    private $Cor;
    private $DadosCor;

    public function alertMensagem($TextoNegrito = null, $Texto = null, $Cor = null)
    {
        $this->TextoNegrito = (string) $TextoNegrito;
        $this->Texto = (string) $Texto;
        $this->Cor = (string) $Cor ? $Cor : "primary";

        $this->DadosCor = "<div class='alert alert-{$this->Cor} alert-dismissible fade show' role='alert'>
          <strong>{$this->TextoNegrito}</strong> {$this->Texto}!
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>";

        return $this->DadosCor;

    }

    public function alertMensagemSimples($Texto = null, $Cor = null)
    {

        $this->Texto = (string) $Texto;
        $this->Cor = (string) $Cor ? $Cor : "primary";

        $this->DadosCor = "<div class='alert alert-{$this->Cor} alert-dismissible fade show' role='alert'>
          {$this->Texto}!
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>";

        return $this->DadosCor;

    }


    public function alertMensagemJavaScript( $Texto = null, $Cor = null)
    {


        $texto = (string) $Texto;
        $cor = (string) $Cor ? $Cor : "primary";

        if ($cor == "success"){
            $textoNegrito = "Sucesso";
            $icone = "fas fa-check-circle";
        } elseif ($cor == "danger") {
            $textoNegrito = "Erro";
            $icone = "fas fa-times-circle";
        } elseif ($cor == "primary"){
            $textoNegrito = "Alerta";
            $icone = "fas fa-check-circle";
        } else {
            $textoNegrito = "Aviso";
            $icone = "fas fa-exclamation-triangle";
        }

        $this->DadosCor =
            "
            <div id='mensagemCard' class='card border-{$cor} bg-{$cor} d-none'>
                <div class='card-body text-light text-center' style='position: relative; min-width: 300px !important;'>
                    <div onclick='fecharAgora()' class='text-right' style='position: absolute; top: 5px; right: 10px'>
                        <i class='fas fa-times' style='cursor: pointer;'></i>
                    </div>
                    <i class='{$icone} fa-2x'></i>
                    <h5 class='card-title' >{$textoNegrito}</h5>
                    <p class='card-text'>{$texto}</p>
                </div>
            </div>
            ";

        return $this->DadosCor;

    }

}