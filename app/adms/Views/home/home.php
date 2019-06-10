<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
//var_dump($this->Dados['atendimentos_total']);


//echo $num_result ."<br>";
//echo $_SESSION['adms_empresa_id'];
?>


<style>


    .card {
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
        background: rgba(255,255,255,.7);
        min-height: 25px;
        width: 100%;
        height: auto;
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
        justify-content: right;
        text-align: right;
        margin-right: 10px;
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

<div class="content p-1 px-md-3">

        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Dashboard</h2>
            </div>
        </div>

        <div class="row mb-3 py-4">

            <div class="col-md-5 col-lg-4 mb-3">
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

            <div class="col-md-5 col-lg-4">
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

            <h4 class="col-12">Alocação</h4>

            <div class="col-md-5 col-lg-4">
                <div onclick="window.location.href='<?php echo URLADM . 'alocacao/listar'; ?>'" class="card" style="cursor: pointer;">
                    <div class="card-body d-flex">
                        <div class="card-left gradiente-vermelho">
                            <div class="card-fundo-title ">
                                <span class="">Percentual de Alocação</span>
                            </div>
                        </div>
                        <div class="card-right text-title">
                            <h1><?php echo number_format($this->Dados['alocacao'], 0, ',', ' ') . "%" ?></h1>
                            <span class="text-secondary"><i class="fas fa-chart-line"></i> Listar alocação por gerentes</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

</div>
