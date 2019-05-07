<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 15:12
 */
if (!defined('URL')) {
    header("Location: /");
    exit();
}


if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}

if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}

//var_dump($this->Dados);
//var_dump($valorForm);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Novo Atendimento</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_atendimento']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'atendimento/listar'; ?>" class="btn btn-outline-info btn-sm"><i class="fas fa-list"></i> Listar Atendimentos</a>
                </div>
                <?php
            }
            ?>
        </div><hr>

        <?php
        if(isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }

        ?>

        <form method="post" action="" class="col-md-6">

            <div class="form-row">

                <?php
                    if (isset($this->Dados['empresas'])) {
                        ?>
                        <!-- Apenas o gerente pode visualizar essa parte de selecionar empresa -->
                        <div class="form-group col-md-6">
                            <label for="adms_empresa_id"><span class="text-danger">* </span>Selecionar Empresa</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-empresaid">
                                        <i class="fas fa-building"></i>
                                    </span>
                                </div>

                            <select name="adms_empresa_id" id="adms_empresa_id" class="form-control" aria-describedby="basic-empresaid">
                                <option value="">Selecione</option>
                                <?php
                                foreach ($this->Dados['empresas'] as $empresa) {
                                    extract($empresa);
                                    if ($valorFom['adms_empresa_id'] == $id_empresa) {
                                        echo "<option value='$id_empresa' selected>$nome_empresa</option>";
                                    } else {
                                        echo "<option value='$id_empresa'>$nome_empresa</option>";
                                    }

                                }
                                ?>
                            </select>
                            </div>
                        </div>
                        <?php
                    }
                ?>


                <div class="form-group col-md-6">
                    <label for="adms_demanda_id"><span class="text-danger">* </span>Tipo de Atendimento</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-demanda_id">
                                <i class="fas fa-clipboard-list"></i>
                            </span>
                        </div>
                        <select name="adms_demanda_id" id="adms_demanda_id" class="form-control" aria-describedby="basic-demanda_id">
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->Dados['demandas'] as $demanda) {
                                extract($demanda);
                                if ($valorFom['adms_demanda_id'] == $id)
                                {
                                    echo "<option value='$id' selected>$nome</option>";
                                } else {
                                    echo "<option value='$id'>$nome</option>";
                                }

                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-10">
                    <label><span class="text-danger"></span>Descrição</label>
                    <textarea name="descricao" class="form-control" rows="3"><?php if(isset($valorForm['descricao'])) {echo $valorForm['descricao'];}?></textarea>

                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input type="submit" name="CadAtendimento" value="Solicitar" class="btn btn-outline-success">
        </form>
    </div>
</div>
