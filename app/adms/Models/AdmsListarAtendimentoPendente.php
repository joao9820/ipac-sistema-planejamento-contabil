<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 31/01/2019
 * Time: 16:08
 */

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsListarAtendimentoPendente
{

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 10; // Define a quantidade de usuarios por páginas
    private $ResultadoPg;

    public function getResultadoPg()
    {
        return $this->ResultadoPg;
    }

    public function listarAtendimento($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'atendimento-pendente/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result
                     FROM adms_atendimentos  
                     WHERE adms_funcionario_id =:usuario AND adms_sits_atendimento_id <>:adms_sits_atendimento_id AND prioridade <>:prioridade", "usuario=".$_SESSION['usuario_id']."&adms_sits_atendimento_id=4&prioridade=1");
        $this->ResultadoPg = $paginacao->getResultado();
        $offset = $paginacao->getOffset();


        $listarAtendimento = new \App\adms\Models\helper\AdmsRead();
        $listarAtendimento->fullRead("SELECT aten.id, aten.descricao, aten.created, 
                        demanda.nome demanda, 
                        emp.nome nome_empresa, emp.fantasia fantasia_empresa, 
                        situacao.nome nome_situacao, situacao.id id_situacao, 
                        cr.cor
                        FROM adms_atendimentos aten 
                        INNER JOIN adms_demandas demanda ON demanda.id=aten.adms_demanda_id 
                        INNER JOIN adms_empresas emp ON emp.id=aten.adms_empresa_id 
                        INNER JOIN adms_sits_atendimentos situacao ON situacao.id=aten.adms_sits_atendimento_id 
                        INNER JOIN adms_cors cr ON cr.id=situacao.adms_cor_id 
                        WHERE aten.adms_funcionario_id =:usuario AND aten.adms_sits_atendimento_id <>:adms_sits_atendimento_id AND aten.prioridade <>:prioridade
                        ORDER BY created DESC LIMIT :limit OFFSET :offset", "usuario=".$_SESSION['usuario_id']."&adms_sits_atendimento_id=4&prioridade=1&limit={$this->LimiteResultado}&offset={$offset}");
        $this->Resultado = $listarAtendimento->getResultado();
        //var_dump($this->Resultado);
        return $this->Resultado;


    }

    public function listarAtendimentoUrgente()
    {

        $listarAtendimentoUrgente = new \App\adms\Models\helper\AdmsRead();
        $listarAtendimentoUrgente->fullRead("SELECT aten.id, aten.descricao, aten.created, 
                        demanda.nome demanda, 
                        emp.nome nome_empresa, emp.fantasia fantasia_empresa, 
                        situacao.nome nome_situacao, situacao.id id_situacao, 
                        cr.cor
                        FROM adms_atendimentos aten 
                        INNER JOIN adms_demandas demanda ON demanda.id=aten.adms_demanda_id 
                        INNER JOIN adms_empresas emp ON emp.id=aten.adms_empresa_id 
                        INNER JOIN adms_sits_atendimentos situacao ON situacao.id=aten.adms_sits_atendimento_id 
                        INNER JOIN adms_cors cr ON cr.id=situacao.adms_cor_id 
                        WHERE aten.adms_funcionario_id =:usuario AND aten.adms_sits_atendimento_id <>:adms_sits_atendimento_id AND aten.prioridade =:prioridade
                        ORDER BY created DESC", "usuario=".$_SESSION['usuario_id']."&adms_sits_atendimento_id=4&prioridade=1");
        $this->Resultado = $listarAtendimentoUrgente->getResultado();
        //var_dump($this->Resultado);
        return $this->Resultado;
    }

}