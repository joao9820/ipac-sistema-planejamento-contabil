<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 25/04/2019
 * Time: 14:40
 */

namespace App\adms\Models\funcoes;

use DateTime;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class Funcoes
{

    /*
     * Função para converter hora em segundos
     */
    function hora_to_segundos($Hora, $Operacao = null, $Segundos = null)
    {
        $Hora = (string) $Hora;

        $array = [];
        $partes = explode(':', $Hora);
        foreach ($partes as $parte){
            $array[] = (int) $parte;
            //var_dump($array);
        }
        $valor_convertido = $array[0] * 3600 + $array[1] * 60 + $array[2];
        $valor_convertido = (int) $valor_convertido;

        // Caso seja passado por parametro uma operação e um valor pra segundos
        if ($Operacao){
            $Operacao = (string) $Operacao;
            $Segundos = (int) $Segundos;
            if ($Operacao == "+"){
                $valor_convertido += $Segundos;
            } else {
                $valor_convertido -= $Segundos;
            }
        }

        return $valor_convertido;
    }

    /*
     * Função para converter segundos em horas
     */
    function segundos_to_hora($Segundos)
    {
        $Segundos = (int) $Segundos;

        $horas = floor($Segundos / 3600);
        $minutos = floor(($Segundos - ($horas * 3600)) / 60);
        $segundos = floor($Segundos % 60);

        if ($horas < 10){
            $horas = "0".$horas;
        }
        if ($minutos < 10){
            $minutos = "0".$minutos;
        }
        if ($segundos < 10){
            $segundos = "0".$segundos;
        }
        $valor_convertido = $horas . ":" . $minutos . ":" . $segundos;
        $valor_convertido = date('H:i:s', strtotime($valor_convertido));
        return $valor_convertido;
    }

    /*
     * Somar time a uma data
     */
    function somar_time_in_hours($Duracao, $Hora)
    {
        $help = explode(':', $Duracao);
        try {
            $data = new DateTime(date('H:i:s', strtotime($Hora)));
        } catch (\Exception $e) {
            return $e;
        }
        $data->modify('+' . $help[0] . ' hours');
        $data->modify('+' . $help[1] . ' minutes');
        $somaHoraInicio = $data->format('H:i:s');
        $valor_resultado = date('H:i:s', strtotime($somaHoraInicio));

        return $valor_resultado;
    }

    /*
     * Somar time a time
     */
    function sbtrair_horas_in_hours($HoraMaior, $HoraMenor)
    {
        $help = explode(':', $HoraMenor);
        try {
            $data = new DateTime(date('H:i:s', strtotime($HoraMaior)));
        } catch (\Exception $e) {
            return $e;
        }
        $data->modify('-' . $help[0] . ' hours');
        $data->modify('-' . $help[1] . ' minutes');
        $somaHoraInicio = $data->format('H:i:s');
        $valor_resultado = date('H:i:s', strtotime($somaHoraInicio));

        return $valor_resultado;
    }

    /*
     * Somar ou subtrair dias em uma data
     */
    function dia_in_data($Data, $Dias, $Operador = "+")
    {
        $Data = date('Y-m-d', strtotime($Data));
        $Dias = (int) $Dias;
        $Operador = (string) $Operador;

        try {
            $data = new DateTime(date('Y-m-d', strtotime($Data)));
        } catch (\Exception $e) {
            return $e;
        }
        $data->modify($Operador . $Dias . ' days');
        $valor = $data->format('Y-m-d');
        $valor_resultado = date('Y-m-d', strtotime($valor));

        return $valor_resultado;
    }

    /*
     * Verificar se é dia útil
     */
    function isDiaUtil($Data)
    {
        $data = getdate(strtotime($Data));
        if (($data['wday'] == 6) or ($data['wday'] == 0)) {
            return false; // é fim de semana, não é dia útil
        } else {
            if($this->isFeriado($Data)){
                return false;
            } else {
                return true;
            }
        }
    }

    /*
     * Verficicar se é feriado
     */
    function isFeriado($Data)
    {
        $ano = date('Y', strtotime($Data));
        $dia = 86400;
        $datas = array();
        $datas['pascoa'] = easter_date($ano);
        $datas['sexta_santa'] = $datas['pascoa'] - (2 * $dia);
        $datas['carnaval'] = $datas['pascoa'] - (47 * $dia);
        $datas['corpus_cristi'] = $datas['pascoa'] + (60 * $dia);
        $feriados = array (
            '01/01',
            '02/02', // Navegantes
            date('d/m',$datas['carnaval']),
            date('d/m',$datas['sexta_santa']),
            date('d/m',$datas['pascoa']),
            '21/04', // Tiradentes
            '01/05', //  Dia do Trabalho
            date('d/m',$datas['corpus_cristi']),
            '07/09', // Dia da Independência do Brasil - 7 de Setembro
            '12/10', //  Nossa Senhora Aparecida
            '02/11', // Finados
            '15/11', // Proclamação da República
            '25/12', // Natal
        );

        // Percorrer array e verificar se a data informada é feriado
        $diaMes = date('d/m', strtotime($Data));
        foreach ($feriados as $feriado) {
            if ($feriado == $diaMes) {
                return true;
            }
        }
        return false;
    }

}