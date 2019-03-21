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

class AdmsListarJorTrabFunc
{
    private $Resultado;
    private $PageId;
    private $LimiteResultado = 40; // Define a quantidade de usuarios por páginas
    private $ResultadoPg;


    public function getResultadoPg()
    {
        return $this->ResultadoPg;
    }



    public function listarFuncionarios($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'usuarios/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(user.id) AS num_result
                     FROM adms_usuarios user 
                     INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id 
                     WHERE user.adms_niveis_acesso_id=:adms_niveis_acesso_id AND nivac.ordem >=:ordem AND user.adms_empresa_id =:empresa", "adms_niveis_acesso_id=4&ordem=".$_SESSION['ordem_nivac']."&empresa=".$_SESSION['adms_empresa_id']);
        $this->ResultadoPg = $paginacao->getResultado();
        $offset = $paginacao->getOffset();


        $listarFunc = new \App\adms\Models\helper\AdmsRead();
        $listarFunc->fullRead("SELECT user.id, user.nome, user.apelido, user.jornada_de_trabalho, 
                        depto.nome departamento, 
                        carg.cargo
                        FROM adms_usuarios user 
                        LEFT JOIN adms_departamentos depto ON depto.id=user.adms_departamento_id
                        LEFT JOIN adms_cargos carg ON carg.id=user.adms_cargo_id
                        INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id
                        WHERE user.adms_niveis_acesso_id=:adms_niveis_acesso_id AND nivac.ordem >=:ordem AND user.adms_empresa_id =:empresa
                        ORDER BY user.nome ASC LIMIT :limit OFFSET :offset", "adms_niveis_acesso_id=4&ordem=".$_SESSION['ordem_nivac']."&empresa=".$_SESSION['adms_empresa_id']."&limit={$this->LimiteResultado}&offset={$offset}");
        $this->Resultado = $listarFunc->getResultado();
        //var_dump($this->Resultado);
        return $this->Resultado;
    }


}