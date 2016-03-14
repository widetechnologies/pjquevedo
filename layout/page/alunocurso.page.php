<script>
    $(function () {
        $('.table').dataTable({
            "language": {
                "url": "layout/js/datatable.portugues.lang"
            }
        });

    });


</script>
<div class="container">
    <h1><i class="glyphicon glyphicon-sort-by-attributes"></i> Aluno Curso</h1><hr>
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
                <input type="hidden" name="id" value="<?php echo $model->getId() ?>">
                <div class="form-group">
                    <label for="ra">Ra:</label><br />
                    <input value="<?php echo $model->getRa(); ?>" type="text" class="form-control" autofocus required name="ra" placeholder="Ra do aluno" />
                </div>
                <div class="form-group">
                    <label for="codcurso">Curso: </label><br />
                    <select name="codcurso" required class="form-control">
                        <option value="" <?php echo $model->getCodcurso() == '' ? 'selected' : '' ?>>Selecione um curso</option>
                        <?php foreach ($cursos as $curso): ?>

                            <option value="<?php echo $curso->getId(); ?>" <?php echo $model->getCodcurso() == $curso->getId() ? 'selected' : '' ?>><?php echo $curso->getNome(); ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <div class="form-group">
                    <label for="periodo">Período: </label><br />
                    <input value="<?php echo $model->getPeriodo() ?>" type="text" class="form-control" name="periodo" placeholder="Digite o periodo" />
                </div>

                <div class="form-group">
                    <label for="perletivo">Período Letivo: </label><br />
                    <input value="<?php echo $model->getPerletivo() ?>" type="text" class="form-control" name="perletivo" placeholder="Digite o periodo letivo" />
                </div>

                <div class="form-group">
                    <label for="codturno">Turno: </label><br />
                    <select name="codturno" required class="form-control">
                        <option value="" <?php echo $model->getCodturno() == '' ? 'selected' : '' ?>>Selecione um turno</option>
                        <option value="M" <?php echo $model->getCodturno() == 'M' ? 'selected' : '' ?>>Manhã</option>
                        <option value="T" <?php echo $model->getCodturno() == 'T' ? 'selected' : '' ?>>Tarde</option>
                        <option value="N" <?php echo $model->getCodturno() == 'N' ? 'selected' : '' ?>>Noite</option>                        
                    </select>
                </div>

                <button name="submit" type="submit" class="btn btn-success"><i class="glyphicon glyphicon-save"></i> Salvar</button>
                <a href="alunocurso" class="btn btn-default"><i class="glyphicon glyphicon-erase"></i> Limpar</a>
            </form>
        </div>
        <div class="col-lg-8">
            <div class="table-responsive container-fluid">
                <form method="POST">
                    <table class="table table-striped table-condensed">
                        <thead>
                            <tr>
                                <th class="text-center col-sm-1">Nº</th>
                                <th>Ra</th>
                                <th>Curso</th>
                                <th>Periodo</th>  
                                <th>Perletivo</th> 
                                <th>Turno</th> 
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
                                    <td><?php echo $item->getRa(); ?></td>
                                    <td><?php                                           
                                        $c = new vw_curso($item->getCodcurso());
                                        $c->select();
                                        echo $c->getNome();
                                        ?></td>
                                    <td class="text-center"><?php echo $item->getPeriodo(); ?></td>
                                    <td class="text-center"><?php echo $item->getPerletivo(); ?></td>
                                    <td class="text-center"><?php echo $item->getCodturno();?></td>
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