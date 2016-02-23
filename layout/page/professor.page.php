<script>
    $(function(){
        $('.table').dataTable({
            "language": {
                "url": "layout/js/datatable.portugues.lang"
            }
        });
        
    });
    

</script>
<div class="container">
    <h1><i class="glyphicon glyphicon-education"></i> Professores</h1><hr>
<!--    <div class="alert alert-dismissable alert-info fade in text-center" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h3><i class="glyphicon glyphicon-info-sign"></i> Informações...</h3>
        <p>
            Aqui você pode fazer o controle dos usuários especiais, definindo suas permissões, seu nome de login e o nome definido pelo RM.
        </p>
        <p>
            <strong>
                Permissão 0: secretaria; 
                Permissão 1: Administrador; 
                Permissão 2: Professor; 
                Permissão 3: Aluno.
            </strong>
        </p>
    </div>-->

    <div class="row">
        <div class="col-lg-4">
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $model->getId()?>">
                <div class="form-group">
                    <label for="nome">Nome:</label><br />
                    <input value="<?php echo $model->getNome();?>" type="text" class="form-control" autofocus required name="nome" placeholder="Nome do professor" />
                </div>
                <div class="form-group">
                    <label for="email">Email: </label><br />
                    <input value="<?php echo $model->getEmail();?>" type="email" class="form-control"  name="email" placeholder="Digite o email" />
                </div>
                <div class="form-group">
                    <label for="cod_prof">Código do professor: </label><br />
                    <input value="<?php echo $model->getCodprof()?>" type="text" class="form-control" name="cod_prof" placeholder="Digite o código do professor" />
                </div>
               
                <button name="submit" type="submit" class="btn btn-success"><i class="glyphicon glyphicon-save"></i> Salvar</button>
                <a href="professor" class="btn btn-default"><i class="glyphicon glyphicon-erase"></i> Limpar</a>
            </form>
        </div>
        <div class="col-lg-8">
            <div class="table-responsive container-fluid">
                <form method="POST">
                    <table class="table table-striped table-condensed">
                        <thead>
                            <tr>
                                <th class="text-center col-sm-1">Nº</th>
                                <th class="text-center">Nome</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Código prof</th>                                
                                <th class="text-center col-sm-1">Excluir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cont = 0;
                            foreach ($models as $item):
                                $cont++;
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $cont; ?></td>                                    
                                    <td class="text-center"><?php echo $item->getNome(); ?></td>
                                    <td class="text-center"><?php echo $item->getEmail(); ?></td>
                                    <td class="text-center"><?php echo $item->getCodprof(); ?></td>
                                    <td class="text-center">
                                        <a class="btn-link" href="?id=<?php echo $item->getId(); ?>"><i class="glyphicon glyphicon-pencil"></i></a>
                                        <button class="btn-link" name="excluir" type="submit" value="<?php echo $item->getId(); ?>"><i class="glyphicon glyphicon-trash"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>

</div>