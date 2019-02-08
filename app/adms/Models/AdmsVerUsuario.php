<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 14:08
 */

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsVerUsuario
{

    private $Resultado;
    private $DadosId;

    public function verUsuario($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verUsuario = new \App\adms\Models\helper\AdmsRead();
        $verUsuario->fullRead("SELECT user.*, 
                        nivel_aces.nome nome_nivel_aces, 
                        situacao.nome nome_situacao, 
                        cr.cor 
                        FROM adms_usuarios user 
                        INNER JOIN adms_niveis_acessos nivel_aces ON nivel_aces.id=user.adms_niveis_acesso_id 
                        INNER JOIN adms_sits_usuarios situacao ON situacao.id=user.adms_sits_usuario_id 
                        INNER JOIN adms_cors cr ON cr.id=situacao.adms_cor_id 
                        WHERE user.id =:id AND nivel_aces.ordem >=:ordem LIMIT :limit", "id={$this->DadosId}&ordem=".$_SESSION['ordem_nivac']."&limit=1");
        $this->Resultado = $verUsuario->getResultado();
        return $this->Resultado;
        //var_dump($this->Resultado);
    }
}