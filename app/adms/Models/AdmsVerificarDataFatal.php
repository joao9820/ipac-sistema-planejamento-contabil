<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 29/04/2019
 * Time: 15:19
 */

namespace App\adms\Models;


use App\adms\Models\funcoes\BuscarDuracaoAtividades;
use App\adms\Models\funcoes\BuscarDuracaoJornadaT;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsVerificarDataFatal
{
    private $Funcionario_id;
    private $DataFatal;
    private $PermissaoResult;

    public function __construct($Funcionario_id, $DataFatal)
    {
        $this->Funcionario_id = (int) $Funcionario_id;
        $this->DataFatal = date('Y-m-d',strtotime($DataFatal));

        $this->verificar();
    }

    public function getPermissaoResult()
    {
        //$this->Permissao = ['status'=>'','msg'=>''];
        return $this->PermissaoResult;
    }

    /*
     * Verificar se a data fatal escolhida pode ser definida ao funcionário
     * O calulo é feito com base na soma das atividades pendentes até a
     * data fatal escolhida.
     * Caso essa soma ainda tenha tempo livre para adicionar a tividade,
     * um status ok será retornando e a atividade poderá ser registrada
     * com a data fatal informada.
     */
    private function verificar()
    {

        // buscando a duração das atividades
        $buscar_duracao_ati = new BuscarDuracaoAtividades($this->Funcionario_id, $this->DataFatal);
        if ($buscar_duracao_ati->getDuracaoAtividade()['status']){
            $duracao_ativ_do_dia = (int)$buscar_duracao_ati->getDuracaoAtividade()['duracao_atividade_sc'];
        } else {
            $duracao_ativ_do_dia = 0;
        }

        // buscar jornada de trabalho
        $buscar_jornada = new BuscarDuracaoJornadaT($this->Funcionario_id, $this->DataFatal);
        if ($buscar_jornada->getDuracaoJornada()['status']){
            $duracao_jornada = (int)$buscar_jornada->getDuracaoJornada()['total'];
        } else {
            $duracao_jornada = 0;
        }


        echo $duracao_ativ_do_dia ."<br>";
        echo $duracao_jornada;
        die;
        // Definindo o status e msg
        $this->PermissaoResult['status'] = true;
        $this->PermissaoResult['msg'] = "Ok";
    }

}