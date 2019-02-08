<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 23/01/2019
 * Time: 12:39
 */

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EsqueceuSenha
{

    private $Dados;

    public function esqueceuSenha()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['RecupUserLogin'])){

            $esqSenha = new \App\adms\Models\AdmsEsqueceuSenha();
            $esqSenha->esqueceuSenha($this->Dados);
            if($esqSenha->getResultado())
            {

                $UrlDestino = URLADM . 'login/acesso';
                header("Location: $UrlDestino");

            }
            else
                {
                    $this->Dados['form'] = $this->Dados;
                    $carregarView = new \Core\ConfigView("adms/Views/login/esqueceuSenha", $this->Dados);
                    $carregarView->renderizarLogin();

                }

        } else
            {

                $carregarView = new \Core\ConfigView("adms/Views/login/esqueceuSenha", $this->Dados);
                $carregarView->renderizarLogin();

            }


    }
}