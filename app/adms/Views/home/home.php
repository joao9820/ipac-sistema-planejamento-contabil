<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
//var_dump($this->Dados['atendimentos_total']);


//echo $num_result ."<br>";
//echo $_SESSION['adms_empresa_id'];
?>
<!-- Carregar a API do google -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<!-- Preparar a geracao do grafico -->
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



    <div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Dashboard</h2>
            </div>
        </div>

        <div class="row mb-3  bg-white text-dark shadow py-4">
            <div class="col-md-4">
                <div id="area_grafico_atendimentos" class="card border-0">
                    <div class="card-body">
                        <div ></div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div id="area_grafico_demandas" class="card border-0">
                    <div class="card-body">
                        <div ></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div id="area_grafico_usuarios" class="card border-0">
                    <div class="card-body">
                        <div ></div>
                    </div>
                </div>
            </div>

            <div id="funcionarios_demanda_folha" style="width: 500px; height: 400px;"></div>
            <div id="funcionarios_demanda_contabil" style="width: 500px; height: 400px;"></div>
            <div id="funcionarios_demanda_fiscal" style="width: 500px; height: 400px;"></div>
        </div>



    </div>
</div>
