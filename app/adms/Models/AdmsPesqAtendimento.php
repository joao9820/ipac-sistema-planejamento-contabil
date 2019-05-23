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


class AdmsPesqAtendimento
{

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 40;
    private $ResultadoPg;
    private $PesqAtendimento;

    function getResultadoPg()
    {
        return $this->ResultadoPg;
    }

    public function pesqAtendimento($PesqAtendimento = null)
    {
        $this->PesqAtendimento = (string) $PesqAtendimento;

        $this->ResultadoPg = null;

        $listarAtendimento = new AdmsRead();
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
                        WHERE aten.arquivado_gerente <>:arquivado_gerente AND (user.nome LIKE '%' :nome '%' OR func.nome LIKE '%' :funcionario '%' OR demanda.nome LIKE '%' :demanda '%' OR emp.fantasia LIKE '%' :fantasia '%' OR aten.created LIKE '%' :created '%') 
                        ORDER BY id DESC LIMIT :limit", "arquivado_gerente=1&limit={$this->LimiteResultado}" . "&nome=" . $this->PesqAtendimento . "&funcionario=" . $this->PesqAtendimento . "&demanda=" . $this->PesqAtendimento . "&fantasia=" . $this->PesqAtendimento . "&created=" . $this->PesqAtendimento . "&limit={$this->LimiteResultado}");
        $this->Resultado = $listarAtendimento->getResultado();
        return $this->Resultado;
    }


}