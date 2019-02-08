<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 25/01/2019
 * Time: 12:32
 */

namespace App\adms\Models\helper;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

// Essa classe redimensiona a imagem

class AdmsUploadImgRed
{
    private $DadosImagem;
    private $Diretorio;
    private $NomeImg;
    private $Resultado;
    private $Imagem;
    private $Largura;
    private $Altura;
    private $ImgRedimensionada;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function uploadImagem(array $Imagem, $Diretorio, $NomeImg, $Largura, $Altura)
    {

        $this->DadosImagem = $Imagem; // Recebe todos os dados do array da imagem
        $this->Diretorio = $Diretorio; // Diretorio onde será salva
        $this->NomeImg = $NomeImg; // Nome da imagem
        $this->Largura = $Largura;
        $this->Altura = $Altura;

        $this->validarImagem();

        if ($this->Imagem) {

            $this->Resultado = true;

        } else {

            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A extensão da imagem é inválida! Selecione uma imagem JPEG ou PNG.</div>";
            $this->Resultado = false;

        }

    }

    private function validarImagem()
    {
        switch ($this->DadosImagem['type']):
            case 'image/jpeg':
            case 'image/pjpeg':
                // Pegando a imagem do caminho temporario e criando uma nova imagem
                $this->Imagem = imagecreatefromjpeg($this->DadosImagem['tmp_name']);
                $this->redimensionarImg();
                $this->valDiretorio();
                imagejpeg($this->ImgRedimensionada, $this->Diretorio . $this->NomeImg);
                break;

            case 'image/png':
            case 'image/x-png':
                // Pegando a imagem do caminho temporario e criando uma nova imagem
                $this->Imagem = imagecreatefrompng($this->DadosImagem['tmp_name']);
                $this->redimensionarImg();
                $this->valDiretorio();
                imagepng($this->ImgRedimensionada, $this->Diretorio . $this->NomeImg);
                $this->redimensionarImg();

                break;
        endswitch;


    }




    private function valDiretorio()
    {
        // Caso o diretorio não exista ele será criado
        if (!file_exists($this->Diretorio) && !is_dir($this->Diretorio))
        {
            mkdir($this->Diretorio,0755);
        }

    }



    private function redimensionarImg()
    {

        $largura_original = imagesx($this->Imagem);
        $altura_original = imagesy($this->Imagem);

        $this->ImgRedimensionada = imagecreatetruecolor($this->Largura, $this->Altura);

        imagecopyresampled($this->ImgRedimensionada, $this->Imagem, 0, 0, 0, 0, $this->Largura, $this->Altura, $largura_original, $altura_original);

    }



}