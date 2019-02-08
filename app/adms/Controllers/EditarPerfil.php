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


class EditarPerfil
{

    private $Dados;

    public function altPerfil()
    {
        // Recebendo os dados do formulario da View
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['EditPerfil']))
        {
            unset($this->Dados['EditPerfil']);
            //var_dump($this->Dados);

            $this->Dados['imagem'] = ($_FILES['imagem'] ? $_FILES['imagem'] : null);
            $altPerfilBd = new \App\adms\Models\AdmsEditarPerfil();
            $altPerfilBd->altPerfil($this->Dados);
            if ($altPerfilBd->getResultado()) {

                $UrlDestino = URLADM . 'ver-perfil/perfil';
                header("Location: $UrlDestino");

            } else {

                $this->Dados['form'] = $this->Dados;
                $this->altPerfilPriv();

            }

        }
        else {

            $verPerfil = new \App\adms\Models\AdmsVerPerfil();
            $this->Dados['form'] = $verPerfil->verPerfil();
            $this->altPerfilPriv();


        }


    }

    private function altPerfilPriv()
    {

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/usuario/editPerfil", $this->Dados);
        $carregarView->renderizar();

    }

}