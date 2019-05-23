<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 13:51
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsVerCor
{

    private $Resultado;
    private $DadosId;

    public function verCor($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verCor = new AdmsRead();
        $verCor->fullRead("SELECT * FROM adms_cors 
                WHERE id =:id LIMIT :limit", "id=".$this->DadosId."&limit=1");
        $this->Resultado= $verCor->getResultado();
        return $this->Resultado;
    }

}