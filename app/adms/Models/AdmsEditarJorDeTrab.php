<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 21/03/2019
 * Time: 16:09
 */

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsEditarJorDeTrab
{
    private $Dados;
    private $DadosId;
    private $Resultado;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verFuncionario($DadosId)
    {
        $this->DadosId = (int) $DadosId;

        $verFuncionario = new \App\adms\Models\helper\AdmsRead();
        $verFuncionario->fullRead("SELECT user.id, user.nome, user.email, user.imagem, user.adms_departamento_id, 
                        user.adms_cargo_id, user.jornada_de_trabalho 
                        FROM adms_usuarios user  
                        INNER JOIN adms_niveis_acessos nivel_aces ON nivel_aces.id=user.adms_niveis_acesso_id 
                        WHERE user.id =:id AND nivel_aces.ordem >:ordem LIMIT :limit",
            "id={$this->DadosId}&ordem=".$_SESSION['ordem_nivac']."&limit=1");
        $this->Resultado = $verFuncionario->getResultado();
        return $this->Resultado;

    }


    public function listarCadastrar()
    {
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id id_departamento, nome nome_departamento FROM adms_departamentos ORDER BY nome ASC");
        $registro['departamento'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_cargo, cargo FROM adms_cargos ORDER BY cargo ASC ");
        $registro['cargos'] = $listar->getResultado();

        $this->Resultado = array('departamento' => $registro['departamento'], 'cargos' => $registro['cargos']);

        return $this->Resultado;
    }

    public function updateEditFuncionario(array $Dados)
    {
        $this->Dados = $Dados;

        $this->Dados['modified'] = date('Y-m-d H:i:s');


        $upEditFunc = new \App\adms\Models\helper\AdmsUpdate();
        //var_dump($this->Dados);
        $upEditFunc->exeUpdate("adms_usuarios", $this->Dados, "WHERE id =:id", "id={$this->Dados['id']}");
        if ($upEditFunc->getResultado())
        {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagemSimples("Funcionário atualizado com sucesso", "success");
            $this->Resultado = true;

        } else {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagem("Desculpe! Ocorreu um erro.","A atualização do funcionário não foi concluída", "danger");
            $this->Resultado = false;

        }

    }


}