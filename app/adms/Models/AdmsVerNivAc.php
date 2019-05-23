<?php

namespace App\adms\Models;

use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerNivAc
 *
 */
class AdmsVerNivAc
{
    private $Resultado;
    private $DadosId;
    
    public function verNivAc($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verNivAc = new AdmsRead();
        $verNivAc->fullRead("SELECT * FROM adms_niveis_acessos user
                WHERE id =:id AND ordem >=:ordem LIMIT :limit", "id=".$this->DadosId."&ordem=".$_SESSION['ordem_nivac']."&limit=1");
        $this->Resultado= $verNivAc->getResultado();
        return $this->Resultado;
    }
}
