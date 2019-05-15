<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 09/05/2019
 * Time: 12:38
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsMenu;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class Alocacao
{

    private $Dados;

    // Index da alocação, mostrar todos os gerentes
    public function listar()
    {
        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();


        $carregarView = new ConfigView("adms/Views/alocacao/index", $this->Dados);
        $carregarView->renderizar();
    }


    // Index alocação do gerente, mostrar todos os funcionários
    public function gerente($GerenteId = null)
    {
        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();


        $carregarView = new ConfigView("adms/Views/alocacao/gerente/index", $this->Dados);
        $carregarView->renderizar();
    }

}