<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 25/01/2019
 * Time: 16:56
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsPaginacao;
use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsListarJorTrabFunc
{
    private $Resultado;
    private $PageId;
    private $LimiteResultado = 50; // Define a quantidade de usuarios por páginas
    private $ResultadoPg;


    public function getResultadoPg()
    {
        return $this->ResultadoPg;
    }


    /**
     * @param null $PageId
     * @return mixed
     */
    public function listarFuncionarios($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new AdmsPaginacao(URLADM . 'usuarios/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(user.id) AS num_result
                     FROM adms_usuarios user 
                     INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id 
                     WHERE user.adms_niveis_acesso_id=:adms_niveis_acesso_id AND nivac.ordem >=:ordem AND user.adms_empresa_id =:empresa", "adms_niveis_acesso_id=4&ordem=".$_SESSION['ordem_nivac']."&empresa=".$_SESSION['adms_empresa_id']);
        $this->ResultadoPg = $paginacao->getResultado();
        $offset = $paginacao->getOffset();


        $listarFunc = new AdmsRead();
        $listarFunc->fullRead("SELECT user.id, user.nome, user.apelido, user.email, user.imagem, user.jornada_de_trabalho, 
                        depto.nome departamento,
                        plan.hora_inicio, plan.hora_termino, plan.hora_inicio2, plan.hora_termino2
                        FROM adms_usuarios user 
                        LEFT JOIN adms_departamentos depto ON depto.id=user.adms_departamento_id
                        LEFT JOIN adms_planejamento plan ON plan.adms_funcionario_id=user.id
                        INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id
                        WHERE user.adms_niveis_acesso_id=:adms_niveis_acesso_id AND nivac.ordem >=:ordem AND user.adms_empresa_id =:empresa
                        ORDER BY user.nome ASC LIMIT :limit OFFSET :offset", "adms_niveis_acesso_id=4&ordem=".$_SESSION['ordem_nivac']."&empresa=".$_SESSION['adms_empresa_id']."&limit={$this->LimiteResultado}&offset={$offset}");
        $this->Resultado = $listarFunc->getResultado();
        //var_dump($this->Resultado);
        return $this->Resultado;
    }


}