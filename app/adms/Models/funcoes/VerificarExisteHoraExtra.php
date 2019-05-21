<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 21/05/2019
 * Time: 13:27
 */

namespace App\adms\Models\funcoes;

use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class VerificarExisteHoraExtra
{
    private $FuncionarioId;
    private $Data;
    private $Resultado;

    public function __construct($FuncionarioId, $Data)
    {
        $this->verificarHoraExtra($FuncionarioId, $Data);
    }

    function getResultadoHoraExtra()
    {
        return $this->Resultado;
    }

    /*
     * Verificar se existe hora extra
     */
    private function verificarHoraExtra($FuncionarioId, $Data) {
        $verificar = new AdmsRead();
        $verificar->fullReadRowCount("SELECT id
                                    FROM adms_hora_extra 
                                    WHERE adms_usuario_id =:id
                                    AND data =:data_d", "id={$FuncionarioId}&data_d={$Data}");
        $qtdLinha = $verificar->getResultado();
        $this->Resultado = $qtdLinha > 0 ? true : false; // se a quantidade de linha obtida for maior que 0 então, a busca retornou registro
    }
}