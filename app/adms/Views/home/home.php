<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
//var_dump($this->Dados['atendimentos_total']);


//echo $num_result ."<br>";
//echo $_SESSION['adms_empresa_id'];
?>


<!-- Preparar a geracao do grafico
    <script type="text/javascript">

    // Carregar a API de visualizacao e os pacotes necessarios.
    google.load('visualization', '1.0', {'packages':['corechart']});

    // Especificar um callback para ser executado quando a API for carregada.
    google.setOnLoadCallback(graficoAtendimentos);
    google.setOnLoadCallback(graficoDemandas);
    google.setOnLoadCallback(graficoUsuarios);

    /**
     * Funcao que preenche os dados do grafico
     */
    function graficoAtendimentos() {
        // Montar os dados usados pelo grafico
        var dados = new google.visualization.DataTable();
        dados.addColumn('string', 'Gênero');
        dados.addColumn('number', 'Quantidades');
        dados.addRows([
            ['Novo', 34],
            ['Em Andamento', 20],
            ['Atrasado', 10],
            ['Concluido', 30]
        ]);

        // Configuracoes do grafico
        var config = {
            'title':'Atendimentos',
            'width':500,
            'height':400
        };

        // Instanciar o objeto de geracao de graficos de pizza,
        // informando o elemento HTML onde o grafico sera desenhado.
        var chart = new google.visualization.PieChart(document.getElementById('area_grafico_atendimentos'));

        // Desenhar o grafico (usando os dados e as configuracoes criadas)
        chart.draw(dados, config);
    }

    /**
     * Funcao que preenche os dados do grafico
     */
    function graficoDemandas() {
        // Montar os dados usados pelo grafico
        var dados = new google.visualization.DataTable();
        dados.addColumn('string', 'Gênero');
        dados.addColumn('number', 'Quantidades');
        dados.addRows([
            ['Demandas', 19]
        ]);

        // Configuracoes do grafico
        var config = {
            'title':'Total de Demandas',
            'width':500,
            'height':400
        };

        // Instanciar o objeto de geracao de graficos de pizza,
        // informando o elemento HTML onde o grafico sera desenhado.
        var chart = new google.visualization.PieChart(document.getElementById('area_grafico_demandas'));

        // Desenhar o grafico (usando os dados e as configuracoes criadas)
        chart.draw(dados, config);

    }

    function graficoUsuarios() {
        // Montar os dados usados pelo grafico
        var dados = new google.visualization.DataTable();
        dados.addColumn('string', 'Gênero');
        dados.addColumn('number', 'Quantidades');
        dados.addRows([
            ['Ativo', 34],
            ['Inativo', 5],
            ['Bloqueado', 2],
        ]);

        // Configuracoes do grafico
        var config = {
            'title':'Usuários',
            'width':500,
            'height':400
        };

        // Instanciar o objeto de geracao de graficos de pizza,
        // informando o elemento HTML onde o grafico sera desenhado.
        var chart = new google.visualization.PieChart(document.getElementById('area_grafico_usuarios'));

        // Desenhar o grafico (usando os dados e as configuracoes criadas)
        chart.draw(dados, config);
    }

    function graficoFolha() {
        var wrapper = new google.visualization.ChartWrapper({
            chartType: 'ColumnChart',
            dataTable: [
                ['',
                    'Maria',
                    'Jhon',
                    'Ricardo',
                    'Ana',
                    'Junior',
                    'Vivia'],
                ['',
                    15,
                    10,
                    30,
                    17,
                    5,
                    9]
            ],
            options: {'title': 'Funcionários - Demandas (Folha)'},
            containerId: 'funcionarios_demanda_folha'
        });
        wrapper.draw();
    }
    google.setOnLoadCallback(graficoFolha);

    function graficoContabil() {
        var wrapper = new google.visualization.ChartWrapper({
            chartType: 'ColumnChart',
            dataTable: [
                ['',
                    'João',
                    'Valdeir',
                    'Raiane',
                    'Julha'],
                ['',
                    33,
                    17,
                    5,
                    9]
            ],
            options: {'title': 'Funcionários - Demandas (Contábil)'},
            containerId: 'funcionarios_demanda_contabil'
        });
        wrapper.draw();
    }
    google.setOnLoadCallback(graficoContabil);

    function graficoFiscal() {
        var wrapper = new google.visualization.ChartWrapper({
            chartType: 'ColumnChart',
            dataTable: [
                ['',
                    'Benedito',
                    'Ivania',
                    'Rafaela',
                    'Caroline'],
                ['',
                    33,
                    17,
                    5,
                    9]
            ],
            options: {'title': 'Funcionários - Demandas (Fiscal)'},
            containerId: 'funcionarios_demanda_fiscal'
        });
        wrapper.draw();
    }
    google.setOnLoadCallback(graficoFiscal);
</script>
-->


<style>


    .card {
        box-shadow: 0 0 5px rgba(0,0,0,0.125);
        position: relative;
    }
    .card-body {
        min-height: 150px;
        padding: 0;
    }
    .card-body .card-left {
        width: 30%;
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
    }
    .gradiente-azul {
        background-image: linear-gradient(to left, #22a5d5, #2b2c7c);
    }
    .gradiente-vermelho {
        background-image: linear-gradient(to left, #dfd223, #d52222);
    }
    .gradiente-verde {
        background-image: linear-gradient(to left, #6092d4, #b122d5);
    }
    .card-left .card-fundo-title {
        position: absolute;
        background: #FFF;
        min-height: 25px;
        min-width: 150px;
        text-align: center;
        box-shadow: 0 0 5px rgba(0,0,0,0.125);
        border-radius: 0.25rem;
        left: 10px;
        top: 10px;
        font-size: 1em;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        padding: 5px;
    }
    .card-body .card-right {
        padding-top: 35px;
        width: 70%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: center;
    }
    .card-right h1 {
        font-size: 4rem;
        margin: 0;
        color: #505050;
    }
    .card-right span {
        font-size: .7rem;
        margin-bottom: 5px;
    }
</style>

<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Dashboard</h2>
            </div>
        </div>

        <div class="row mb-3 py-4">

            <div class="col-md-4 col-lg-3">
                <div class="card" style="cursor: pointer;">
                    <div class="card-body d-flex">
                        <div class="card-left gradiente-azul">
                            <div class="card-fundo-title ">
                                <span class="">Atividades em execução</span>
                            </div>
                        </div>
                        <div class="card-right text-title">
                            <h1>65</h1>
                            <span class="text-secondary"><i class="fas fa-chart-line"></i> Listar atividades</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-lg-3">
                <div class="card" style="cursor: pointer;">
                    <div class="card-body d-flex">
                        <div class="card-left gradiente-verde">
                            <div class="card-fundo-title ">
                                <span class="">Atividades em execução tempo decorrido superior</span>
                            </div>
                        </div>
                        <div class="card-right text-title">
                            <h1>65</h1>
                            <span class="text-secondary"><i class="fas fa-chart-line"></i> Listar atividades com tempo superior ao tempo planejado</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row mb-3 py-4">

            <p class="col-12">Alocação</p>

            <div class="col-md-4 col-lg-3">
                <div onclick="window.location.href='<?php echo URLADM . 'alocacao/listar'; ?>'" class="card" style="cursor: pointer;">
                    <div class="card-body d-flex">
                        <div class="card-left gradiente-vermelho">
                            <div class="card-fundo-title ">
                                <span class="">Percentual de Alocação</span>
                            </div>
                        </div>
                        <div class="card-right text-title">
                            <h1>65%</h1>
                            <span class="text-secondary"><i class="fas fa-chart-line"></i> Listar atividades</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>



    </div>
</div>
