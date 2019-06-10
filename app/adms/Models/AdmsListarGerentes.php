<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 10/06/2019
 * Time: 16:46
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsListarGerentes
{

    private $Resultado;

    public function __construct()
    {
        $this->getGerentes();
    }

    public function getResultado()
    {
        return $this->Resultado;
    }

    private function getGerentes()
    {
        $select = new AdmsRead();
        $select->fullRead("SELECT id, nome, email, imagem FROM adms_usuarios WHERE adms_niveis_acesso_id =:gerente","gerente=3");
        if ($select->getResultado()){
            $this->Resultado = $select->getResultado();
        } else {
            $this->Resultado = false;
        }
    }

}