<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 02/04/2019
 * Time: 16:57
 */

namespace App\adms\Controllers;

use \App\adms\Models\AdmsPlanejamento;
use \App\adms\Models\helper\AdmsAlertMensagem;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class Planejamento
{
    private $Dados;

    public function editar()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->Dados['EditPlanejamento'])){
            unset($this->Dados['EditPlanejamento']);
            //var_dump($this->Dados);
            //die;
            $atualizar = new AdmsPlanejamento();
            $atualizar->atualizarPlanejamento($this->Dados);
            if ($atualizar->getResultado()){

                $UrlDestino = URLADM .'jornada-de-trabalho/listar';
                header("Location: $UrlDestino");

            } else {

                $alertMensagem = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alertMensagem->alertMensagem("Desculpe! Ocorreu um erro.","O planejamento não foi atualizado", "danger");
                $UrlDestino = URLADM .'jornada-de-trabalho/listar';
                header("Location: $UrlDestino");

            }

        } elseif (!empty($this->Dados['RegistrarPlanejamento'])) {
            unset($this->Dados['RegistrarPlanejamento']);

            //var_dump($this->Dados);
            //die;
            $registrar = new AdmsPlanejamento();
            $registrar->registrarPlanejamento($this->Dados);
            if ($registrar->getResultado()){

                $UrlDestino = URLADM .'jornada-de-trabalho/listar';
                header("Location: $UrlDestino");

            } else {

                $alertMensagem = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alertMensagem->alertMensagem("Desculpe! Ocorreu um erro.","O planejamento não foi registrado", "danger");
                $UrlDestino = URLADM .'jornada-de-trabalho/listar';
                header("Location: $UrlDestino");

            }

        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Nenhum dado foi alterado! Tente novamente.</div>";
            $UrlDestino = URLADM .'jornada-de-trabalho/listar';
            header("Location: $UrlDestino");
        }

    }

}