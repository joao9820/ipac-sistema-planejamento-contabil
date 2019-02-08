<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsCadastrarPagina
{

    private $Resultado;
    private $Dados;
    private $VazioIcone;
    private $UltimoIdInserido;
    private $ListaNivAc;
    private $ListaNivAcPg;
    private $DadosNivAcPg;
    private $NivAcId;


    function getResultado()
    {
        return $this->Resultado;
    }


    public function cadPagina(array $Dados)
    {
        $this->Dados = $Dados;
        $this->VazioIcone = $this->Dados['icone'];
        unset($this->Dados['icone']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirPagina();
        } else {
            $this->Resultado = false;
        }
    }


    private function inserirPagina()
    {
        $this->Dados['icone'] = $this->VazioIcone;
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $cadNivAc = new \App\adms\Models\helper\AdmsCreate;
        $cadNivAc->exeCreate("adms_paginas", $this->Dados);
        if ($cadNivAc->getResultado()) {
            $this->UltimoIdInserido = $cadNivAc->getResultado();
            $this->inserirPerNivAc();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A página não foi cadastrada!</div>";
            $this->Resultado = false;
        }
    }


    public function listarCadastrar()
    {
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id id_grpg, nome nome_grpg FROM adms_grps_pgs ORDER BY nome ASC");

        $registro['grpg'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_tpg, tipo tipo_tpg, nome nome_tpg FROM adms_tps_pgs ORDER BY nome ASC");
        $registro['tpg'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_sitpg, nome nome_sitpg FROM adms_sits_pgs ORDER BY nome ASC");
        $registro['sitpg'] = $listar->getResultado();

        $this->Resultado = ['grpg' => $registro['grpg'], 'tpg' => $registro['tpg'], 'sitpg' => $registro['sitpg']];

        return $this->Resultado;
    }

    private function listarNivAc()
    {
        $listarNivAc = new \App\adms\Models\helper\AdmsRead();
        $listarNivAc->fullRead("SELECT id FROM adms_niveis_acessos");
        $this->ListaNivAc = $listarNivAc->getResultado();
        //var_dump($listarNivAc->getResultado());
        //die;
    }

    private function inserirPerNivAc()
    {        
        $this->listarNivAc();
        //var_dump($this->listarNivAc);
       // die;
        foreach ($this->ListaNivAc as $nivAc) {
            //var_dump($nivAc);

            extract($nivAc);
            $this->NivAcId = $id;
            $this->pesqUltimaOrdem();
            $this->DadosNivAcPg['permissao'] = ($id == 1 ? 1 : 2);
            $this->DadosNivAcPg['ordem'] = $this->ListaNivAcPg[0]['ordem'] + 1;
            $this->DadosNivAcPg['adms_niveis_acesso_id'] = $id;
            $this->DadosNivAcPg['adms_pagina_id'] = $this->UltimoIdInserido;
            $this->DadosNivAcPg['created'] = date("Y-m-d H:i:s");

            $cadNivAcPg = new \App\adms\Models\helper\AdmsCreate;
            $cadNivAcPg->exeCreate("adms_nivacs_pgs", $this->DadosNivAcPg);

            if ($cadNivAcPg->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Página cadastrada com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-warning'>Página cadastrada com sucesso. Erro ao liberar a permissão de acesso ao nível de acesso!</div>";
                $this->Resultado = false;
            }
        }
    }





    private function pesqUltimaOrdem()
    {
        $listarNivAcPg = new \App\adms\Models\helper\AdmsRead();
        $listarNivAcPg->fullRead("SELECT ordem, adms_niveis_acesso_id
                FROM adms_nivacs_pgs 
                WHERE adms_niveis_acesso_id =:adms_niveis_acesso_id ORDER BY ordem DESC LIMIT :limit", "adms_niveis_acesso_id={$this->NivAcId}&limit=1");
        $this->ListaNivAcPg = $listarNivAcPg->getResultado();
        if (!$this->ListaNivAcPg) {
            $this->ListaNivAcPg[0]['ordem'] = 0;
        }
    }

}
