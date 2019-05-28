<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 21/01/2019
 * Time: 14:20
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsLogin;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class Login
{
    private $Dados;

    public function acesso()
    {

        if (isset($_SESSION['usuario_id'])){
            if ($_SESSION['adms_niveis_acesso_id'] == 4){
                $UrlDestino = URLADM . 'atendimentos/listar';
                header("Location: $UrlDestino");
            } elseif ($_SESSION['adms_niveis_acesso_id'] <= 3){
                $UrlDestino = URLADM . 'gerenciar-atendimento/listar';
                header("Location: $UrlDestino");
            }else {
                $UrlDestino = URLADM . 'home/index';
                header("Location: $UrlDestino");
            }
        }



        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if(!empty($this->Dados['SendLogin'])){
            unset($this->Dados['SendLogin']);
            $visualLogin = new AdmsLogin();
            $visualLogin->acesso($this->Dados);
            if($visualLogin->getResultado()){

                if ($_SESSION['adms_niveis_acesso_id'] == 4){
                    $UrlDestino = URLADM . 'atendimentos/listar';
                    header("Location: $UrlDestino");
                } elseif ($_SESSION['adms_niveis_acesso_id'] <= 3){
                    $UrlDestino = URLADM . 'gerenciar-atendimento/listar';
                    header("Location: $UrlDestino");
                }else {
                    $UrlDestino = URLADM . 'home/index';
                    header("Location: $UrlDestino");
                }
            }else{
                $this->Dados['form'] = $this->Dados;
            }
        }
        $carregarView = new ConfigView("adms/Views/login/acesso", $this->Dados);
        $carregarView->renderizarLogin();
    }

    public function logout()
    {
        unset($_SESSION['usuario_id'], $_SESSION['usuario_nome'], $_SESSION['usuario_email'], $_SESSION['usuario_imagem'], $_SESSION['adms_niveis_acesso_id'], $_SESSION['ordem_nivac']);
        $alert = new AdmsAlertMensagem();
        $_SESSION['msg'] = $alert->alertMensagemJavaScript("Deslogado! Sessão Encerrada.","success");
        $UrlDestino = URLADM .'login/acesso';
        header("Location: $UrlDestino");
    }


}