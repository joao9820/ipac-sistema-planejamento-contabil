<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 08/02/2019
 * Time: 22:42
 */

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class CpAdmsListarUsuario
{

    private $Dados;
    private $Resultado;
    private $PageId;
    private $LimiteResultado = 40;
    private $ResultadoPg;

    function getResultadoPg()
    {
        return $this->ResultadoPg;
    }


    public function pesquisarUsuarios($PageId = null, $Dados = null)
    {
        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;
        var_dump($this->Dados);

        $this->Dados['nome'] = trim($this->Dados['nome']);

        if(!empty($this->Dados['nome']) AND !empty($this->Dados['email'])){

        }elseif(!empty($this->Dados['nome'])){
            $this->pesquisarUsuariosName();
        }elseif(!empty($this->Dados['email'])){

        }
        return $this->Resultado;
    }

    private function pesquisarUsuariosName()
    {
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'usuarios/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(user.id) AS num_result 
                FROM adms_usuarios user
                INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id
                WHERE nivac.ordem >=:ordem", "ordem=".$_SESSION['ordem_nivac']);
        $this->ResultadoPg = $paginacao->getResultado();

        $listarUsuario = new \App\adms\Models\helper\AdmsRead();
        $listarUsuario->fullRead("SELECT user.id, user.nome, user.email,
                sit.nome nome_sit,
                cr.cor cor_cr
                FROM adms_usuarios user 
                INNER JOIN adms_sits_usuarios sit ON sit.id=user.adms_sits_usuario_id
                INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id
                INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id
                WHERE nivac.ordem >=:ordem
                ORDER BY id DESC LIMIT :limit OFFSET :offset", "ordem=".$_SESSION['ordem_nivac']."&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarUsuario->getResultado();
    }

}