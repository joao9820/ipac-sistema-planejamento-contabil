<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 09/05/2019
 * Time: 12:40
 */
if (!defined('URL')) {
    header("Location: /");
    exit();
}
//var_dump($this->Dados['listarAtenFunc']);
?>
<style>

    .cardGerente {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        font-size: 3em;
    }
    .cardBorder, .cardGerente {
        transition: all .3s ease-in-out;
    }
    .cardBorder:hover {
        border-color: #2b2c7c !important;
    }
    .cardBorder:hover .cardGerente {
        background: #2b2c7c !important;
    }

</style>

<div class="content p-1">
    <div class="list-group-item">
        <div class="row">
            <div class="col-md-12 p-2">
                <h2 class="display-4 titulo">Alocação em desenvolvimento</h2>

            </div>

            <div class="col-md-12 d-flex justify-content-end">
                <form method="post" action="" class="form-inline my-1">
                    <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Data início">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                            </div>
                            <input name="dataInicial" type="date" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" class="form-control" id="inlineFormInputGroupUsername2">
                        </div>
                    </span>

                        <span class="mr-2">até</span>

                        <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Data fim">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                            </div>
                            <input name="dataFinal" type="date" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" class="form-control" id="inlineFormInputGroupUsername2" required>
                        </div>
                    </span>

                        <button class="btn btn-outline-warning mb-2 mr-2"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-4">
                <div onclick="window.location.href='<?php echo URLADM . 'alocacao/gerente/2'; ?>'" style="cursor: pointer;" class="card cardBorder text-center border-secondary">
                    <div class="row no-gutters">
                        <div class="col-md-8">
                            <div class="card-header"><strong>Nome do Gerente</strong></div>
                            <div class="card-body">
                                <p class="card-text">Percentual da Alocação</p>
                                <p class="card-text"><small class="text-muted">Clique no link abaixo</small></p>
                                <button class="btn btn-outline-secondary">
                                    <i class="fas fa-external-link-square-alt"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4 bg-secondary text-light cardGerente">
                            85%
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div onclick="window.location.href='<?php echo URLADM . 'alocacao/gerente/2'; ?>'" style="cursor: pointer;" class="card cardBorder text-center border-secondary">
                    <div class="row no-gutters">
                        <div class="col-md-8">
                            <div class="card-header"><strong>Nome do Gerente</strong></div>
                            <div class="card-body">
                                <p class="card-text">Percentual da Alocação</p>
                                <p class="card-text"><small class="text-muted">Clique no link abaixo</small></p>
                                <button class="btn btn-outline-secondary">
                                    <i class="fas fa-external-link-square-alt"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4 bg-secondary text-light cardGerente">
                            58%
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div onclick="window.location.href='<?php echo URLADM . 'alocacao/gerente/2'; ?>'" style="cursor: pointer;" class="card cardBorder text-center border-secondary">
                    <div class="row no-gutters">
                        <div class="col-md-8">
                            <div class="card-header"><strong>Nome do Gerente</strong></div>
                            <div class="card-body">
                                <p class="card-text">Percentual da Alocação</p>
                                <p class="card-text"><small class="text-muted">Clique no link abaixo</small></p>
                                <button class="btn btn-outline-secondary">
                                    <i class="fas fa-external-link-square-alt"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4 bg-secondary text-light cardGerente">
                            94%
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
