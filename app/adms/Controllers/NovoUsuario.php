<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 22/01/2019
 * Time: 16:50
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsNovoUsuario;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class NovoUsuario
{
    private $Dados;

    public function novoUsuario()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadUserLogin'])) {
            unset($this->Dados['CadUserLogin']);
            $cadUser = new AdmsNovoUsuario();
            $cadUser->cadUser($this->Dados);
            if ($cadUser->getResultado()) {
                $UrlDestino = URLADM . 'login/acesso';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $carregarView = new ConfigView("adms/Views/login/novoUsuario", $this->Dados);
                $carregarView->renderizarLogin();
            }
        } else {
            $carregarView = new ConfigView("adms/Views/login/novoUsuario", $this->Dados);
            $carregarView->renderizarLogin();
        }
    }

}