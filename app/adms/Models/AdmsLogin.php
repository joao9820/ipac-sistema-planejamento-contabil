<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 21/01/2019
 * Time: 15:38
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsLogin
{
    private $Dados;
    private $Resultado;

    public function getResultado()
    {
        return $this->Resultado;
    }


    public function acesso(array $Dados)
    {
        $this->Dados = $Dados;
        //var_dump($this->Dados);
        $this->validarDados();
        if($this->Resultado){
            $validaLogin = new AdmsRead();
            $validaLogin->fullRead("SELECT user.id, user.nome, user.email, user.senha, user.imagem, user.adms_niveis_acesso_id, user.adms_sits_usuario_id, user.adms_empresa_id, 
                                          nivac.ordem ordem_nivac, nivac.nome nome_nivel
                                          FROM adms_usuarios user 
                                          INNER JOIN adms_niveis_acessos nivac ON nivac.id = user.adms_niveis_acesso_id 
                                          WHERE user.usuario =:usuario or user.email =:email LIMIT :limit", "usuario={$this->Dados['usuario']}&email={$this->Dados['usuario']}&limit=1");
            $this->Resultado = $validaLogin->getResultado();
            //var_dump($this->Resultado);
            if(!empty($this->Resultado))
            {

                if ($this->Resultado[0]['adms_sits_usuario_id'] == 3)
                {
                    $alert = new AdmsAlertMensagem();
                    $_SESSION['msg'] = $alert->alertMensagemJavaScript("E-mail não confirmado!","danger");
                    $this->Resultado = false;

                }
                elseif ($this->Resultado[0]['adms_sits_usuario_id'] == 5)
                {
                    $alert = new AdmsAlertMensagem();
                    $_SESSION['msg'] = $alert->alertMensagemJavaScript("Acesso bloqueado!","danger");
                    $this->Resultado = false;

                } else {

                    $this->validarSenha();
                }

            } else {

                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Usuário não encontrado!","danger");
                $this->Resultado = false;

            }
        }
    }

    private function validarDados()
    {
        $this->Dados = array_map('strip_tags', $this->Dados);
        $this->Dados = array_map('trim', $this->Dados);
        if(in_array('', $this->Dados)){
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Necessário preencher todos os campos!","warning");
            $this->Resultado = false;
        } else {

            $this->Resultado = true;

        }

    }

    private function validarSenha()
    {
        if(password_verify($this->Dados['senha'], $this->Resultado[0]['senha'])){
            $_SESSION['usuario_id'] = $this->Resultado[0]['id'];
            $_SESSION['usuario_nome'] = $this->Resultado[0]['nome'];
            $_SESSION['usuario_email'] = $this->Resultado[0]['email'];
            $_SESSION['usuario_imagem'] = $this->Resultado[0]['imagem'];
            $_SESSION['adms_niveis_acesso_id'] = $this->Resultado[0]['adms_niveis_acesso_id'];
            $_SESSION['nome_nivel'] = $this->Resultado[0]['nome_nivel'];
            $_SESSION['ordem_nivac'] = $this->Resultado[0]['ordem_nivac'];
            $_SESSION['adms_empresa_id'] = $this->Resultado[0]['adms_empresa_id'];
            $this->Resultado = true;
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Senha incorreta!","danger");
            $this->Resultado = false;
        }
    }


}