<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}

?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Curriculos</h2>
            </div>
   
        </div>
        <?php
        if (empty($this->Dados['curriculo'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum curriculo encontrado!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
        }
        else{

            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
        ?>
        
        <div class="table-responsive">
           <table class="table table-striped table-hover table-bordered">      
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Sexo</th> 
                        <th>Cidade</th>
                        <th>Área de Interesse</th>
                        <th>Formação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    foreach($this->Dados['curriculo'] as $curr){
                        extract($curr);
                        ?>
                        <tr>
                            <td><?php echo $id ?></td>
                            <td><?php echo $nome ?></td>
                            <td><?php echo $email ?></td>
                            <td><?php echo $sexo ?></td>
                            <td><?php echo $cidade ?></td>
                            <td><?php echo $areadeinteresse ?></td>
                            <td><?php echo $formacao ?></td>
                            <td class="text-center">
                                <span class="d-nono d-md-block">
                                <?php
                                    if ($this->Dados['botao']['vis_curriculo']){
                                        echo "<a href='". URLADM . "ver-curriculo/vercurriculo/$id' class='btn btn-outline-primary btn-sm'>Visualizar</a>";
                                    }                        
                                ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" 
                                    aria haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php 
                                            if($this->Dados['botao']['vis-curriculo']){
                                                echo "<a class='dropdown-item' href='". URLADM . "ver-curriculo/ver-curriculo/$id'>Visualizar</a>"; 
                                            }
                                        ?>
                                    </div>

                                </div>

                            </td>
                        </tr>

                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <?php
                //echo $this->Dados['paginacao'];
            ?>    
        </div> 
        <?php 
        }
        ?>
    </div>
</div>
