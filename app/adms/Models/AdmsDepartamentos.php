<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 25/03/2019
 * Time: 12:45
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsDepartamentos
{

    private $Dados;
    private $Resultado;

    public function listar()
    {
        $listarDept = new AdmsRead();
        $listarDept->fullRead("SELECT id, nome, icon, descricao FROM adms_departamentos ");
        $this->Resultado = $listarDept->getResultado();
        return $this->Resultado;
    }


}