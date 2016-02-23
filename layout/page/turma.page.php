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
    <h1><i class="glyphicon glyphicon-book"></i> Turmas</h1><hr>
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
                <input type="hidden" name="id" value="<?php echo $model->getId_turma() ?>">
                <div class="form-group">
                    <label for="perletivo">Período letivo:</label><br />
                    <input value="<?php echo $model->getPerletivo(); ?>" type="text" class="form-control" autofocus required name="perletivo" placeholder="Período Letivo" />
                </div>
                <div class="form-group">
                    <label for="disciplina">Disciplina: </label><br />
                    <select name="disciplina" required class="form-control">
                        <option value="" <?php echo $model->getDisciplina() == '' ? 'selected' : '' ?>>Selecione uma disciplina</option>
                        <?php foreach ($discs as $disc):?>
                        
                            <option value="<?php echo $disc->getCoddisc(); ?>" <?php echo $model->getDisciplina() == $disc->getCoddisc() ? 'selected' : '' ?>><?php echo $disc->getNome(); ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>
                <div class="form-group">
                    <label for="turma">Turma: </label><br />
                    <input value="<?php echo $model->getTurma() ?>" type="text" class="form-control" name="turma" placeholder="Digite a turma" />
                </div>
                <div class="form-group">
                    <label for="cod_prof">Professor: </label><br />
                    <select name="cod_prof" required class="form-control">
                        <option value="" <?php echo $model->getCod_prof() == '' ? 'selected' : '' ?>>Selecione um professor</option>
                        <?php foreach ($profs as $prof):?>
                        
                            <option value="<?php echo $prof->getCodprof(); ?>" <?php echo $model->getCod_prof() == $prof->getCodprof() ? 'selected' : '' ?>><?php echo $prof->getNome(); ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <button name="submit" type="submit" class="btn btn-success"><i class="glyphicon glyphicon-save"></i> Salvar</button>
                <a href="turma" class="btn btn-default"><i class="glyphicon glyphicon-erase"></i> Limpar</a>
            </form>
        </div>
        <div class="col-lg-8">
            <div class="table-responsive container-fluid">
                <form method="POST">
                    <table class="table table-striped table-condensed">
                        <thead>
                            <tr>
                                <th class="text-center col-sm-1">Nº</th>
                                <th>Perletivo</th>
                                <th>Disciplina</th>
                                <th>Turma</th>
                                <th>Professor</th>
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
                                    <td><?php echo $item->getPerletivo(); ?></td>
                                    <td><?php echo $item->getDisciplina(); ?></td>
                                    <td class="text-center"><?php echo $item->getTurma(); ?></td>
                                    <td class="text-center"><?php
                                        $p = new vw_prof();
                                        $p->setCodprof($item->getCod_prof());
                                        $p->selectByCodprof();
                                        echo $p->getNome();
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn-link" href="?id=<?php echo $item->getId_turma(); ?>"><i class="glyphicon glyphicon-pencil"></i></a>
                                        <button class="btn-link" name="excluir" type="submit" value="<?php echo $item->getId_turma(); ?>"><i class="glyphicon glyphicon-trash"></i></button>
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