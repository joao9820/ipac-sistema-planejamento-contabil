<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
if ($this->Dados['atendimento']) {
    extract($this->Dados['atendimento'][0]);

//var_dump($this->Dados);
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

                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9"><?php echo $id; ?></dd>

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

                <dt class="col-sm-3">Funcionário Responsável</dt>
                <dd class="col-sm-9"><?php echo $funcionario; ?></dd>

                <dt class="col-sm-3">Prioridade de atendimento? </dt>
                <dd class="col-sm-9"><?php if ($prioridade == 1){ echo "Sim";} else {echo "Não";} ?></dd>

                <dt class="col-sm-3">Atendimento iniciado em</dt>
                <dd class="col-sm-9"><?php if (!empty($inicio_atendimento)) {echo date('d/m/Y H:i:s', strtotime($inicio_atendimento));} else {echo "Não iniciado.";} ?></dd>

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

<?php
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Atendimento não encontrado!</div>";
    $UrlDestino = URLADM . 'gerenciar-atendimento/listar';
    header("Location: $UrlDestino");
}
?>

<script>
    //Apresentar tooltip
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>