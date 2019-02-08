<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 11:42
 */

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsBotao
{
    private $Resultado;
    private $Botao;
    private $BotaoValido = [];

    public function getResultado()
    {
        return $this->Resultado;
    }



    public function valBotao(array $Botao)
    {
        $this->Botao = $Botao;
        foreach ($this->Botao as $key => $botao_unico) {
            extract($botao_unico);
            $verBotao = new \App\adms\Models\helper\AdmsRead();
            $verBotao->fullRead("SELECT pg.id id_pg
                                        FROM adms_paginas pg 
                                        LEFT JOIN adms_nivacs_pgs nivpg ON nivpg.adms_pagina_id=pg.id 
                                        WHERE pg.menu_controller =:menu_controller 
                                        AND pg.menu_metodo =:menu_metodo 
                                        AND pg.adms_sits_pg_id = 1 
                                        AND nivpg.adms_niveis_acesso_id =:adms_niveis_acesso_id 
                                        AND nivpg.permissao = 1 LIMIT :limit", "menu_controller=$menu_controller&menu_metodo=$menu_metodo&adms_niveis_acesso_id=".$_SESSION['adms_niveis_acesso_id']."&limit=1");
            if ($verBotao->getResultado()) {
                $this->BotaoValido[$key] = true;
            } else {
                $this->BotaoValido[$key] = false;
            }

        }
        return $this->BotaoValido;

    }

}