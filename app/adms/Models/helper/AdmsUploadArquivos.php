<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 29/03/2019
 * Time: 14:17
 */

namespace App\adms\Models\helper;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsUploadArquivos
{
    private $Resultado;
    private $DadosArquivo;
    private $Diretorio;
    private $NomeArquivo;
    private $DiretorioArquivo;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function uploadArquivo( $Arquivo, $Diretorio, $NomeArquivo)
    {
        $this->DadosArquivo = $Arquivo;
        $this->DiretorioArquivo = $Diretorio;
        $this->NomeArquivo = $NomeArquivo;

        $this->valDiretorio();
    }

    private function valDiretorio()
    {
        // Caso o diretorio não exista ele será criado
        if (!file_exists($this->DiretorioArquivo) && !is_dir($this->DiretorioArquivo))
        {
            mkdir($this->DiretorioArquivo,0777);
        }
        // Agora chamar o metodo para realizar o upload
        $this->realizarUpload();

    }

    private function realizarUpload()
    {
        if (move_uploaded_file($this->DadosArquivo['tmp_name'], $this->Diretorio . $this->NomeArquivo))
        {

            $this->Resultado = true;

        } else {

            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi possível realizar o upload.</div>";
            $this->Resultado = false;

        }
    }

}