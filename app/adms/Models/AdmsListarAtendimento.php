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

class AdmsListarAtendimento
{

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 15; // Define a quantidade de usuarios por páginas
    private $ResultadoPg;
    private $ResultadoArquivado;

    public function getResultadoPg()
    {
        return $this->ResultadoPg;
    }

    public function getResultadoArquivado()
    {
        return $this->ResultadoArquivado;
    }

    public function listarAtendimento($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new AdmsPaginacao(URLADM . 'atendimento/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result
                     FROM adms_atendimentos  
                     WHERE adms_usuario_id =:usuario AND arquivado<>:arquivado", "usuario=".$_SESSION['usuario_id']."&arquivado=1");
        $this->ResultadoPg = $paginacao->getResultado();
        $offset = $paginacao->getOffset();


        // Contar numero de atendimentos arquivados
        $qtd_arquivado = new AdmsRead();
        $qtd_arquivado->fullRead("SELECT COUNT(id) AS num_result_arquivado FROM adms_atendimentos 
                                  WHERE adms_usuario_id =:usuario AND arquivado=:arquivado", "usuario=".$_SESSION['usuario_id']."&arquivado=1");
        $this->ResultadoArquivado = $qtd_arquivado->getResultado();


        $listarAtendimento = new AdmsRead();
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
                        WHERE aten.adms_usuario_id =:usuario AND arquivado<>:arquivado 
                        ORDER BY created DESC LIMIT :limit OFFSET :offset", "usuario=".$_SESSION['usuario_id']."&arquivado=1&limit={$this->LimiteResultado}&offset={$offset}");
        $this->Resultado = $listarAtendimento->getResultado();
        //var_dump($this->Resultado);
        return $this->Resultado;

    }


    public function listarAtendimentoArquivado($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new AdmsPaginacao(URLADM . 'atendimento/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result
                     FROM adms_atendimentos  
                     WHERE adms_usuario_id =:usuario AND arquivado=:arquivado", "usuario=".$_SESSION['usuario_id']."&arquivado=1");
        $this->ResultadoPg = $paginacao->getResultado();
        $offset = $paginacao->getOffset();


        $listarAtendimento = new AdmsRead();
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
                        WHERE aten.adms_usuario_id =:usuario AND arquivado=:arquivado 
                        ORDER BY created DESC LIMIT :limit OFFSET :offset", "usuario=".$_SESSION['usuario_id']."&arquivado=1&limit={$this->LimiteResultado}&offset={$offset}");
        $this->Resultado = $listarAtendimento->getResultado();
        //var_dump($this->Resultado);
        return $this->Resultado;
    }

}