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

}