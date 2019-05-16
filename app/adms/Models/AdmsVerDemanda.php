<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 14:08
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsVerDemanda
{

    private $Resultado;
    private $DadosId;

    public function verDemanda($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verDemanda = new AdmsRead();
        $verDemanda->fullRead("SELECT dmd.*, 
                        user.nome nome_usuario 
                        FROM adms_demandas dmd 
                        INNER JOIN adms_usuarios user ON user.id=dmd.adms_usuario_id 
                        WHERE dmd.id =:id LIMIT :limit", "id={$this->DadosId}&limit=1");
        $this->Resultado = $verDemanda->getResultado();
        return $this->Resultado;
        //var_dump($this->Resultado);
    }
}