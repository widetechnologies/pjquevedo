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
    <h1><i class="glyphicon glyphicon-tags"></i> Hora turma</h1><hr>
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
                <div class="form-group">
                    <label for="id_horario">Horário: </label><br />    
                    <?php if ($model->getId() == ''): ?>
                        <?php foreach ($horarios as $h): ?>

                            <label><input type="checkbox" name="id_horario[]" value="<?php echo $h->getId_horario(); ?>" /> <?php
                                echo $h->getHora_ini() . '-' . $h->getHora_fim() . ' ';
                                switch ($h->getDia_semana()) {
                                    case 0: $diasemana = "Domingo";
                                        break;
                                    case 1: $diasemana = "Segunda-Feira";
                                        break;
                                    case 2: $diasemana = "Terça-Feira";
                                        break;
                                    case 3: $diasemana = "Quarta-Feira";
                                        break;
                                    case 4: $diasemana = "Quinta-Feira";
                                        break;
                                    case 5: $diasemana = "Sexta-Feira";
                                        break;
                                    case 6: $diasemana = "Sábado";
                                        break;
                                }
                                $turno = array('M' => 'Manhã', 'T' => 'Tarde', 'N' => 'Noite');
                                echo $diasemana . ' - ' . $turno[$h->getTurno()];
                                ?>
                            <?php endforeach; ?>

                        </label>
                    <?php else: ?>
                        <select name="id_horario" required class="form-control">
                            <option value="" <?php echo $model->getId_horario() == '' ? 'selected' : '' ?>>Selecione um horário</option>
                            <?php foreach ($horarios as $h): ?>

                                <option value="<?php echo $h->getId_horario(); ?>" <?php echo $model->getId_horario() == $h->getId_horario() ? 'selected' : '' ?>><?php
                                    echo $h->getHora_ini() . '-' . $h->getHora_fim() . ' ';
                                    switch ($h->getDia_semana()) {
                                        case 0: $diasemana = "Domingo";
                                            break;
                                        case 1: $diasemana = "Segunda-Feira";
                                            break;
                                        case 2: $diasemana = "Terça-Feira";
                                            break;
                                        case 3: $diasemana = "Quarta-Feira";
                                            break;
                                        case 4: $diasemana = "Quinta-Feira";
                                            break;
                                        case 5: $diasemana = "Sexta-Feira";
                                            break;
                                        case 6: $diasemana = "Sábado";
                                            break;
                                    }
                                    $turno = array('M' => 'Manhã', 'T' => 'Tarde', 'N' => 'Noite');
                                    echo $diasemana . ' - ' . $turno[$h->getTurno()];
                                    ?></option>
                            <?php endforeach; ?>

                        </select>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="sala">Sala: </label><br />
                    <input value="<?php echo $model->getSala() ?>" type="text" class="form-control" name="sala" placeholder="Nome da sala" />
                </div>

                <button name="submit" type="submit" class="btn btn-success"><i class="glyphicon glyphicon-save"></i> Salvar</button>
                <a href="horaturma" class="btn btn-default"><i class="glyphicon glyphicon-erase"></i> Limpar</a>
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
                                <th>Horario</th>
                                <th>Turno</th>
                                <th>Dia semana</th>
                                <th>Sala</th>                                
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
                                        $t = new vw_turma($item->getId_turma());
                                        $t->select();
                                        echo $t->getTurma();
                                        ?>
                                    </td>
                                    <td><?php
                                        $h = new vw_horario($item->getId_horario());
                                        $h->select();
                                        echo $h->getHora_ini() . '-' . $h->getHora_fim();
                                        ?>
                                    </td>
                                    <td><?php echo $turno[$h->getTurno()]; ?></td>
                                    <td class="text-center"><?php
                                        switch ($h->getDia_semana()) {
                                            case 0: $diasemana = "Domingo";
                                                break;
                                            case 1: $diasemana = "Segunda-Feira";
                                                break;
                                            case 2: $diasemana = "Terça-Feira";
                                                break;
                                            case 3: $diasemana = "Quarta-Feira";
                                                break;
                                            case 4: $diasemana = "Quinta-Feira";
                                                break;
                                            case 5: $diasemana = "Sexta-Feira";
                                                break;
                                            case 6: $diasemana = "Sábado";
                                                break;
                                        }
                                        echo $diasemana;
                                        ?>
                                    </td>
                                    <td><?php echo $item->getSala(); ?></td>
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