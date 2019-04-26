<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 31/01/2019
 * Time: 16:08
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsPaginacao;
use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsListarAtendGerente
{

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 10; // Define a quantidade de usuarios por páginas
    private $ResultadoPg;

    public function getResultadoPg()
    {
        return $this->ResultadoPg;
    }

    public function listarAtendimentos($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new AdmsPaginacao(URLADM . 'gerenciar-atendimento/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_atendimentos WHERE arquivado_gerente <>:arquivado_gerente","arquivado_gerente=1");
        $this->ResultadoPg = $paginacao->getResultado();
        $offset = $paginacao->getOffset();


        $listarAtendimento = new AdmsRead();
        $listarAtendimento->fullRead("SELECT aten.id, aten.adms_demanda_id, aten.created, 
            demanda.nome nome_demanda, 
            situacao.nome nome_situacao, situacao.id id_situacao, 
            cr.cor, 
            user.nome cliente, 
            emp.fantasia, emp.nome emp_nome,
            totalAtiv.total_atividade,
            totalConclu.total_atividade_concluida
            FROM adms_atendimentos aten 
            INNER JOIN adms_usuarios user ON user.id=aten.adms_usuario_id 
            INNER JOIN adms_empresas emp ON emp.id=aten.adms_empresa_id 
            INNER JOIN adms_demandas demanda ON demanda.id=aten.adms_demanda_id 
            INNER JOIN adms_sits_atendimentos situacao ON situacao.id=aten.adms_sits_atendimento_id 
            INNER JOIN adms_cors cr ON cr.id=situacao.adms_cor_id 
            
            LEFT JOIN (SELECT adms_atendimento_id, COUNT(adms_atividade_id) AS total_atividade
            FROM  adms_atendimento_funcionarios
            GROUP BY adms_atendimento_id) totalAtiv ON totalAtiv.adms_atendimento_id = aten.id
            
            LEFT JOIN (SELECT adms_atendimento_id, COUNT(adms_atividade_id) AS total_atividade_concluida
            FROM  adms_atendimento_funcionarios
            WHERE adms_sits_atendimentos_funcionario_id = 4
            GROUP BY adms_atendimento_id) totalConclu ON totalConclu.adms_atendimento_id = aten.id
    
            WHERE aten.arquivado_gerente <>:arquivado_gerente 
            ORDER BY created DESC LIMIT :limit OFFSET :offset", "arquivado_gerente=1&limit={$this->LimiteResultado}&offset={$offset}");
        $this->Resultado = $listarAtendimento->getResultado();
        //var_dump($this->Resultado);
        return $this->Resultado;
    }

}