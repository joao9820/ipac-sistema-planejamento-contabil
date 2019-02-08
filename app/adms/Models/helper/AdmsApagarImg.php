<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 25/01/2019
 * Time: 16:17
 */

namespace App\adms\Models\helper;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsApagarImg
{

    private $NomeImg;
    private $Diretorio;

    public function apagarImg($NomeImg, $Diretorio = null)
    {
        $this->NomeImg = (string) $NomeImg;
        $this->Diretorio = (string) $Diretorio;
        $this->excluirImagem();

        // Quando quiser excluir um diretorio basta passa-lo pelo parametro
        if (!empty($this->Diretorio))
        {
            $this->excluirDiretorio();
        }
    }

    private function excluirImagem()
    {
        if (file_exists($this->NomeImg))
        {
            unlink($this->NomeImg);
        }
    }

    private function excluirDiretorio()
    {
        if (file_exists($this->Diretorio))
        {
            rmdir($this->Diretorio);
        }
    }

}