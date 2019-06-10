<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 21/05/2019
 * Time: 17:31
 */

namespace App\adms\Models;

use App\adms\Models\funcoes\Funcoes;
use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsAlocacaoGerentes
{
    private $Dados;
    private $DadosAlocacao;
    private $Gerentes;
    private $DataInicio;
    private $DataFim;

    public function __construct($DataInicio = null, $DataFim = null)
    {
        if (empty($DataInicio)) {
            $novaData = new Funcoes();
            $this->DataFim = date('Y-m-d');
            $this->DataInicio = $novaData->dia_in_data(date('Y-m-d'),15, '-');
        } else {
            $this->DataInicio = date('Y-m-d', strtotime($DataInicio));
            $this->DataFim = date('Y-m-d', strtotime($DataFim));
        }

        $this->buscarDadosGerentes();
    }

    function getGerentes()
    {
        return !empty($this->Gerentes) ? $this->Gerentes : false;
    }

    /*
     * Buscar todos os usuários gerente
     */
    private function buscarDadosGerentes()
    {

        $select = new AdmsRead();
        $select->fullRead("SELECT id, nome FROM adms_usuarios WHERE adms_niveis_acesso_id =:gerente","gerente=3");

        $resultado = $select->getResultado();

        // Criando um array com todos os gerentes
        if (!empty($resultado)){
            foreach ($resultado as $key => $value){
                $this->Gerentes[$value['id']] = $value;

                $alocacao = new AdmsAlocacaoFuncionariosGerente($value['id'], $this->DataInicio, $this->DataFim);
                $this->Dados[$value['id']] = $alocacao->getDadosAlocacao();
            }

            $alocacao_atividade = 0;
            $alocacao_jornada = 0;
            // Somando a alocação de todos os funcionarios do gerente
            foreach ($this->Gerentes as $key => $value){
                if (!empty($this->Dados[$key])) {
                    foreach ($this->Dados[$key] as $key2 => $value2) {
                        // Converter segundos para minutos
                        $alocacao_atividade += $value2['duracao_atividade_sc'] / 60;
                        $alocacao_jornada += $value2['duracao_total_jornada'] / 60;
                    }
                }
                $this->Gerentes[$key]['percentual_alocacao'] = $alocacao_atividade > 0 ? ($alocacao_atividade / $alocacao_jornada) * 100 : 0;
                $this->Gerentes[$key]['duracao_atividades'] = $alocacao_atividade;
                $alocacao_atividade = 0;
                $this->Gerentes[$key]['duracao_jornada'] = $alocacao_jornada;
                $alocacao_jornada = 0;
            }
        }

    }

}