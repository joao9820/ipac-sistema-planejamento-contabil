<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 25/04/2019
 * Time: 14:26
 * @param $Hora
 * @param null $Operacao
 * @param null $Segundos
 * @return float|int|mixed
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
