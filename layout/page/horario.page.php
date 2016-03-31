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
    <h1><i class="glyphicon glyphicon-time"></i> Horários</h1><hr>
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
                <input type="hidden" name="id" value="<?php echo $model->getId_horario() ?>">
                <div class="form-group">
                    <label for="hora_ini">Horário início:</label><br />
                    <input value="<?php echo $model->getHora_ini(); ?>" type="time" class="form-control" autofocus required name="hora_ini" placeholder="Hora inicial" />
                </div>
                <div class="form-group">
                    <label for="hora_fim">Horário fim: </label><br />
                    <input value="<?php echo $model->getHora_fim(); ?>" type="time" class="form-control" required name="hora_fim" placeholder="Hora final" />
                </div>
                <div class="form-group">
                    <label for="dia_semana">Dia da semana: </label><br />
                    <select name="dia_semana" required class="form-control">
                        <option value="" <?php echo $model->getDia_semana() == '' ? 'selected' : '' ?>>Selecione um dia</option>
                        <option value="2" <?php echo $model->getDia_semana() == 2 ? 'selected' : '' ?>>Segunda-feira</option>
                        <option value="3" <?php echo $model->getDia_semana() == 3 ? 'selected' : '' ?>>Terça-feira</option>
                        <option value="4" <?php echo $model->getDia_semana() == 4 ? 'selected' : '' ?>>Quarta-feira</option>
                        <option value="5" <?php echo $model->getDia_semana() == 5 ? 'selected' : '' ?>>Quinta-feira</option>
                        <option value="6" <?php echo $model->getDia_semana() == 6 ? 'selected' : '' ?>>Sexta-feira</option>
                        <option value="7" <?php echo $model->getDia_semana() == 7 ? 'selected' : '' ?>>Sábado</option>
                        <option value="0" <?php echo $model->getDia_semana() == 8 ? 'selected' : '' ?>>Domingo</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="turno">Turno: </label><br />
                    <select name="turno" required class="form-control">
                        <option value="" <?php echo $model->getTurno() == '' ? 'selected' : '' ?>>Selecione um turno</option>
                        <option value="M" <?php echo $model->getTurno() == 'M' ? 'selected' : '' ?>>Manhã</option>
                        <option value="T" <?php echo $model->getTurno() == 'T' ? 'selected' : '' ?>>Tarde</option>
                        <option value="N" <?php echo $model->getTurno() == 'N' ? 'selected' : '' ?>>Noite</option>                   
                    </select>
                </div>

                <button name="submit" type="submit" class="btn btn-success"><i class="glyphicon glyphicon-save"></i> Salvar</button>
                <a href="horario" class="btn btn-default"><i class="glyphicon glyphicon-erase"></i> Limpar</a>
            </form>
        </div>
        <div class="col-lg-8">
            <div class="table-responsive container-fluid">
                <form method="POST">
                    <table class="table table-striped table-condensed">
                        <thead>
                            <tr>
                                <th class="text-center col-sm-1">Nº</th>
                                <th>Horário início</th>
                                <th>Horário fim</th>
                                <th>Dia da Semana</th>
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
                                    <td><?php echo $item->getHora_ini(); ?></td>
                                    <td><?php echo $item->getHora_fim(); ?></td>
                                    <td class="text-center"><?php
                                        switch ($item->getDia_semana()) {
                                            case 0: $diasemana = "Domingo";
                                                break;
                                            case 2: $diasemana = "Segunda-Feira";
                                                break;
                                            case 3: $diasemana = "Terça-Feira";
                                                break;
                                            case 4: $diasemana = "Quarta-Feira";
                                                break;
                                            case 5: $diasemana = "Quinta-Feira";
                                                break;
                                            case 6: $diasemana = "Sexta-Feira";
                                                break;
                                            case 7: $diasemana = "Sábado";
                                                break;
                                        }
                                        echo $diasemana;
                                        ?></td>
                                    <td class="text-center"><?php
                                        $turno = array('M' => 'Manhã', 'T' => 'Tarde', 'N' => 'Noite');
                                        echo $turno[$item->getTurno()];
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn-link" href="?id=<?php echo $item->getId_horario(); ?>"><i class="glyphicon glyphicon-pencil"></i></a>
                                        <button class="btn-link" name="excluir" type="submit" value="<?php echo $item->getId_horario(); ?>"><i class="glyphicon glyphicon-trash"></i></button>
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