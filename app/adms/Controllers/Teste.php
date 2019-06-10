<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 04/06/2019
 * Time: 13:43
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsCalcularAlocacaoAtividade;
use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class Teste
{

    /*
     * Utilizar para executar funções de teste
     */
    public function index()
    {
        /*
        // Buscar todas as atividades do banco com status finalizada 4
        $select = new AdmsRead();
        $select->fullRead("SELECT id, adms_funcionario_id as funcionario_id FROM adms_atendimento_funcionarios WHERE adms_sits_atendimentos_funcionario_id =:idSits","idSits=4");
        $dados = $select->getResultado();

        foreach ($dados as $dado){
            //echo $dado['id']. "-" . $dado['funcionario_id'] . "<br>";
            $calcularAlocacao = new AdmsCalcularAlocacaoAtividade($dado['id'], $dado['funcionario_id']);
            if($calcularAlocacao->getResultadoAlocacao()){
                echo "Ok<br>";
            } else {
                echo "Erro na atividade: " . $dado['id'] . "<br>";
            }
        }
        */
    }

}