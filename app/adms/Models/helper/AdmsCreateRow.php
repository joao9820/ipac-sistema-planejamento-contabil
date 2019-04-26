<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 21/01/2019
 * Time: 17:11
 */

namespace App\adms\Models\helper;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsCreateRow extends AdmsConn
{

    private $Tabela;
    private $Dados;
    private $Query;
    private $Conn;
    private $Resultado;


    public function getResultado()
    {
        return $this->Resultado;
    }


    public function exeCreate($Tabela, array $Dados)
    {
        $this->Tabela = (string) $Tabela;
        $this->Dados = $Dados;
        
        $this->getInstrucao();
        $this->executarInstrucao();
    }
    
    private function getInstrucao()
    {
        $colunas = implode(', ', array_keys($this->Dados));
        $valores = ':' . implode(', :', array_keys($this->Dados));
        $this->Query = "INSERT INTO {$this->Tabela} ({$colunas}) VALUES ({$valores})";
        //echo $this->Query;
    }

    private function executarInstrucao()
    {
        $this->conexao();
        try {
            $this->Query->execute($this->Dados);
            $this->Resultado = $this->Query->rowCount();
        } catch (\Exception $ex){
            $this->Resultado = null;
        }
    }

    private function conexao()
    {
        $this->Conn = parent::getConn();
        $this->Query = $this->Conn->prepare($this->Query);
    }

}