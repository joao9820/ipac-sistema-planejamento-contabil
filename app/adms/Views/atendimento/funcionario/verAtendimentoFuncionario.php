<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
if ($this->Dados['verAtendimentoFuncionario']) {
    extract($this->Dados['verAtendimentoFuncionario'][0]);

$pg = $this->Dados['pg'];
//var_dump($this->Dados);
?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex">
                <div class="mr-auto p-2">

                    <h2 class="display-4 titulo">Atendimento <span class="badge badge-secondary  px-3"><?php echo $id ?></span></h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_atendimento']) {
                            echo "<a href='" . URLADM . "atendimento-pendente/listar/$pg' class='btn btn-outline-info btn-sm'>Listar Atendimentos</a> ";
                        }
                        if ($this->Dados['botao']['edit_atendimento'] AND $cancelado_p_user !=1) {
                            echo "<a href='" . URLADM . "atendimento-gerente/editar/$id?pg=$pg' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                            <?php
                            if ($this->Dados['botao']['list_atendimento']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "atendimento-pendente/listar/$pg'>Listar Atendimentos</a>";
                            }
                            if ($this->Dados['botao']['edit_atendimento']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "atendimento-gerente/editar/$id$id?pg=$pg'>Editar</a>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div><hr>
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>

            <?php
                if ($cancelado_p_user == 1){
                    ?>
                    <div class="alert alert-danger" role="alert">
                        Atendimento cancelado pelo usuário. Não pode ser feito nenhuma alteração.
                    </div>
                    <?php
                }
            ?>

            <dl class="row">

                <dt class="col-sm-3">Tipo</dt>
                <dd class="col-sm-9"><?php echo $nome_demanda; ?></dd>

                <dt class="col-sm-3">Situação</dt>
                <dd class="col-sm-9"><span class="badge badge-<?php echo $cor; ?>"><?php echo $nome_situacao; ?></span></dd>

                <dt class="col-sm-3">Descrição</dt>
                <dd class="col-sm-9"><?php echo $descricao; ?></dd>

                <dt class="col-sm-3">Nome do cliente</dt>
                <dd class="col-sm-9"><?php echo $cliente; ?></dd>

                <dt class="col-sm-3">Nome da empresa</dt>
                <dd class="col-sm-9"><?php echo $emp_nome; ?></dd>

                <dt class="col-sm-3">Solicitado em: </dt>
                <dd class="col-sm-9"><?php echo date('d/m/Y H:i:s', strtotime($created));?></dd>

                <dt class="col-sm-3">Duração Prevista Para o Atendimento: </dt>
                <dd class="col-sm-9">
                    <span tabindex="0" data-placement="top" data-toggle="tooltip" title="Essa previsão é feita com base no tempo de execução da demanda selecionada.">
                    <i class="fas fa-question-circle"></i>
                    </span>
                    <?php
                    //var_dump($this->Dados['total_horas_atendimento']);
                    extract($this->Dados['total_horas_atendimento'][0]);

                    $dadosHoras = (string) $total_horas;
                    $dados = explode(":", $dadosHoras);

                    $hora = $dados[0];
                    $minuto = $dados[1];


                    if ($hora >= 24){
                        $dia = (int)($hora / 24);
                        if ($dia > 1){
                            echo $dia ." dias";
                        } else {
                            echo $dia ." dia";
                        }

                        if ($hora != 24) {
                            if ($minuto > 0) {echo ", ";} else {echo " e ";}
                            $novaHora = $hora - ($dia * 24);
                            if ($novaHora > 1) {
                                echo $novaHora . " horas";
                            } else {
                                echo $novaHora . " hora";
                            }

                        }

                        if ($minuto != 0){
                            echo " e ";
                            if ($minuto == 1){echo $minuto ." minuto.";} else {echo $minuto ." minutos.";}
                        }

                    }
                    else {

                        if ($hora == 1)
                        {
                            echo $hora . " hora";
                        }
                        elseif ($hora > 1) {
                            echo $hora . " horas";
                        }


                        if ($minuto != 0){
                            if (($minuto == 1) AND $hora == 00)
                            {
                                echo $minuto ." minuto";
                            } elseif (($minuto != 1) AND ($hora == 00)) {
                                echo $minuto ." minutos";
                            }
                            if (($minuto == 1) AND ($hora != 00))
                            {
                                echo " e ". $minuto ." minuto";
                            }
                            elseif (($minuto != 1) AND ($hora != 00)) {
                                echo " e ". $minuto ." minutos";
                            }
                        }
                        echo ".";

                    }


                    ?>
                </dd>

                <dt class="col-sm-3">Prioridade do atendimento: </dt>
                <dd class="col-sm-9"><?php if ($prioridade == 1){ echo "<span class='badge badge-danger'>Imediato</span>";} else {echo "<span class='badge badge-secondary'>Normal";} ?></dd>

                <dt class="col-sm-3">Atendimento iniciado em</dt>
                <dd class="col-sm-9"><?php if (!empty($inicio_atendimento)) {echo date('d/m/Y H:i:s', strtotime($inicio_atendimento));} else {echo "Não iniciado.";} ?></dd>

                <dt class="col-sm-3">Tempo Restante</dt>
                <dd class="col-sm-9">
                    <span tabindex="0" data-placement="top" data-toggle="tooltip" title="Hora/minutos">
                        00:00
                    </span>
                </dd>

                <?php
                    if (!empty($inicio_atendimento) AND empty($fim_atendimento)) {
                        ?>
                        <dt class="col-sm-3">Fim previsto para</dt>
                        <dd class="col-sm-9">
                            <span class="bg-success rounded text-white p-1">
                            <?php
                                function addData($data,$minuto=0,$hora=0,$dia=0,$mes=0,$ano=0)
                                {
                                    $cd = strtotime($data);
                                    $novaData = date('Y-m-d H:i:s', mktime(
                                        date('H',$cd)+$hora,
                                        date('i',$cd)+$minuto,
                                        date('s',$cd),
                                        date('m',$cd)+$mes,
                                        date('d',$cd)+$dia,
                                        date('Y',$cd)+$ano
                                    ));
                                    return $novaData;
                                }
                                $nvData = addData($inicio_atendimento, $minuto, $hora);
                            echo date('d-m-Y H:i:s', strtotime($nvData));
                            ?>
                            </span>
                        </dd>
                        <?php
                    }
                ?>

                <?php
                    if (!empty($fim_atendimento)) {
                        ?>
                        <dt class="col-sm-3">Atendimento finalizado em</dt>
                        <dd class="col-sm-9"><?php if (!empty($fim_atendimento)) {
                                echo date('d/m/Y H:i:s', strtotime($fim_atendimento));
                            } ?></dd>


                        <dt class="col-sm-3">Duração total do atendimento:</dt>
                        <dd class="col-sm-9">Ainda statico</dd>
                        <?php
                    }
                ?>


                <dt class="col-sm-3">Alterado por último em</dt>
                <dd class="col-sm-9"><?php if (!empty($modified)) {
                    echo date('d/m/Y H:i:s', strtotime($modified));
                } ?></dd>

            </dl>


        </div>
    </div>
<?php
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Atendimento não encontrado!</div>";
    $UrlDestino = URLADM . 'gerenciar-atendimento/listar';
    header("Location: $UrlDestino");
}
?>
