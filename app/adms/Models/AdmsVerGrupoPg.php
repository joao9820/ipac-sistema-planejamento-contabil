<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 15:27
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsVerGrupoPg
{

    private $Resultado;
    private $DadosId;

    public function verGrupoPg($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verGrupoPg = new AdmsRead();
        $verGrupoPg->fullRead("SELECT * FROM adms_grps_pgs
                WHERE id =:id LIMIT :limit", "id=".$this->DadosId."&limit=1");
        $this->Resultado= $verGrupoPg->getResultado();
        return $this->Resultado;
    }

}