<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
if ($this->Dados['atendimento']) {
    extract($this->Dados['atendimento'][0]);

$pg = $this->Dados['pg'];
//var_dump($this->Dados['atendimento']);
?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex">
                <div class="mr-auto p-2">

                    <h2 class="display-4 titulo">Detalhes do Atendimento</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_atendimento']) {
                            echo "<a href='" . URLADM . "gerenciar-atendimento/listar/$pg' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i> Listar Atendimentos</a> ";
                        }
                        if ($this->Dados['botao']['edit_atendimento'] AND $cancelado_p_user !=1) {
                            echo "<a href='" . URLADM . "atendimento-gerente/editar/$id?pg=$pg' class='btn btn-outline-warning btn-sm'><i class='far fa-edit'></i> Editar</a> ";
                        }
                        if (($this->Dados['botao']['arqui_atendimento']) AND ($arquivado_gerente != 1)) {
                            echo "<a href='" . URLADM . "atendimento-gerente/arquivar/$id' class='btn btn-outline-secondary btn-sm' 
                                    data-arquivo='Tem certeza que deseja arquivar o atendimento selecionado?'><i class='fas fa-folder-open'></i> Arquivar</a> ";
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
                                echo "<a class='dropdown-item' href='" . URLADM . "gerenciar-atendimento/listar/$pg'><i class='fas fa-list'></i> Listar Atendimentos</a>";
                            }
                            if ($this->Dados['botao']['edit_atendimento'] AND $cancelado_p_user !=1) {
                                echo "<a class='dropdown-item' href='" . URLADM . "atendimento-gerente/editar/$id?pg=$pg'><i class='far fa-edit'></i> Editar</a>";
                            }
                            if ($this->Dados['botao']['arqui_atendimento']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "atendimento-gerente/arquivar/$id' data-arquivo='Tem certeza que deseja arquivar o atendimento selecionado?'><i class='fas fa-folder-open'></i> Arquivar</a>";
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

                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9"><?php
                    if ($id < 10){
                        echo "000".$id;
                    } elseif ($id < 100){
                        echo "00".$id;
                    } elseif ($id < 100){
                        echo "0".$id;
                    } else {
                        echo $id;
                    }
                    ?></dd>

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

                <dt class="col-sm-3">Tempo previsto para o Atendimento: </dt>
                <dd class="col-sm-9">
                    <span class="text-secondary" tabindex="0" data-placement="top" data-toggle="tooltip" title="Essa previsão é feita com base no tempo de execução da demanda selecionada.">
                    <i class="fas fa-question-circle"></i>
                    </span>
                    <?php
                    //var_dump($this->Dados['total_horas_atendimento']);
                    extract($this->Dados['total_horas_atendimento'][0]);

                    if (!empty($duracao_atendimento)){
                        $dadosHoras = (string) $duracao_atendimento;
                    } else {
                        $dadosHoras = (string) $total_horas;
                    }

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

                <dt class="col-sm-3">Funcionário(s) Responsável</dt>
                <dd class="col-sm-9">(implementar join para listar os funcionários)</dd>

                <dt class="col-sm-3">Prioridade de atendimento? </dt>
                <dd class="col-sm-9"><?php if ($prioridade == 1){ echo "Sim";} else {echo "Não";} ?></dd>

                <dt class="col-sm-3">Atendimento iniciado em</dt>
                <dd class="col-sm-9"><?php if (!empty($inicio_atendimento)) {echo date('d/m/Y H:i:s', strtotime($inicio_atendimento));} else {echo "Não iniciado.";} ?></dd>



                <?php
                    if (!empty($fim_atendimento)) {
                        ?>
                        <dt class="col-sm-3">Atendimento finalizado em</dt>
                        <dd class="col-sm-9"><?php if (!empty($fim_atendimento)) {
                                echo date('d/m/Y H:i:s', strtotime($fim_atendimento));
                            } ?></dd>


                        <dt class="col-sm-3">Duração total do atendimento:</dt>
                        <dd class="col-sm-9">
                            <?php
                            /*
                            if (!empty($fim_atendimento)) {
                                $date_time = new DateTime($inicio_atendimento);
                                $result = $date_time->diff(new DateTime($fim_atendimento));

                                echo $result->format('%m mês(s), %d dia(s), %H hora(s) e %i minuto(s)');

                                $totalA = [
                                        'ano' => $result->format('%y'),
                                        'mes' => $result->format('%m'),
                                        'dia' => $result->format('%d'),
                                        'hora' => $result->format('%H'),
                                        'minuto' => $result->format('%i'),
                                        'segundo' => $result->format('%s')];
                                //var_dump($totalA);


                            }
                            */
                            ?>
                        </dd>
                        <?php
                    }
                ?>

                

            </dl>

            <div>
                <?php
                    if ($this->Dados['botao']['list_logs']) {
                        echo "<a href='" . URLADM . "logs-atendimento/listar/$id?pg=$pg' class='btn btn-outline-info btn-sm'><i class='fas fa-history'></i> Histórico do atendimento</a> ";
                    }
                ?>
            </div>


        </div>
    </div>
    <?php
    if (!empty($tempo_restante)) {
        $scriptInicio = "<script>";
        $scriptFinal = "</script>";
        // O tempo tem que ser obrigatoriamente em segundos


        $script = $scriptInicio . "var tempo = '" . $tempo_restante . "'; var controler = '" . $valorControler . "';" . $scriptFinal;
        echo $script;
        ?>
        <script src="<?php echo URLADM.'assets/js/temporizador/jquery-1.9.1.min.js'; ?>"></script>
        <script type="text/javascript">

            //var tempo = new Number();
            //var controler = 0;
            // Tempo em segundos
            //tempo = 7;

            function startCountdown(){

                // Se o tempo não for zerado
                if(((tempo - 1) >= 0) && (controler == 0)){

                    // Pega a parte inteira dos minutos
                    var min = parseInt(tempo/60);

                    // horas, pega a parte inteira dos minutos
                    var hor = parseInt(min/60);

                    //atualiza a variável minutos obtendo o tempo restante dos minutos
                    min = min % 60;


                    // Calcula os segundos restantes
                    var seg = tempo%60;

                    // Formata o número menor que dez, ex: 08, 07, ...
                    if(min < 10)
                    {
                        min = "0"+min;
                        min = min.substr(0, 2);
                    }

                    if(seg <=9)
                    {
                        seg = "0"+seg;
                    }

                    if(hor <=9)
                    {
                        hor = "0"+hor;
                    }

                    // Cria a variável para formatar no estilo hora/cronômetro
                    horaImprimivel = hor+':' + min + ':' + seg;

                    //JQuery pra setar o valor
                    $("#sessao").html(horaImprimivel);

                    // Define que a função será executada novamente em 1000ms = 1 segundo
                    setTimeout('startCountdown()',1000);

                    // diminui o tempo
                    tempo--;

                } else {
                    controler = 1;

                    // Pega a parte inteira dos minutos
                    var min = parseInt(tempo/60);

                    // horas, pega a parte inteira dos minutos
                    var hor = parseInt(min/60);

                    //atualiza a variável minutos obtendo o tempo excedido dos minutos
                    min = min % 60;

                    // Calcula os segundos excedido
                    var seg = tempo%60;

                    // Formata o número menor que dez, ex: 08, 07, ...
                    if(min < 10){
                        min = "0"+min;
                        min = min.substr(0, 2);
                    }
                    if(seg <=9){
                        seg = "0"+seg;
                    }
                    if(hor <=9){
                        hor = "0"+hor;
                    }

                    // Cria a variável para formatar no estilo hora/cronômetro
                    horaImprimivel = '-' + hor + ':' + min + ':' + seg;

                    //JQuery pra setar o valor
                    $('#sessao').attr('class', 'text-danger');
                    $("#sessao").html(horaImprimivel);

                    // Define que a função será executada novamente em 1000ms = 1 segundo
                    setTimeout('startCountdown()',1000);

                    // somar o tempo
                    tempo++;
                }

            }

            // Chama a função ao carregar a tela
            startCountdown();

        </script>

        <?php
    }
    ?>
<?php
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Atendimento não encontrado!</div>";
    $UrlDestino = URLADM . 'gerenciar-atendimento/listar';
    header("Location: $UrlDestino");
}
?>
