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

class AdmsVerPerfil
{

    private $Resultado;

    public function verPerfil()
    {
        $verPerfil = new AdmsRead();
        $verPerfil->fullRead("SELECT * FROM adms_usuarios WHERE id =:id LIMIT :limit", "id={$_SESSION['usuario_id']}&limit=1");
        $this->Resultado = $verPerfil->getResultado();
        return $this->Resultado;
    }
}