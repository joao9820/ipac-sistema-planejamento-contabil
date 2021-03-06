<?php

namespace Core;


use App\adms\Models\helper\AdmsAlertMensagem;

class ConfigController
{

    private $Url;
    private $UrlConjunto;
    private $UrlController;
    private $UrlParametro;
    private $UrlMetodo;
    private $Classe;
    private $Paginas;
    private $PaginasExiste;
    private $PaginasPublica;
    private static $Format;

    public function __construct()
    {
        if (!empty(filter_input(INPUT_GET, 'url', FILTER_DEFAULT))) {
            $this->Url = filter_input(INPUT_GET, 'url', FILTER_DEFAULT);
            $this->limparUrl();
            $this->UrlConjunto = explode("/", $this->Url);

            if (isset($this->UrlConjunto[0])) {
                $this->UrlController = $this->slugController($this->UrlConjunto[0]);
            } else {
                $this->UrlController = $this->slugController(CONTROLER);
            }

            if (isset($this->UrlConjunto[1])) {
                $this->UrlMetodo = $this->slugMetodo($this->UrlConjunto[1]);
            } else {
                $this->UrlMetodo = $this->SlugMetodo(METODO);
            }

            if (isset($this->UrlConjunto[2])) {
                $this->UrlParametro = $this->UrlConjunto[2];
            } else {
                $this->UrlParametro = null;
            }
        } else {
            $this->UrlController = $this->slugController(CONTROLER);
            $this->UrlMetodo = $this->SlugMetodo(METODO);
            $this->UrlParametro = null;
        }
        //echo "URL: {$this->Url} <br>";
        //echo "Controlle: {$this->UrlController} <br>";
        //$_SESSION['titulo'] = $this->UrlController;
        //echo $_SESSION['titulo'];
        //echo "Metodo: {$this->UrlMetodo} <br>";
        //echo "Paramento: {$this->UrlParametro} <br>";
    }

    private function limparUrl()
    {
        //Eliminar as tags
        $this->Url = strip_tags($this->Url);
        //Eliminar espaços em branco
        $this->Url = trim($this->Url);
        //Eliminar a barra no final da URL
        $this->Url = rtrim($this->Url, "/");

        self::$Format = array();
        self::$Format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]?;:.,\\\'<>°ºª ';
        self::$Format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr--------------------------------';
        $this->Url = strtr(utf8_decode($this->Url), utf8_decode(self::$Format['a']), self::$Format['b']);
    }

    public function slugController($SlugController)
    {
        $UrlController = str_replace(" ", "", ucwords(implode(" ", explode("-", strtolower($SlugController)))));
        $_SESSION['titulo'] = ucwords(implode(" ", explode("-", strtolower($SlugController))));
        //echo $SlugController;
        return $UrlController;
    }

    public function slugMetodo($SlugMetodo)
    {
        $UrlController = str_replace(" ", "", ucwords(implode(" ", explode("-", strtolower($SlugMetodo)))));
        return lcfirst($UrlController);
    }


    public function carregar()
    {
        $listarPg = new \App\adms\Models\AdmsPaginas();
        $this->PaginasExiste = $listarPg->verificarPaginaExiste($this->UrlController, $this->UrlMetodo);
        if ($this->PaginasExiste) {

            $this->PaginasPublica = $listarPg->paginaPublica($this->UrlController, $this->UrlMetodo);
            if ($this->PaginasPublica){

                extract($this->PaginasPublica[0]);
                $this->Classe = "\\App\\{$tipo_tpg}\\Controllers\\" . $this->UrlController;
                if (class_exists($this->Classe)) {
                    $this->carregarMetodo();
                } else {
                    $this->UrlController = $this->slugController(CONTROLER);
                    $this->UrlMetodo = $this->slugMetodo(METODO);
                    $this->carregar();
                }

            }
            else {

                $this->Paginas = $listarPg->listarPaginas($this->UrlController, $this->UrlMetodo);
                if ($this->Paginas) {
                    extract($this->Paginas[0]);
                    $this->Classe = "\\App\\{$tipo_tpg}\\Controllers\\" . $this->UrlController;
                    if (class_exists($this->Classe)) {
                        $this->carregarMetodo();
                    } else {
                        $this->UrlController = $this->slugController(CONTROLER);
                        $this->UrlMetodo = $this->slugMetodo(METODO);
                        $this->carregar();
                    }
                } else {
                    if(!isset($_SESSION['adms_niveis_acesso_id'])) {
                        $alert = new AdmsAlertMensagem();
                        $_SESSION['msg'] = $alert->alertMensagemJavaScript("Faça login para acessar o sistema!","info");
                    } else {
                        $alert = new AdmsAlertMensagem();
                        $_SESSION['msg'] = $alert->alertMensagemJavaScript("Oops! Você não tem acesso a página. <a class='nav-link text-dark' href='javascript:history.back()'>Voltar a página anterior</a>","warning");
                    }
                    $this->UrlController = $this->slugController('Login');
                    $this->UrlMetodo = $this->slugMetodo('acesso');
                    $this->carregar();
                }

            }

        }
        else {
            //Página de erro 404;
            $this->UrlController = $this->slugController('Error');
            $this->UrlMetodo = $this->slugMetodo('erro-404');
            $this->carregar();
        }
    }

    private function carregarMetodo()
    {
        $classeCarregar = new $this->Classe;
        if (method_exists($classeCarregar, $this->UrlMetodo)){

            if($this->UrlParametro !== null){
                $classeCarregar->{$this->UrlMetodo}($this->UrlParametro);
            } else {
                $classeCarregar->{$this->UrlMetodo}();
            }

        } else {
            $this->UrlController = $this->slugController(CONTROLER);
            $this->UrlMetodo = $this->slugMetodo(METODO);
            $this->carregar();
        }
    }


}
