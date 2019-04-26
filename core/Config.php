<?php
session_start();
ob_start();

define('URL', 'http://localhost/ipac-sistema-planejamento-contabil/');
define('URLADM', 'http://localhost/ipac-sistema-planejamento-contabil/adm/');

define('CONTROLER', 'Home');
define('METODO', 'index');

//Credenciais de acesso ao BD
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DBNAME', 'ipac_poo');

/*
 *define('URL', 'https://teste.ipaconline.com.br/');
 * define('URLADM', 'https://teste.ipaconline.com.br/adm/');
 *
 *define('HOST', 'localhost');
 *define('USER', 'ipaconli_admin');
 *define('PASS', 'script184259');
 *define('DBNAME', 'ipaconli_adms');
 *
 *
 */
