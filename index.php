<!DOCTYPE html>
<html lang="pt-br">
<?php
//ini_set('display_errors', '1'); Exibe qualquer erro que possa acontecer no servidor
require './core/Config.php';
require './vendor/autoload.php';

use Core\ConfigController as Home;

$Url = new Home();
$Url->carregar();
?>
</html>
