<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 20/05/2019
 * Time: 16:27
 */

namespace App\adms\Models\funcoes;

use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class ValidarTipoDeUsuario
{
    private $TipoUsuario;
    private $UsuarioId;
    private $Resultado;

    public function __construct($TipoPerfil, $UsuarioId)
    {
        $TipoUsuario = strtoupper($TipoPerfil);
        switch ($TipoUsuario){
            case "FUNCIONARIO":
                $Tipo = 4;
                break;
            case "CLIENTE":
                $Tipo = 6;
                break;
            case "GERENTE":
                $Tipo = 3;
                break;
            case "ADMINISTRADOR":
                $Tipo = 2;
                break;
            case "ESTAGIARIO":
                $Tipo = 5;
                break;
            default:
                $Tipo = 4;
                break;
        }
        $this->TipoUsuario = (int) $Tipo;
        $this->UsuarioId = (int) $UsuarioId;

        $this->verificarTipo();
    }

    public function getResultado()
    {
        return $this->Resultado;
    }

    /*
     * Verificar se o usuário possui o tipo de perfil informado
     */
    private function verificarTipo()
    {
        $select = new AdmsRead();
        $select->fullRead("SELECT id, nome FROM adms_usuarios WHERE id =:usuario AND adms_niveis_acesso_id =:nivel_acesso","usuario={$this->UsuarioId}&nivel_acesso={$this->TipoUsuario}");
        $this->Resultado = $select->getResultado();

        if (empty($this->Resultado)){
            $this->Resultado = false;
        }

    }

}