<?php

namespace App\adms\Models;

use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsPaginas
{
    private $Resultado;
    private $UrlController;
    private $UrlMetodo;
    private $UrlControllerPb;
    private $UrlMetodoPb;
    private $Controller;
    private $Metodo;

    public function listarPaginas($UrlController = null, $UrlMetodo = null)
    {
        if(!isset($_SESSION['adms_niveis_acesso_id'])){
            $_SESSION['adms_niveis_acesso_id'] = null;
        }
        $this->UrlController = (string) $UrlController;
        $this->UrlMetodo = (string) $UrlMetodo;
        $listar = new AdmsRead();
        $listar->fullRead("SELECT pg.id,
                tpg.tipo tipo_tpg
                FROM adms_paginas pg
                INNER JOIN adms_tps_pgs tpg ON tpg.id=pg.adms_tps_pg_id
                LEFT JOIN adms_nivacs_pgs nivpg ON nivpg.adms_pagina_id=pg.id AND nivpg.adms_niveis_acesso_id =:adms_niveis_acesso_id
                WHERE (pg.controller =:controller
                AND pg.metodo =:metodo) AND ((pg.lib_pub =:lib_pub) OR (nivpg.permissao =:permissao))
                LIMIT :limit", "adms_niveis_acesso_id={$_SESSION['adms_niveis_acesso_id']}&controller={$this->UrlController}&metodo={$this->UrlMetodo}&lib_pub=1&permissao=1&limit=1");
        $this->Resultado = $listar->getResultado();
        return $this->Resultado;
    }

    public function paginaPublica($UrlControllerPb = null, $UrlMetodoPb = null)
    {
        if(!isset($_SESSION['adms_niveis_acesso_id'])){
            $_SESSION['adms_niveis_acesso_id'] = null;
        }
        $this->UrlControllerPb = (string) $UrlControllerPb;
        $this->UrlMetodoPb = (string) $UrlMetodoPb;
        $listarPb = new AdmsRead();
        $listarPb->fullRead("SELECT pg.id,
                tpg.tipo tipo_tpg
                FROM adms_paginas pg
                INNER JOIN adms_tps_pgs tpg ON tpg.id=pg.adms_tps_pg_id
                LEFT JOIN adms_nivacs_pgs nivpg ON nivpg.adms_pagina_id=pg.id AND nivpg.adms_niveis_acesso_id =:adms_niveis_acesso_id
                WHERE (pg.controller =:controller
                AND pg.metodo =:metodo) AND (pg.lib_pub =:lib_pub)
                LIMIT :limit", "adms_niveis_acesso_id={$_SESSION['adms_niveis_acesso_id']}&controller={$this->UrlController}&metodo={$this->UrlMetodo}&lib_pub=1&limit=1");
        $this->Resultado = $listarPb->getResultado();
        return $this->Resultado;
    }

    public function verificarPaginaExiste($Controller = null, $Metodo = null)
    {
        $this->Controller = (string) $Controller;
        $this->Metodo = (string) $Metodo;
        $listarPe = new AdmsRead();
        $listarPe->fullRead("SELECT id
                FROM adms_paginas 
                WHERE controller =:controller AND metodo =:metodo
                LIMIT :limit", "controller={$this->Controller}&metodo={$this->Metodo}&limit=1");
        $this->Resultado = $listarPe->getResultado();
        return $this->Resultado;
    }
}
