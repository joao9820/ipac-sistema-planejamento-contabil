<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 25/01/2019
 * Time: 16:56
 */

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsListarUsuario
{
    private $Resultado;
    private $PageId;
    private $LimiteResultado = 15; // Define a quantidade de usuarios por páginas
    private $ResultadoPg;


    public function getResultadoPg()
    {
        return $this->ResultadoPg;
    }



    public function listarUsuario($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'usuarios/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(user.id) AS num_result
                     FROM adms_usuarios user 
                     INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id 
                     WHERE user.id <>:usuario AND nivac.ordem >=:ordem AND user.adms_empresa_id =:empresa", "usuario=".$_SESSION['usuario_id']."&ordem=".$_SESSION['ordem_nivac']."&empresa=".$_SESSION['adms_empresa_id']);
        $this->ResultadoPg = $paginacao->getResultado();
        $offset = $paginacao->getOffset();


        $listarUsuario = new \App\adms\Models\helper\AdmsRead();
        $listarUsuario->fullRead("SELECT user.id, user.nome, user.email,
                        sit.nome nome_sit,
                        cr.cor cor_cr
                        FROM adms_usuarios user 
                        INNER JOIN adms_sits_usuarios sit ON sit.id=user.adms_sits_usuario_id
                        INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id
                        INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id
                        WHERE user.id <>:usuario AND nivac.ordem >=:ordem AND user.adms_empresa_id =:empresa
                        ORDER BY id DESC LIMIT :limit OFFSET :offset", "usuario=".$_SESSION['usuario_id']."&ordem=".$_SESSION['ordem_nivac']."&empresa=".$_SESSION['adms_empresa_id']."&limit={$this->LimiteResultado}&offset={$offset}");
        $this->Resultado = $listarUsuario->getResultado();
        //var_dump($this->Resultado);
        return $this->Resultado;
    }


}