<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 11/02/2019
 * Time: 17:11
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsPesqUsuario
{

    private $Resultado;
    private $LimiteResultado = 40;
    private $ResultadoPg;
    private $PesqUsuario;

    function getResultadoPg()
    {
        return $this->ResultadoPg;
    }

    public function pesqUsuario($PesqUsuario = null)
    {
        $this->PesqUsuario = (string) $PesqUsuario;

        $this->ResultadoPg = null;

        $listarUsuario = new AdmsRead();
        $listarUsuario->fullRead("SELECT user.id, user.nome, user.email,
                sit.nome nome_situacao,
                cr.cor 
                FROM adms_usuarios user 
                INNER JOIN adms_sits_usuarios sit ON sit.id=user.adms_sits_usuario_id
                INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id
                INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id
                WHERE nivac.ordem >=:ordem AND (user.nome LIKE '%' :nome '%' OR user.email LIKE '%' :email '%') AND user.adms_empresa_id =:empresa 
                ORDER BY id DESC LIMIT :limit", "ordem=" . $_SESSION['ordem_nivac'] . "&nome=" . $this->PesqUsuario . "&email=" . $this->PesqUsuario . "&empresa=".$_SESSION['adms_empresa_id']. "&limit={$this->LimiteResultado}");
        $this->Resultado = $listarUsuario->getResultado();

        return $this->Resultado;
    }


}