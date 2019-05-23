<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 21/03/2019
 * Time: 16:09
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsRead;
use App\adms\Models\helper\AdmsUpdate;

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

        $verFuncionario = new AdmsRead();
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
        $listar = new AdmsRead();
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


        $upEditFunc = new AdmsUpdate();
        //var_dump($this->Dados);
        $upEditFunc->exeUpdate("adms_usuarios", $this->Dados, "WHERE id =:id", "id={$this->Dados['id']}");
        if ($upEditFunc->getResultado())
        {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Funcionário atualizado!","success");
            $this->Resultado = true;

        } else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("A atualização do funcionário não foi concluída.","danger");
            $this->Resultado = false;

        }

    }


}