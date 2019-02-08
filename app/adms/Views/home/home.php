<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
//var_dump($this->Dados);
if ($this->Dados['usuarios']) {
    extract( $this->Dados['usuarios']);
}
if ($this->Dados['usuarios'][0]) {
    extract( $this->Dados['usuarios'][0]);
}

if ($this->Dados['demandas']) {
    extract($this->Dados['demandas']);
}
if ($this->Dados['demandas'][0]) {
    extract($this->Dados['demandas'][0]);
}

//echo $num_result ."<br>";
//echo $_SESSION['adms_empresa_id'];
?>
    <div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Dashboard</h2>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-3 col-sm-6 mb-3 ">
                <div class="card bg-white text-dark shadow">
                    <div class="card-body">
                        <i class="fas fa-users fa-3x text-info"></i>
                        <h6 class="card-title">Usuários</h6>
                        <h2 class="lead">
                            <?php
                                if ($num_result_user) {echo $num_result_user; }
                            ?>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-3">
                <div class="card bg-white text-dark shadow">
                    <div class="card-body">
                        <i class="fas fa-file fa-3x text-success"></i>
                        <h6 class="card-title">Demandas</h6>
                        <h2 class="lead">
                            <?php
                                if ($num_result_demanda){ echo $num_result_demanda; }
                            ?>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-3">
                <div class="card bg-white text-dark shadow">
                    <div class="card-body">
                        <i class="fas fa-eye fa-3x text-primary"></i>
                        <h6 class="card-title">Atendimento</h6>
                        <h2 class="lead">0</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-3">
                <div class="card bg-white text-dark shadow">
                    <div class="card-body">
                        <i class="fas fa-comments fa-3x text-warning"></i>
                        <h6 class="card-title">Comentários</h6>
                        <h2 class="lead">0</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
