<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 01:04
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsVerMenu
{

    private $Resultado;
    private $DadosId;

    public function verMenu($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verMenu = new AdmsRead();
        $verMenu->fullRead("SELECT men.*,
                sit.nome nome_sit,
                cr.cor cor_cr
                FROM adms_menus men
                INNER JOIN adms_sits sit ON sit.id=men.adms_sit_id
                INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id
                WHERE men.id =:id LIMIT :limit", "id=".$this->DadosId."&limit=1");
        $this->Resultado= $verMenu->getResultado();
        return $this->Resultado;
    }

}