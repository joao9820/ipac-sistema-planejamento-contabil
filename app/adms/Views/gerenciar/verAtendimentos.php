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
                            echo "<a href='" . URLADM . "gerenciar-atendimento/listar/$pg' class='btn btn-info btn-sm'>Listar Atendimentos</a> ";
                        }
                        if ($this->Dados['botao']['edit_atendimento'] AND $cancelado_p_user !=1) {
                            if ($id_situacao != 2) {
                                echo "<a href='" . URLADM . "atendimento-gerente/editar/$id?pg=$pg' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                            } else {
                                echo '<span tabindex="0" data-placement="left" data-toggle="tooltip" title="Atendimento sendo realizado pelo funcionário responsável. Nenhuma alteração pode ser feita no momento.">';
                                echo "<a href='#' class='btn btn-secondary btn-sm disabled'>Editar</a> ";
                                echo '</span>';
                            }

                        }
                        if (($this->Dados['botao']['arqui_atendimento']) AND ($arquivado_gerente != 1)) {
                            echo "<a href='" . URLADM . "atendimento-gerente/arquivar/$id' class='btn btn-secondary btn-sm' 
                                    data-arquivo='Tem certeza que deseja arquivar o atendimento selecionado?'>Arquivar</a> ";
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
                                echo "<a class='dropdown-item' href='" . URLADM . "gerenciar-atendimento/listar/$pg'>Listar Atendimentos</a>";
                            }
                            if ($this->Dados['botao']['edit_atendimento'] AND $cancelado_p_user !=1) {
                                if ($id_situacao != 2) {
                                    echo "<a class='dropdown-item' href='" . URLADM . "atendimento-gerente/editar/$id$id?pg=$pg'>Editar</a>";
                                } else {

                                    echo "<a href='#' class='dropdown-item disabled'>
                                            <span tabindex='0' data-placement='top' data-toggle='tooltip' title='Atendimento sendo realizado pelo funcionário responsável. Nenhuma alteração pode ser feita no momento.'>
                                                <i class='fas fa-question-circle'></i>
                                            </span>Editar</a> ";
                                }
                            }
                            if ($this->Dados['botao']['arqui_atendimento']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "atendimento-gerente/arquivar/$id' data-arquivo='Tem certeza que deseja arquivar o atendimento selecionado?'>Arquivar</a>";
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

                <dt class="col-sm-3">Tempo previsto para o Atendimento: </dt>
                <dd class="col-sm-9">
                    <span tabindex="0" data-placement="top" data-toggle="tooltip" title="Essa previsão é feita com base no tempo de execução da demanda selecionada.">
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

                <dt class="col-sm-3">Funcionário Responsável</dt>
                <dd class="col-sm-9"><?php echo $funcionario; ?></dd>

                <dt class="col-sm-3">Prioridade de atendimento? </dt>
                <dd class="col-sm-9"><?php if ($prioridade == 1){ echo "Sim";} else {echo "Não";} ?></dd>

                <dt class="col-sm-3">Atendimento iniciado em</dt>
                <dd class="col-sm-9"><?php if (!empty($inicio_atendimento)) {echo date('d/m/Y H:i:s', strtotime($inicio_atendimento));} else {echo "Não iniciado.";} ?></dd>

                <dt class="col-sm-3">Tempo Restante</dt>
                <dd class="col-sm-9">

                        <?php
                        if ($id_sits_aten_func == 1) {
                            echo "--:--";
                        } elseif ($id_sits_aten_func == 3){


                            if (!empty($at_tempo_restante) AND empty($at_tempo_excedido)) {
                                echo date('H:i:s', strtotime($at_tempo_restante));
                                echo "<span class='ml-2 badge badge-secondary'>Pausado pelo funcinário</span>";
                            }
                            elseif (!empty($at_tempo_excedido)) {

                                echo "<span id='sessao' class='text-danger'>";
                                echo "-".date('H:i:s', strtotime($at_tempo_excedido));
                                echo "</span>";
                                echo "<span class='ml-2 badge badge-danger'>Pausado pelo funcinário - Atendimento atrasado</span>";

                            }
                            else {
                                echo "--:--";
                            }


                        }
                        elseif ($id_sits_aten_func == 2) {

                            if (!empty($at_tempo_restante) AND empty($at_tempo_excedido)) {

                                // Pegando a hora restante do atendimento no banco e transformando em segundos
                                $at_iniciado = date('Y-m-d H:i:s', strtotime($at_iniciado));
                                $partes = explode(':', $at_tempo_restante);
                                $segundosTotal = $partes[0] * 3600 + $partes[1] * 60 + $partes[2];
                                // Pegando a hora do banco em que foi iniciado o atendimento
                                $at_pausado = date('Y-m-d H:i:s');
                                $dteStart = new DateTime($at_iniciado);
                                $dteEnd = new DateTime($at_pausado);
                                $dteDiff = $dteStart->diff($dteEnd);
                                $horas_diferenca = $dteDiff->format('%H');
                                $minutos_diferenca = $dteDiff->format('%i');
                                $segundos_diferenca = $dteDiff->format('%s');
                                $segundosAndamento = $horas_diferenca * 3600 + $minutos_diferenca * 60 + $segundos_diferenca;

                                $tempo_restante = $segundosTotal - $segundosAndamento;

                                echo "<span id='sessao' class='text-primary'></span>";
                                echo "<span class='ml-2 badge badge-warning'>Sendo executado pelo funcionário</span>";

                                $valorControler = 0;

                            }
                            elseif (!empty($at_tempo_excedido)){

                                // Pegando a hora restante do atendimento no banco e transformando em segundos
                                $at_iniciado = date('Y-m-d H:i:s', strtotime($at_iniciado));
                                $partes = explode(':', $at_tempo_excedido);
                                $segundosTotal = $partes[0] * 3600 + $partes[1] * 60 + $partes[2];
                                // Pegando a hora do banco em que foi iniciado o atendimento
                                $at_pausado = date('Y-m-d H:i:s');
                                $dteStart = new DateTime($at_iniciado);
                                $dteEnd = new DateTime($at_pausado);
                                $dteDiff = $dteStart->diff($dteEnd);
                                $horas_diferenca = $dteDiff->format('%H');
                                $minutos_diferenca = $dteDiff->format('%i');
                                $segundos_diferenca = $dteDiff->format('%s');
                                $segundosAndamento = $horas_diferenca * 3600 + $minutos_diferenca * 60 + $segundos_diferenca;

                                $tempo_restante = $segundosTotal + $segundosAndamento;

                                echo "<span id='sessao' class='text-primary'></span>";
                                echo "<span class='ml-2 badge badge-danger'>Atendimento atrasado - Sendo executado</span>";

                                $valorControler = 1;

                            }
                            else {
                                echo "--:--";
                            }
                        }
                        ?>

                </dd>


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
