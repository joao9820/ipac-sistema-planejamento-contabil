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

class AdmsMenu
{
    private $Resultado;

    public function getResultado()
    {
        return $this->Resultado;
    }



    public function itemMenu()
    {
        $listItemMenu = new \App\adms\Models\helper\AdmsRead();
        $listItemMenu->fullRead("SELECT nivpg.dropdown, 
                    men.id id_men, men.nome nome_men, men.icone icone_men, 
                    pg.id id_pg, pg.menu_controller, pg.menu_metodo, pg.nome_pagina, pg.icone icone_pg 
                    FROM adms_nivacs_pgs nivpg 
                    INNER JOIN adms_menus men ON men.id=nivpg.adms_menu_id 
                    INNER JOIN adms_paginas pg ON pg.id=nivpg.adms_pagina_id 
                    INNER JOIN adms_tps_empresas tp_emp ON tp_emp.id=nivpg.adms_tps_empresa_id  
                    WHERE nivpg.adms_niveis_acesso_id =:adms_niveis_acesso_id 
                    AND nivpg.permissao =:permissao 
                    AND nivpg.lib_menu =:lib_menu 
                    AND nivpg.adms_tps_empresa_id =:adms_tps_empresa_id
                    ORDER BY men.ordem, nivpg.ordem ASC ", "adms_niveis_acesso_id=".$_SESSION['adms_niveis_acesso_id']."&permissao=1&lib_menu=1&adms_tps_empresa_id=".$_SESSION['adms_empresa_id']);
        $this->Resultado = $listItemMenu->getResultado();
        //var_dump($this->Resultado);
        return $this->Resultado;
    }

}