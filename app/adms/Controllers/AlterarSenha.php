<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 15:05
 */

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AlterarSenha
{

    
    private $Dados;

    public function altSenha()
    {
        // Recebendo os dados do formulario da View
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['AltSenha']))
        {
            unset($this->Dados['AltSenha']);
            $altSenhaBd = new \App\adms\Models\AdmsAlterarSenha();
            $altSenhaBd->altSenha($this->Dados);
            if ($altSenhaBd->getResultado()) {

                $UrlDestino = URLADM . 'ver-perfil/perfil';
                header("Location: $UrlDestino");

            }
            else {

                $listarMenu = new \App\adms\Models\AdmsMenu();
                $this->Dados['menu'] = $listarMenu->itemMenu();

                $carregarView = new \Core\ConfigView("adms/Views/usuario/alterarSenha", $this->Dados);
                $carregarView->renderizar();

            }

        }
        else {

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/usuario/alterarSenha", $this->Dados);
            $carregarView->renderizar();


        }



    }

}