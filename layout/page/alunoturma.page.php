<script>
    $(function () {
        $('.table').dataTable({
            "language": {
                "url": "layout/js/datatable.portugues.lang"
            }
        });

        $('#selectCursos').change(function () {
            var val = $(this).val();
            $.ajax({
                url: 'alunoturma.php',
                dataType: 'html',
                method: 'post',
                data: {select: val}
            }).done(function (data) {
                $('#ret').html(data);
            });
        });
        
       
    });


</script>
<div class="container">
    <h1><i class="glyphicon glyphicon-tags"></i> Aluno turma</h1><hr>
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
                    <label for="id_turma">Turma: </label><br />
                    <select name="id_turma" required class="form-control">
                        <option value="" <?php echo $model->getId_turma() == '' ? 'selected' : '' ?>>Selecione um curso</option>
                        <?php foreach ($turmas as $turma): ?>

                            <option value="<?php echo $turma->getId_turma(); ?>" <?php echo $model->getId_turma() == $turma->getId_turma() ? 'selected' : '' ?>><?php echo $turma->getTurma(); ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>                
                <?php if ($model->getId() == ''): ?>
                    <div class="form-group">
                        <label for="curso">Curso: </label><br />
                        <select class="form-control" id="selectCursos" name="curso" >
                            <option>Selecione um curso</option>
                            <?php foreach ($cursos as $curso): ?>
                                <option value="<?php echo $curso->getId(); ?>"><?php echo $curso->getNome(); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div> 
                    <div id="ret"></div>
                <?php else: ?>
                    <div class="form-group">
                        <label for="ra">Ra: </label><br />
                        <input value="<?php echo $model->getRa(); ?>" type="text" class="form-control" required name="ra" placeholder="Digite o ra do aluno" />
                    </div> 
                <?php endif; ?>

                <div class="form-group">
                    <label for="perletivo">Período letivo: </label><br />
                    <input value="<?php echo $model->getPerletivo(); ?>" type="text" class="form-control" required name="perletivo" placeholder="Digite o período letivo" />
                </div> 

                <button name="submit" type="submit" class="btn btn-success"><i class="glyphicon glyphicon-save"></i> Salvar</button>
                <a href="alunoturma" class="btn btn-default"><i class="glyphicon glyphicon-erase"></i> Limpar</a>
            </form>
        </div>
        <div class="col-lg-8">
            <div class="table-responsive container-fluid">
                <form method="POST">
                    <table class="table table-striped table-condensed">
                        <thead>
                            <tr>
                                <th class="text-center col-sm-1">Nº</th>
                                <th>Turma</th>
                                <th>Ra</th>
                                <th>Período letivo</th>
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
                                    <td><?php
                                        $turma = new vw_turma($item->getId_turma());
                                        $turma->select();
                                        echo $turma->getTurma();
                                        ?></td>
                                    <td><?php echo $item->getRa(); ?></td>
                                    <td><?php echo $item->getPerletivo(); ?></td>
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