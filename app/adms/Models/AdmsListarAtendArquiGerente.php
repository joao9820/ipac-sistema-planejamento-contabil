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

class AdmsListarAtendArquiGerente
{

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 10; // Define a quantidade de usuarios por páginas
    private $ResultadoPgAq;

    public function getResultadoPgAq()
    {
        return $this->ResultadoPg;
    }

    public function listarAtendimentosArquivados($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'gerenciar-atendimento/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_atendimentos WHERE arquivado_gerente=1");
        $this->ResultadoPg = $paginacao->getResultado();
        //var_dump($this->ResultadoPg);
        $offset = $paginacao->getOffset();


        $listarAtendimento = new \App\adms\Models\helper\AdmsRead();
        $listarAtendimento->fullRead("SELECT aten.id, aten.adms_funcionario_id funcionario, aten.created, 
                        demanda.nome nome_demanda, 
                        situacao.nome nome_situacao, situacao.id id_situacao, 
                        cr.cor, 
                        user.nome cliente, 
                        func.nome funcionario, 
                        emp.fantasia, emp.nome emp_nome 
                        FROM adms_atendimentos aten 
                        LEFT JOIN adms_usuarios func ON func.id=aten.adms_funcionario_id 
                        INNER JOIN adms_usuarios user ON user.id=aten.adms_usuario_id 
                        INNER JOIN adms_empresas emp ON emp.id=aten.adms_empresa_id 
                        INNER JOIN adms_demandas demanda ON demanda.id=aten.adms_demanda_id 
                        INNER JOIN adms_sits_atendimentos situacao ON situacao.id=aten.adms_sits_atendimento_id 
                        INNER JOIN adms_cors cr ON cr.id=situacao.adms_cor_id 
                        WHERE aten.arquivado_gerente=:arquivado_gerente 
                        ORDER BY created DESC LIMIT :limit OFFSET :offset", "arquivado_gerente=1&limit={$this->LimiteResultado}&offset={$offset}");
        $this->Resultado = $listarAtendimento->getResultado();
        //var_dump($this->Resultado);
        return $this->Resultado;
    }

}