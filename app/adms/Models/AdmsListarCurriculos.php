<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsListarCurriculos
{

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 40;
    private $ResultadoPg;
    
    function getResultadoPg()
    {
        return $this->ResultadoPg;
    }

    
    public function listarCurriculo()
    {
               
        $listarCurriculos = new \App\adms\Models\helper\AdmsRead();
        $listarCurriculos->fullRead("SELECT *
                FROM curriculo
                ORDER BY id DESC");
        $this->Resultado = $listarCurriculos->getResultado();
        return $this->Resultado;
    }

}
