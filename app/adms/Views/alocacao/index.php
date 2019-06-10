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
//var_dump($this->Dados['dadosForm']);
if (!empty($this->Dados['dadosForm'])){
    extract($this->Dados['dadosForm']);
}
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
                <h2 class="display-4 titulo">Alocação em Gerentes</h2>

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
                            <input name="dataInicial" type="date" value="<?php echo isset($dataInicial) ? $dataInicial : ""; ?>" class="form-control" id="inlineFormInputGroupUsername2">
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
                            <input name="dataFinal" type="date" value="<?php echo isset($dataFinal) ? $dataFinal : ""; ?>" class="form-control" id="inlineFormInputGroupUsername2" required>
                        </div>
                    </span>

                        <button class="btn btn-outline-warning mb-2 mr-2"><i class="fas fa-search"></i></button>
                </form>
            </div>

            <div class="col-md-6">
                <span class="badge bg-light my-3">
                Filtro Aplicado:
                <?php
                echo isset($dataFinal) ? date("d/m/Y", strtotime($dataInicial)) : "";
                echo " - ";
                echo isset($dataFinal) ? date("d/m/Y", strtotime($dataFinal)) : "";
                ?>
                </span>
            </div>
        </div>

        <?php
            if(empty($this->Dados['gerentes'])){
                echo "Nenhum gerente encontrado. Cadastre gerentes e funcionários.";
            } else {
        ?>
        <div class="row mt-3">
            <?php
                //var_dump($this->Dados['gerentes']);
                foreach ($this->Dados['gerentes'] as $key => $value){
                    if (empty($value['percentual_alocacao']) and $value['percentual_alocacao'] <= 0){
                        $value['percentual_alocacao'] = 0;
                    }
            ?>
            <div class="col-md-4 mb-3">
                <div onclick="window.location.href='<?php echo URLADM . 'alocacao/gerente/' . $key .'?data_inicio='.$dataInicial.'&data_fim='.$dataFinal; ?>'" style="cursor: pointer;" class="card cardBorder text-center border-secondary">
                    <div class="row no-gutters">
                        <div class="col-md-8">
                            <div class="card-header"><strong><?php echo $value['nome'] ?></strong></div>
                            <div class="card-body">
                                <p class="card-text">Percentual de Alocação</p>
                                <p class="card-text d-none d-md-block"><small class="text-muted">Clique no link abaixo</small></p>
                                <button class="btn btn-outline-secondary  d-none d-md-inline-block">
                                    <i class="fas fa-external-link-square-alt"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4 bg-secondary text-light cardGerente">
                            <?php echo number_format($value['percentual_alocacao'], 0, ',', ' ') . "%" ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php

                }
            ?>
        </div>
        <?php
            }
        ?>

    </div>
</div>
