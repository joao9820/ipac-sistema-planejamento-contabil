<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 15:48
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsVerTipoPg
{

    private $Resultado;
    private $DadosId;

    public function verTipoPg($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verTipoPg = new AdmsRead();
        $verTipoPg->fullRead("SELECT * FROM adms_tps_pgs
                WHERE id =:id LIMIT :limit", "id=".$this->DadosId."&limit=1");
        $this->Resultado= $verTipoPg->getResultado();
        return $this->Resultado;
    }

}