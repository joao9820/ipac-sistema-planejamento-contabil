<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 27/03/2019
 * Time: 15:26
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsHoraExtra;
use App\adms\Models\AdmsMenu;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class HoraExtra
{
    private $Dados;
    private $UserId;
    private $PageId;
    private $DadosHora;
    private $HoraExtraId;


    public function listar($PageId = null)
    {

        $this->PageId = (int) $PageId ? $PageId : 1;
        $this->UserId = filter_input(INPUT_GET, "func", FILTER_DEFAULT);
        $this->DadosHora = filter_input_array(INPUT_POST, FILTER_DEFAULT);


        //var_dump($this->DadosId);
        if (!empty($this->DadosHora)) {

            if (!empty($this->DadosHora['data']) and !empty($this->DadosHora['total'])) {

                $this->cadastrar();

            }

            if (!empty($this->DadosHora['dataFinal'])) {


                if (empty($this->DadosHora['dataInicial'])) {
                    $this->DadosHora['dataInicial'] = date('Y-m-d');
                }

                $this->PageId =  1;

                $filtrarHora = new AdmsHoraExtra();
                $this->Dados['horasExtraListar'] = $filtrarHora->filtrarHoraExtra($this->UserId, $this->DadosHora['dataInicial'], $this->DadosHora['dataFinal'], $this->PageId);

                $this->Dados['paginacao'] = $filtrarHora->getResultadoPg();
                $this->Dados['funcionario'] = $filtrarHora->verFuncionario($this->UserId);

                $listarMenu = new AdmsMenu();
                $this->Dados['menu'] = $listarMenu->itemMenu();

                $carregarView = new ConfigView("adms/Views/horaExtra/horaExtra", $this->Dados);
                $carregarView->renderizar();

            }

        } else {

            $verHoraExtra = new AdmsHoraExtra();
            $this->Dados['horasExtraListar'] = $verHoraExtra->listar($this->UserId, $this->PageId);
            $this->Dados['paginacao'] = $verHoraExtra->getResultadoPg();
            $this->Dados['funcionario'] = $verHoraExtra->verFuncionario($this->UserId);

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new ConfigView("adms/Views/horaExtra/horaExtra", $this->Dados);
            $carregarView->renderizar();
        }
    }

    private function cadastrar()
    {

        if (!empty($this->DadosHora['data']) and !empty($this->DadosHora['total'])) {

            $this->DadosHora['adms_usuario_id'] = $this->UserId;

            $registrarHora = new \App\adms\Models\AdmsHoraExtra();
            $registrarHora->registrarHoraExtra($this->DadosHora);


            $UrlDestino = URLADM . 'hora-extra/listar/1?func=' . $this->UserId;
            header("Location: $UrlDestino");

        } else {

            $UrlDestino = URLADM . 'hora-extra/listar/1?func=' . $this->UserId;
            header("Location: $UrlDestino");
        }

    }

    public function deletar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;
        $this->UserId = filter_input(INPUT_GET, "func", FILTER_DEFAULT);

        $this->HoraExtraId = filter_input(INPUT_GET, "he", FILTER_DEFAULT);

        if (!empty($this->HoraExtraId)) {
            $deletHoraExtra = new \App\adms\Models\AdmsHoraExtra();
            $deletHoraExtra->deletarHoraExtra($this->HoraExtraId);

            $UrlDestino = URLADM . 'hora-extra/listar/'.$this->PageId.'?func=' . $this->UserId;
            header("Location: $UrlDestino");

        }


    }

}