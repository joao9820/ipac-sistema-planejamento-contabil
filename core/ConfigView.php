<?php

namespace Core;


class ConfigView
{

    private $Nome;
    private $Dados;

    public function __construct($Nome, array $Dados = null)
    {
        $this->Nome = (string) $Nome;
        $this->Dados = $Dados;
    }

    public function renderizar()
    {
        include 'app/adms/Views/include/cabecalho_adm.php';
        include 'app/adms/Views/include/header.php';
        include 'app/adms/Views/include/sidebar.php';
        if (file_exists('app/' . $this->Nome . '.php')) {
            include 'app/' . $this->Nome . '.php';
        }else{
            echo "Erro ao carregar a Página: {$this->Nome}";
        }
        include 'app/adms/Views/include/rodape_adm.php';
    }

    public function renderizarLogin()
    {
        include 'app/adms/Views/include/cabecalho.php';
        if (file_exists('app/'.$this->Nome.'.php')){
            include 'app/'.$this->Nome.'.php';
        } else {
            echo "Erro ao carregar a Página: {$this->Nome}";
        }
    }

    public function renderizarErro404()
    {
        if (file_exists('app/'.$this->Nome.'.php')){
            include 'app/'.$this->Nome.'.php';
        } else {
            echo "Erro ao carregar a Página: {$this->Nome}";
        }
    }

    public function renderizarListar()
    {
        if (file_exists('app/' . $this->Nome . '.php')) {
            include 'app/' . $this->Nome . '.php';
        }else{
            echo "Erro ao carregar a Página: {$this->Nome}";
        }
    }

}
