<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 29/03/2019
 * Time: 15:21
 */

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AnexarDocumento
{

    public function anexar($AtendId = null)
    {
        $this->AtendId = $AtendId ? $AtendId : 8;
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        var_dump($this->Dados);
        die;
        $this->Arquivo = $this->Dados['arquivoAnexar'];


        $upload = new \App\adms\Models\helper\AdmsUploadArquivos();
        $upload->uploadArquivo($this->Arquivo, 'assets/arquivos/atendimento/'.$this->AtendId, 'teste');
        if ($upload->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Upload realizado com sucesso!</div>";
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao realizar upload!</div>";
        }

        //$_SESSION['msg'] = "<div class='alert alert-success'>Funcionário editado com sucesso!</div>";
        $UrlDestino = URLADM . 'atendimento-pendente/listar';
        header("Location: $UrlDestino");
    }

}