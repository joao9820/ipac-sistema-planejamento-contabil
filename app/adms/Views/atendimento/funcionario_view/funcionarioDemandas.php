<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
//echo $_SESSION['adms_empresa_id'];
//var_dump($this->Dados);
if(!empty($this->Dados['jornadaDeTrabalho'])) {
    extract($this->Dados['jornadaDeTrabalho']);
}
//echo $hora_extra;

/**
 * @param $ano ano em que se quer calcular os feriados
 * @return array com os feriados do ano (fixo e moveis)
 */
function getFeriados($ano){
    $dia = 86400;
    $datas = array();
    $datas['pascoa'] = easter_date($ano);
    $datas['sexta_santa'] = $datas['pascoa'] - (2 * $dia);
    $datas['carnaval'] = $datas['pascoa'] - (47 * $dia);
    $datas['corpus_cristi'] = $datas['pascoa'] + (60 * $dia);
    $feriados = array (
        '01/01',
        '02/02', // Navegantes
        date('d/m',$datas['carnaval']),
        date('d/m',$datas['sexta_santa']),
        date('d/m',$datas['pascoa']),
        '21/04', // Tiradentes
        '01/05', //  Dia do Trabalho
        date('d/m',$datas['corpus_cristi']),
        '07/09', // Dia da Independência do Brasil - 7 de Setembro
        '12/10', //  Nossa Senhora Aparecida
        '02/11', // Finados
        '15/11', // Proclamação da República
        '25/12', // Natal
    );
    return $feriados;
}
?>
<style>

    .planejamento_i_t .badge {
        font-size: 1em;
        font-weight: 400;
        text-shadow: 1px 1px 10px rgba(0,0,0,.8);
        transition: all .2s;
    }
    .no-shadow {
        text-shadow: none !important;
    }
    .planejamento_i_t .badge:hover {
        text-shadow: 1px 1px 10px rgba(255,255,255,.8);
    }
    #horaExtraTotal {
        max-width: 100px;
    }
    .btnOpcoes {
        min-width: 80px;
    }
    .btnOpcoesDisabled {
        opacity: .5 !important;
    }
    .text-transparente {
        color: transparent;
        background: transparent;
        border: transparent;
    }
</style>
<div class="content p-1">



    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Atendimentos</h2>
            </div>
        </div>
    </div>



    <?php
        //var_dump($this->Dados['planejamento']);
        if($this->Dados['planejamento']){
            extract($this->Dados['planejamento']);
            if (!empty($hora_extra)) {
                $extraa = explode(':', $hora_extra);
                $data = new DateTime(date('H:i', strtotime($hora_termino2)));
                $data->modify('+' . $extraa[0] . ' hours');
                $data->modify('+' . $extraa[1] . ' minutes');
                $hora_termino2 = $data->format('H:i');
                //echo $hora_termino2;
            }
        }

        /*
        echo $hora_inicio ."<br>";
        echo $hora_termino."<br>";
        echo $hora_inicio2."<br>";
        echo $hora_termino2."<br>";
        */
    ?>
    <span class="d-block my-3 ml-4">
        <?php if(!empty($this->Dados['planejamento'])) {?>
            <button onclick="Parametros('<?php echo $hora_inicio; ?>', '<?php echo $hora_termino; ?>', '<?php echo $hora_inicio2; ?>', '<?php echo $hora_termino2; ?>', '<?php echo $adms_funcionario_id; ?>')"
                    class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#editarFuncionarioModal">
                <i class="fa fa-eye"></i> Ver Planejamento
            </button>
        <?php } ?>
    </span>
    <div class="list-group-item border mx-4 mb-4 p-0 rounded">
        <div id="headerDescricaoPg" class="bg-primary">
            <h3 class="">Atendimentos Pendente</h3>
        </div>

        <div class="list-group-item">
            <?php
            if(isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }

            ?>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 p-0">
                        <form method="post" action="" class="form-inline">
                            <span tabindex="0" data-toggle="tooltip" data-placement="right" data-html="true" title="Hora extra hoje">
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-stopwatch"></i>
                                        </div>
                                    </div>
                                    <input name="total" type="text" class="form-control" id="horaExtraTotal" value="<?php
                                        if (!empty($hora_extra)) {
                                            echo date('h\hi', strtotime($hora_extra));
                                        } else {
                                            echo "00h00";
                                        }
                                    ?>" disabled>
                                </div>
                            </span>
                        </form>
                    </div>
                </div>
            </div>
            <hr>

            <?php
                if (!empty($this->Dados['listarAtendimentosInterrompido'])){
            ?>
            <h4 class="text-secondary mr-2">Aguardando: </h4>
            <div class="table-responsive col-md-8 px-0">
                <table class="table table-striped table-hover table-border">
                    <thead class="bg-info text-light">
                    <tr class="text-center">
                        <th class="">Atividades</th>
                        <th class="">Status</th>
                        <th class="">Cliente</th>
                        <th class="" tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Data e hora da solicitação">
                            Data
                        </th>
                        <th class="">Ações</th>
                    </tr>
                    </thead>
                    <?php
                    foreach ($this->Dados['listarAtendimentosInterrompido'] as $interrompido) {
                        extract($interrompido);
                        ?>
                        <tr class="text-warning">
                            <td>
                                 <span tabindex='0' data-placement='right' data-toggle='tooltip' title='Demanda: <?php echo $demanda; ?>'>
                                    <?php echo $nome_atividade; ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-<?php echo $cor ?>">
                                    <?php echo $nome_situacao; ?>
                                </span>
                            </td>
                            <td>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" title="<?php echo ucwords(strtolower($nome_empresa)); ?>">
                                    <?php
                                    echo strtoupper($fantasia_empresa);
                                    ?>
                                </span>
                            </td>
                            <td>
                                <?php
                                    echo date('H\hi - d/m/Y', strtotime($created));
                                ?>
                            </td>
                            <td>
                                <span tabindex='0' data-placement='top' data-toggle='tooltip' title='Clique para continuar o atendimento.'>
                                    <a href="<?php echo URLADM . 'atendimento-status/alterar/'.$id_aten_func . '?status=3&pg='.$this->Dados['pg']; ?>" class="btn btn-outline-info btn-sm mb-2 btnOpcoes"
                                       data-sitAtenContinuar='Tem certeza que deseja da continuidade ao atendimento agora?'>
                                        Continuar
                                    </a>
                                </span>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <hr>
            <?php
            }
            ?>


            <h4 class="text-secondary mr-2">Últimos: </h4>
            <?php
                //var_dump($this->Dados['listarAtendimentos']);
                if (empty($this->Dados['listarAtendimentos'])) {
                ?>

                <div class="alert alert-secondary alert-dismissible text-center py-5 fade show" role="alert">
                    Nenhum atendimento a ser listado!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <?php
            } else
            {

                ?>

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-border">
                        <thead class="bg-info text-light">
                        <tr class="text-center">
                            <th class="">Opções</th>
                            <th class="">Demanda</th>
                            <th class="">Descricao</th>
                            <th class="">Atividades</th>
                            <th class="">Duração</th>
                            <th class="">Data de início</th>
                            <th class="">
                                <span class="d-block text-center border-bottom pb-1 mb-1">Planejamento</span>
                                <div class="d-flex justify-content-between">
                                    <span>Inicio</span>
                                    <span>Términio</span>
                                </div>
                            </th>
                            <th class="">Tempo Restante</th>
                            <th class="">Status</th>
                            <th class="">Empresa</th>
                            <th class="">Ações</th>
                        </tr>
                        <tr>

                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        //var_dump($this->Dados['listarAtendimentos']);
                        // Listar atendimentos
                            // Temporario para exibir luz de aviso
                            $contLuz = 0;


                            foreach ($this->Dados['listarAtendimentos'] as $atendimento){
                                extract($atendimento);
                        ?>
                        <tr class="text-center">
                            <td>
                                <?php
                                $contLuz++;
                                    if ( !empty($data_fatal) and (date('Y-m-d', strtotime($data_fatal)) == date('Y-m-d'))){
                                ?>
                                <span class="text-warning" tabindex='0' data-placement='top' data-toggle='tooltip' title='Aviso! A data limite para concluir o atendimento é hoje.'>
                                    <i class="fas fa-lightbulb faIpac mr-2"></i>
                                </span>
                                <?php
                                    } elseif ( !empty($data_fatal) and (date('Y-m-d', strtotime($data_fatal)) < date('Y-m-d'))){
                                ?>
                                <span class="text-danger" tabindex='0' data-placement='top' data-toggle='tooltip' title='Atenção! Atendimento ultrapassou a data limite de entrega.'>
                                    <i class="fas fa-lightbulb faIpac mr-2"></i>
                                </span>
                                <?php
                                } else {
                                ?>
                                <span class="text-transparente">
                                    <i class="fas fa-lightbulb"></i>
                                </span>
                                <?php
                                }
                                if ($id_sits_aten_func == 1) {
                                    // Não iniciado
                                    ?>
                                    <span tabindex='0' data-placement='top' data-toggle='tooltip' title='Clique para iniciar atendimento.'>
                                        <a href="<?php echo URLADM . 'atendimento-status/alterar/'.$id_aten_func . '?status='.$id_sits_aten_func.'&pg='.$this->Dados['pg']. '&aten='.$id_atendimento; ?>" class="btn btn-outline-success btn-sm mb-2 btnOpcoes"  data-sitAtenIniciar='Tem certeza que deseja iniciar o atendimento?'>
                                            Iniciar
                                        </a>
                                    </span>
                                    <?php
                                } elseif ($id_sits_aten_func == 2){
                                    // Iniciado
                                    ?>


                                    <a href="#" class="btn btn-secondary btn-sm mb-2 btnOpcoesDisabled disabled">
                                        Em andamento
                                    </a>
                                    <span tabindex='0' data-placement='top' data-toggle='tooltip' title='Clique para pausar o atendimento.'>
                                        <a href="<?php echo URLADM . 'atendimento-status/alterar/'.$id_aten_func . '?status='.$id_sits_aten_func.'&pg='.$this->Dados['pg']. '&aten='.$id_atendimento; ?>" class="btn btn-outline-warning btn-sm mb-2" data-sitAtenPausar='Tem certeza que deseja pausar o atendimento?'>
                                            Pausar
                                        </a>
                                    </span>


                                    <?php
                                } elseif ($id_sits_aten_func == 3) {
                                    // Pausado
                                    ?>
                                    <span tabindex='0' data-placement='top' data-toggle='tooltip' title='Clique para continuar o atendimento.'>
                                        <a href="<?php echo URLADM . 'atendimento-status/alterar/'.$id_aten_func . '?status='.$id_sits_aten_func.'&pg='.$this->Dados['pg']. '&aten='.$id_atendimento; ?>" class="btn btn-outline-info btn-sm mb-2 btnOpcoes"
                                           data-sitAtenContinuar='Tem certeza que deseja da continuidade ao atendimento agora?'>
                                            Continuar
                                        </a>
                                    </span>
                                    <a href="#" class="btn btn-secondary btn-sm mb-2 btnOpcoesDisabled disabled">
                                        Pausar
                                    </a>
                                    <?php
                                } else {
                                    // Finalizado
                                    ?>
                                    <span tabindex='0' data-placement='right' data-toggle='tooltip' title='Atendimento finalizado.'>
                                        <a href="#" class="btn btn-dark btn-sm mb-2 btnOpcoes btnOpcoesDisabled disabled">
                                            Finalizado
                                        </a>
                                    </span>
                                    <?php
                                }
                                ?>
                            </td>
                            <td>
                                <span tabindex='0' data-placement='right' data-toggle='tooltip' title='Descrição: <?php echo $descricao_demanda; ?>'>
                                    <?php echo $nome_demanda ?>
                                </span>
                            </td>
                            <td>
                                <?php echo $descricao_atendimento ?>
                            </td>
                            <td>
                                <span tabindex='0' data-placement='right' data-toggle='tooltip' title='Descrição: <?php echo $descricao_atividade; ?>'>
                                    <?php echo $nome_atividade; ?>
                                </span>
                            </td>
                            <td>
                                <?php
                                    echo date('H\hi', strtotime($duracao_atividade));
                                ?>
                            </td>
                            <td>
                                <span class="d-flex flex-column align-items-baseline">
                                <?php
                                    echo "<span>" . date('d/m/Y', strtotime($data_inicio_planejado)) . "</span>";
                                    if (($hora_inicio_planejado < $hora_termino2) and ($hora_fim_planejado > $hora_termino2)){

                                        $data = new DateTime(date('Y-m-d', strtotime($data_inicio_planejado)));
                                        $data->modify('+1 day');
                                        $dia_seguinte = $data->format('Y-m-d');
                                        // Verificar se é fim de semanda ou não
                                        $data = getdate(strtotime($dia_seguinte));
                                        if (($data['wday'] == 6) or ($data['wday'] == 0)) {
                                            if ($data['wday'] == 6){
                                                // se for sabado
                                                $dias = 2;
                                            } else {
                                                // se for domingo
                                                $dias = 1;
                                            }

                                            $data = new DateTime(date('Y-m-d', strtotime($dia_seguinte)));
                                            $data->modify('+'.$dias.' day');
                                            $dia_seguinte = $data->format('Y-m-d');
                                        } else {
                                            // verificar se é feriado
                                            $diaMes = date('d/m',strtotime($dia_seguinte));
                                            $ano = date('Y');
                                            $feriados = getFeriados($ano);
                                            foreach ($feriados as $feriado) {
                                                if ($feriado == $diaMes){
                                                    // somar um dia
                                                    $data = new DateTime(date('Y-m-d', strtotime($dia_seguinte)));
                                                    $data->modify('+1 day');
                                                    $dia_seguinte = $data->format('Y-m-d');
                                                }
                                            }
                                        }
                                        $dia_seguinte = date('d/m/Y', strtotime($dia_seguinte));
                                        echo "<span class='mt-4'>$dia_seguinte</span>";
                                    }
                                ?>
                                </span>
                            </td>
                            <td class="planejamento_i_t d-flex flex-column justify-content-between">

                                    <?php
                                        // Verificar se a hora de execução da atividade utrapassa o horario de almoço
                                    /*
                                        $extraa = explode(':', $hora_extra);
                                        $data = new DateTime(date('H:i', strtotime($hora_termino2)));
                                        $data->modify('+' . $extraa[0] . ' hours');
                                        $data->modify('+' . $extraa[1] . ' minutes');
                                        $hora_termino2 = $data->format('H:i');
                                    */
                                        if (($hora_inicio_planejado < $hora_termino) and ($hora_fim_planejado > $hora_termino)){
                                            $valor = explode(':', $hora_inicio_planejado);
                                            $data = new DateTime(date('H:i', strtotime($hora_termino)));
                                            $data->modify('-' . $valor[0] . ' hours');
                                            $data->modify('-' . $valor[1] . ' minutes');
                                            $hora_trab = $data->format('H:i'); // Obtendo o resultado de horas a serem trabalhada antes do almoço

                                            $valor2 = explode(':', $hora_trab);
                                            $data = new DateTime(date('H:i', strtotime($duracao_atividade)));
                                            $data->modify('-' . $valor2[0] . ' hours');
                                            $data->modify('-' . $valor2[1] . ' minutes');
                                            $hora_rest = $data->format('H:i'); // o tempo restante a ser trabalhado na atividade

                                            $valor3 = explode(':', $hora_rest);
                                            $data = new DateTime(date('H:i', strtotime($hora_inicio2)));
                                            $data->modify('+' . $valor3[0] . ' hours');
                                            $data->modify('+' . $valor3[1] . ' minutes');
                                            $hora_fim = $data->format('H:i'); // somar hora de inicio_2 com hora_rest para exibir quando deve concluir a atividade

                                            if ($hora_fim > $hora_termino2) {

                                                $diferenca = explode(':', $hora_termino2);
                                                $data = new DateTime(date('H:i', strtotime($hora_fim)));
                                                $data->modify('-' . $diferenca[0] . ' hours');
                                                $data->modify('-' . $diferenca[1] . ' minutes');
                                                $hora_proximo_dia = $data->format('H:i');

                                                $novo_termino = explode(':', $hora_proximo_dia);
                                                $data = new DateTime(date('H:i', strtotime($hora_inicio)));
                                                $data->modify('+' . $novo_termino[0] . ' hours');
                                                $data->modify('+' . $novo_termino[1] . ' minutes');
                                                $hora_fim = $data->format('H:i');

                                                echo '<span class="d-flex justify-content-between">';
                                                echo '<span id="horaInicioCp" class="badge badge-secondary">';
                                                echo date('H:i', strtotime($hora_inicio_planejado));
                                                echo '</span>';
                                                echo '<span id="horaTerminoCp" class="badge badge-success">';
                                                echo date('H:i', strtotime($hora_termino));
                                                echo '</span>';
                                                echo '</span>';
                                                // intervalo almoço
                                                echo "<small class='text-success'>Pausa almoço</small>";
                                                echo '<span class="d-flex justify-content-between mt-2">';
                                                echo '<span id="horaInicioCp" class="badge badge-success">';
                                                echo date('H:i', strtotime($hora_inicio2));
                                                echo '</span>';



                                                echo '<span id="horaTerminoCp" class="badge badge-danger">';
                                                echo date('H:i', strtotime($hora_termino2));
                                                echo '</span>';
                                                echo '</span>';
                                                // fim expediente
                                                echo "<small class='text-danger'>Fim expediente</small>";
                                                echo '<span class="d-flex justify-content-between mt-2">';
                                                echo '<span id="horaInicioCp" class="badge badge-danger">';
                                                echo date('H:i', strtotime($hora_inicio));
                                                echo '</span>';


                                                // ultima hora da atividade
                                                echo '<span id="horaTerminoCp" class="badge badge-secondary">';
                                                echo date('H:i', strtotime($hora_fim));
                                                echo '</span>';
                                                echo '</span>';


                                            } else {

                                                echo '<span class="d-flex justify-content-between">';
                                                    echo '<span id="horaInicioCp" class="badge badge-secondary">';
                                                        echo date('H:i', strtotime($hora_inicio_planejado));
                                                    echo '</span>';
                                                    echo '<span id="horaTerminoCp" class="badge badge-success">';
                                                        echo date('H:i', strtotime($hora_termino));
                                                    echo '</span>';
                                                echo '</span>';
                                                // intervalo almoço
                                                echo "<small class='text-success'>Pausa almoço</small>";
                                                echo '<span class="d-flex justify-content-between mt-2">';
                                                    echo '<span id="horaInicioCp" class="badge badge-success">';
                                                        echo date('H:i', strtotime($hora_inicio2));
                                                    echo '</span>';
                                                    echo '<span id="horaTerminoCp" class="badge badge-secondary">';
                                                        echo date('H:i', strtotime($hora_fim));
                                                    echo '</span>';
                                                echo '</span>';
                                            }


                                        } elseif (($hora_inicio_planejado < $hora_termino2) and ($hora_fim_planejado > $hora_termino2)){
                                            $valorex = explode(':', $hora_inicio_planejado);
                                            $data = new DateTime(date('H:i', strtotime($hora_termino2)));
                                            $data->modify('-' . $valorex[0] . ' hours');
                                            $data->modify('-' . $valorex[1] . ' minutes');
                                            $hora_trabex = $data->format('H:i'); // Obtendo o resultado de horas a serem trabalhada antes do fim expediente

                                            $valor2ex = explode(':', $hora_trabex);
                                            $data = new DateTime(date('H:i', strtotime($duracao_atividade)));
                                            $data->modify('-' . $valor2ex[0] . ' hours');
                                            $data->modify('-' . $valor2ex[1] . ' minutes');
                                            $hora_restex = $data->format('H:i'); // o tempo restante a ser trabalhado na atividade no proximo dia


                                            $valor3ex = explode(':', $hora_restex);
                                            $data = new DateTime(date('H:i', strtotime($hora_inicio)));
                                            $data->modify('+' . $valor3ex[0] . ' hours');
                                            $data->modify('+' . $valor3ex[1] . ' minutes');
                                            $hora_fimex = $data->format('H:i'); // somar hora de inicio_2 com hora_rest para exibir quando deve concluir a atividade

                                            if ($hora_fimex > $hora_termino){

                                                $almoco = explode(':', $hora_termino);
                                                $data = new DateTime(date('H:i', strtotime($hora_inicio2)));
                                                $data->modify('-' . $almoco[0] . ' hours');
                                                $data->modify('-' . $almoco[1] . ' minutes');
                                                $hora_almoco = $data->format('H:i');

                                                $valor3exAlmo = explode(':', $hora_restex);
                                                $data = new DateTime(date('H:i', strtotime($hora_inicio)));
                                                $data->modify('+' . $valor3exAlmo[0] . ' hours');
                                                $data->modify('+' . $valor3exAlmo[1] . ' minutes');
                                                $hora_fimexSemAlmo = $data->format('H:i');

                                                $valor3exAlmoRes = explode(':', $hora_almoco);
                                                $data = new DateTime(date('H:i', strtotime($hora_fimexSemAlmo)));
                                                $data->modify('+' . $valor3exAlmoRes[0] . ' hours');
                                                $data->modify('+' . $valor3exAlmoRes[1] . ' minutes');
                                                $hora_fimex = $data->format('H:i');

                                                echo '<span class="d-flex justify-content-between">';
                                                echo '<span id="horaInicioCp" class="badge badge-secondary">';
                                                echo date('H:i', strtotime($hora_inicio_planejado));
                                                echo '</span>';
                                                echo '<span id="horaTerminoCp" class="badge badge-danger">';
                                                echo date('H:i', strtotime($hora_termino2));
                                                echo '</span>';
                                                echo '</span>';
                                                // fim expediente
                                                echo "<small class='text-danger'>Fim expediente</small>";
                                                echo '<span class="d-flex justify-content-between mt-2">';
                                                echo '<span id="horaInicioCp" class="badge badge-danger">';
                                                echo date('H:i', strtotime($hora_inicio));
                                                echo '</span>';


                                                echo '<span id="horaTerminoCp" class="badge badge-success">';
                                                echo date('H:i', strtotime($hora_termino));
                                                echo '</span>';
                                                echo '</span>';
                                                // intervalo almoço
                                                echo "<small class='text-success'>Pausa almoço</small>";
                                                echo '<span class="d-flex justify-content-between mt-2">';
                                                echo '<span id="horaInicioCp" class="badge badge-success">';
                                                echo date('H:i', strtotime($hora_inicio2));
                                                echo '</span>';

                                                // Hora final da atividade
                                                echo '<span id="horaTerminoCp" class="badge badge-secondary">';
                                                echo date('H:i', strtotime($hora_fimex));
                                                echo '</span>';
                                                echo '</span>';


                                            } else {

                                            echo '<span class="d-flex justify-content-between">';
                                                echo '<span id="horaInicioCp" class="badge badge-secondary">';
                                                echo date('H:i', strtotime($hora_inicio_planejado));
                                                echo '</span>';
                                                echo '<span id="horaTerminoCp" class="badge badge-danger">';
                                                echo date('H:i', strtotime($hora_termino2));
                                                echo '</span>';
                                            echo '</span>';
                                            // fim expediente
                                            echo "<small class='text-danger'>Fim expediente</small>";
                                            echo '<span class="d-flex justify-content-between mt-2">';
                                                echo '<span id="horaInicioCp" class="badge badge-danger">';
                                                echo date('H:i', strtotime($hora_inicio));
                                                echo '</span>';
                                                echo '<span id="horaTerminoCp" class="badge badge-secondary">';
                                                echo date('H:i', strtotime($hora_fimex));
                                                echo '</span>';
                                            echo '</span>';
}

                                        }
                                        else {
                                        ?>
                                        <span class="d-flex justify-content-between">
                                            <span id="horaInicioCp" class="badge badge-secondary">
                                                <?php
                                                echo date('H:i', strtotime($hora_inicio_planejado));
                                                ?>
                                            </span>
                                            <span id="horaTerminoCp" class="badge badge-secondary">
                                                <?php
                                                echo date('H:i', strtotime($hora_fim_planejado));
                                                ?>
                                            </span>
                                        </span>
                                        <?php
                                            }
                                    ?>
                            </td>
                            <td>
                                <!-- Calculo para exibir o tempo restante -->
                                <?php
                                    if ($id_sits_aten_func == 1) {
                                        echo '<span tabindex="0" data-placement="top" data-toggle="tooltip" title="Esse atendimento ainda não foi iniciado">--:--</span>';
                                        //echo "--:--";
                                    } elseif ($id_sits_aten_func == 3){

                                        echo '<span tabindex="0" data-placement="top" data-toggle="tooltip" title="Hora/minutos">';

                                        if (!empty($at_tempo_restante) AND empty($at_tempo_excedido)) {
                                            if (date('H:i', strtotime($at_tempo_restante)) < date('H:i', strtotime('01:00'))){
                                                echo date('i\m', strtotime($at_tempo_restante));
                                            } else {
                                                echo date('H\hi', strtotime($at_tempo_restante));
                                            }
                                        }
                                        elseif (!empty($at_tempo_excedido)) {

                                            echo "<span id='sessao' class='text-danger'>";
                                            echo "-".date('H\hi', strtotime($at_tempo_excedido));
                                            echo "</span>";

                                        } else {
                                            echo "--:--";
                                        }

                                        echo '</span>';


                                    } elseif ($id_sits_aten_func == 2) {

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

                                            $tempo_restanteUrgente = $segundosTotal - $segundosAndamento;

                                            echo "<span id='sessaoUrgente' class='text-primary'></span>";

                                            $valorControler = 0;

                                        } elseif (!empty($at_tempo_excedido)){

                                            echo '<span tabindex="0" data-placement="top" data-toggle="tooltip" title="Atendimento atrasado!">';

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

                                            $tempo_restanteUrgente = $segundosTotal + $segundosAndamento;

                                            echo "<span id='sessaoUrgente' class='text-primary'></span>";

                                            $valorControler = 1;

                                            echo '</span>';

                                        } else {
                                            echo "--:--";
                                        }
                                    }
                                ?>

                            </td>
                            <td>
                                 <span tabindex="0" data-toggle="tooltip" data-placement="right" data-html="true" title="<?php echo "Esse é o status que o cliente visualiza nesse momento. Quando houver alterações ele será informado.";?>">
                                    <span class="badge badge-<?php echo $cor_sit_aten_func ?>">
                                        <?php echo $nome_sits_aten_func; ?>
                                    </span>
                                </span>
                            </td>
                            <td>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" title="<?php echo ucwords(strtolower($nome_empresa)); ?>">
                                    <?php
                                        echo strtoupper($fantasia_empresa);
                                    ?>
                                </span>
                            </td>
                            <td class="text-right">
                                <?php
                                if (isset($ooops)) { ?>
                                    <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true"
                                          title="Visualizar">
                                            <a href="<?php echo URLADM . 'funcionario-ver-atendimento/ver/' . $id_aten_func . '?pg=' . $this->Dados['pg']; ?>" class="btn btn-outline-primary btn-sm mb-2">
                                                <i class="far fa-eye"></i>
                                            </a>
                                        </span>
                                    <?php
                                }
                                if (($this->Dados['botao']['conclu']) AND ($id_sits_aten_func == 2 OR $id_sits_aten_func == 3)) { ?>
                                    <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Finalizar">
                                        <a href="<?php echo URLADM . 'func-concluir-atendimento/concluir/' . $id_aten_func. '?status='. $id_sits_aten_func .'&pg='.$this->Dados['pg'] . '&aten='.$id_atendimento; ?>" class="btn btn-outline-success btn-sm mb-2" data-confirmFinalizar='Finalizar atendimento'>
                                            <i class="fas fa-clipboard-check"></i>
                                        </a>
                                    </span>
                                <?php
                                }
                                if ( $id_sits_aten_func == 3){
                                ?>
                                    <!--
                                        <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Interromper atendimento temporariamente?">
                                            <a href="<?php echo URLADM . 'atendimento-status/alterar/'.$id_aten_func . '?status=5&pg='.$this->Dados['pg']; ?>" class="btn btn-outline-warning btn-sm mb-2" data-confirmInterromper='Interromper atendimento temporariamente?'>
                                                <i class="fas fa-hand-paper"></i>
                                            </a>
                                        </span>
                                        -->
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                            } // Fim do foreach
                        ?>
                        </tbody>

                    </table>

                    <?php

                    echo $this->Dados['paginacao'];

                    ?>

                </div>


                <?php
            }
            ?>


        </div>


    </div>
    <?php
    //var_dump($this->Dados);
    ?>
    <!-- Container de teste
    <div id="containerTestePhp">


    </div>
    #Ende container de teste-->

</div>


<script type="text/javascript">
    function Parametros(hora_inicio, hora_termino, hora_inicio2, hora_termino2, adms_funcionario_id) {
        document.getElementById('hora_inicio').value = hora_inicio;
        document.getElementById('hora_termino').value = hora_termino;
        document.getElementById('hora_inicio2').value = hora_inicio2;
        document.getElementById('hora_termino2').value = hora_termino2;
        document.getElementById('adms_funcionario_id').value = adms_funcionario_id;
    }
</script>

<!-- Modal -->
<div class="modal fade" id="editarFuncionarioModal" tabindex="-1" role="dialog" aria-labelledby="editandoFuncionario" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title" id="editandoFuncionario"><i class="fas fa-eye"></i> Ver Planejamento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
              </div>
            <form method="post" action="">
                <div class="modal-body">
                    <fieldset>
                        <legend>Período da manhã:</legend>
                        <div class="form-row mb-3">
                            <div class="col-md-6">
                                <label for="hora_inicio">Início</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-hourglass-start"></i>
                                            </div>
                                        </div>
                                        <input type="text" name="hora_inicio" id="hora_inicio" class="form-control" disabled>
                                    </div>
                            </div>

                            <div class="col-md-6">
                                <label for="hora_termino">Término</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-hourglass-end"></i>
                                            </div>
                                        </div>
                                        <input name="hora_termino" type="text" id="hora_termino" class="form-control" disabled>
                                    </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Período da tarde:</legend>
                        <div class="form-row mb-3">
                            <div class="col-md-6">
                                <label for="hora_inicio2">Início</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-hourglass-start"></i>
                                            </div>
                                        </div>
                                        <input type="text" name="hora_inicio2" id="hora_inicio2" class="form-control" disabled>
                                    </div>
                            </div>

                            <div class="col-md-6">
                                <label for="hora_termino2">Término</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-hourglass-end"></i>
                                            </div>
                                        </div>
                                        <input name="hora_termino2" type="text" id="hora_termino2" class="form-control" disabled>
                                    </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Calculo tempo restante -->
<script src="<?php echo URLADM.'assets/js/temporizador/jquery-1.9.1.min.js'; ?>"></script>
<?php
if (!empty($tempo_restanteUrgente)) {
    $scriptInicio = "<script>";
    $scriptFinal = "</script>";
    // O tempo tem que ser obrigatoriamente em segundos


    $script = $scriptInicio . "var tempoUrgente = '" . $tempo_restanteUrgente . "'; var controlerU = '" . $valorControler . "';" . $scriptFinal;
    echo $script;
    ?>

    <script type="text/javascript">

        //var tempo = new Number();
        //var controler = 0;
        // Tempo em segundos
        //tempo = 7;

        function startCountdownU(){

            // Se o tempo não for zerado
            if(((tempoUrgente - 1) >= 0) && (controlerU == 0)){

                // Pega a parte inteira dos minutos
                var minU = parseInt(tempoUrgente/60);

                // horas, pega a parte inteira dos minutos
                var horU = parseInt(minU/60);

                //atualiza a variável minutos obtendo o tempo restante dos minutos
                minU = minU % 60;


                // Calcula os segundos restantes
                var segU = tempoUrgente%60;

                // Formata o número menor que dez, ex: 08, 07, ...
                if(minU < 10)
                {
                    minU = "0"+minU;
                    minU = minU.substr(0, 2);
                }

                if(segU <=9)
                {
                    segU = "0"+segU;
                }

                if(horU <=9)
                {
                    horU = "0"+horU;
                }

                // Cria a variável para formatar no estilo hora/cronômetro
                horaImprimivelU = horU+':' + minU + ':' + segU;

                //JQuery pra setar o valor
                $("#sessaoUrgente").html(horaImprimivelU);

                // Define que a função será executada novamente em 1000ms = 1 segundo
                setTimeout('startCountdownU()',1000);

                // diminui o tempo
                tempoUrgente--;

            } else {
                controlerU = 1;

                // Pega a parte inteira dos minutos
                var minU = parseInt(tempoUrgente/60);

                // horas, pega a parte inteira dos minutos
                var horU = parseInt(minU/60);

                //atualiza a variável minutos obtendo o tempo excedido dos minutos
                minU = minU % 60;

                // Calcula os segundos excedido
                var segU = tempoUrgente%60;

                // Formata o número menor que dez, ex: 08, 07, ...
                if(minU < 10){
                    minU = "0"+minU;
                    minU = minU.substr(0, 2);
                }
                if(segU <=9){
                    segU = "0"+segU;
                }
                if(horU <=9){
                    horU = "0"+horU;
                }

                // Cria a variável para formatar no estilo hora/cronômetro
                horaImprimivelU = '-' + horU + ':' + minU + ':' + segU;

                //JQuery pra setar o valor
                $('#sessaoUrgente').attr('class', 'text-danger');
                $("#sessaoUrgente").html(horaImprimivelU);

                // Define que a função será executada novamente em 1000ms = 1 segundo
                setTimeout('startCountdownU()',1000);

                // somar o tempo
                tempoUrgente++;
            }

        }

        // Chama a função ao carregar a tela
        startCountdownU();

    </script>

    <?php
}
?>


