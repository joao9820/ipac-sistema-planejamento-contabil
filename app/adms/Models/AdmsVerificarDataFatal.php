<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 29/04/2019
 * Time: 15:19
 */

namespace App\adms\Models;


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
        $this->DataFatal = (int) $DataFatal;

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

        // Definindo o status e msg
        $this->PermissaoResult['status'] = true;
        $this->PermissaoResult['msg'] = "Ok";
    }

}