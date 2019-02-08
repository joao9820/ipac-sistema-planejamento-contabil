<?php
session_start();
ob_start();

define('URL', 'http://localhost/ipac-poo/');
define('URLADM', 'http://localhost/ipac-poo/adm/');

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