<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 16:37
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsVerSitPg
{

    private $Resultado;
    private $DadosId;

    public function verSitPg($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verSitPg = new AdmsRead();
        $verSitPg->fullRead("SELECT * FROM adms_sits_pgs WHERE id =:id LIMIT :limit", "id=".$this->DadosId."&limit=1");
        $this->Resultado= $verSitPg->getResultado();
        return $this->Resultado;
    }

}