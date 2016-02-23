<?php include_once './include/util.php'; ?>
<script>

    $(function () {
        $("#mpass").click(function () {
            $(window).off('beforeunload');
        });
        $(window).on('beforeunload', function () {
            return 'Todos os alunos poderão ficar com falta...';
        });
    });

    $(document).ready(function () {
        $('.selTodos').change(function () {

            if ($(this).is(':checked')) {

                $('.lblTodos').html('Desmarcar todos');

                $('.check').each(function (index, element) {
                    $(element).prop('checked', 'checked');
                });
            } else {
                $('.check').each(function (index, element) {
                    $('.lblTodos').html('Selecionar todos');
                    $(element).removeAttr('checked');
                });
            }

        });

        $('.t').change(function () {
            var v = '.' + $(this).val();
            if ($(this).is(':checked')) {

                //$('.lblTodos').html('Desmarcar todos');

                $(v).each(function (index, element) {
                    $(element).prop('checked', 'checked');
                });
            } else {
                $(v).each(function (index, element) {
                    //$('.lblTodos').html('Selecionar todos');
                    $(element).removeAttr('checked');
                    $('.selTodos').removeAttr('checked');
                });
            }

        });

        $('.check').change(function () {
            var v = '.' + $(this).val();
            if (!$(this).is(':checked')) {
                $('.selTodos').removeAttr('checked');
            }
            //evento marca as duas aulas

            var id = $(this).attr('id').split('-');


            switch (id[1]) {
                case "0":
                    var element = '#' + id[0] + '-1';
                    if (!$(this).is(':checked')) {
                        $(element).removeAttr('checked');
                    } else {
                        $(element).prop('checked', 'checked');
                    }

                case "1":
                    var element = '#' + id[0] + '-2';
                    if (!$(this).is(':checked')) {
                        $(element).removeAttr('checked');
                    } else {
                        $(element).prop('checked', 'checked');
                    }
                case "2":
                    var element = '#' + id[0] + '-3';
                    if (!$(this).is(':checked')) {
                        $(element).removeAttr('checked');
                    } else {
                        $(element).prop('checked', 'checked');
                    }
                    break;
            }

        });

    });
</script>
<div class="container-fluid">

    <div class="col-lg-2 col-sm-offset-0"></div>
    <form method="POST" class="col-lg-8">
        <h1><i class="glyphicon glyphicon-list-alt text-info"></i> Chamada Manual <?php echo isset($_GET['dia']) ? 'do dia ' . date("d/m/Y", strtotime($_GET['dia'])) : ''; ?></h1>
        <p>
            Aqui está a lista de todos os alunos da turma <b><?php echo $turma->getTurma(); ?></b>, 
            selecione os presentes e clique em <b>Próximo</b> para escrever o conteúdo ministrado em aula. 
        </p><br />
        <?php if ($fechamentoC->getSituacao() == 1): ?>
            <div class="alert alert-danger alert-dismissable fade in">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3><i class="glyphicon glyphicon-warning-sign"></i> Turma fechada para esse mês!</h3>
                <p>Para fazer a chamada ou fazer alterações nessa turma, nesse mês, você deve abrir a turma <a href="./seleciona-diario-unico">na página de diários.</a></p>
            </div>
        <?php endif; ?>
        <input class="checkbox-inline selTodos" <?php echo $fechamentoC->getSituacao() == 1 ? 'disabled' : ''; ?> name="check-todos" style="height: 18px; width: 18px;" type="checkbox" /> &nbsp;
        <label for="check-todos" class="lblTodos">Selecionar todos</label><hr />
        <?php for ($i = 0; $i < count($listaHorarios); $i++): ?>
            <input  type="checkbox" <?php echo $fechamentoC->getSituacao() == 1 ? 'disabled' : ''; ?> class="checkbox-inline check t" style="height: 18px; width: 18px;" value="<?php echo $i; ?>"/>&nbsp;
        <?php endfor; ?>
        <hr />
        <?php
        foreach ($listaAlunos as $alunos):
            ?>
            <div class="form-group <?php echo $alunos->getRa(); ?>">
                <div>
                    <label for="presenca[]">
                        <?php
                        $cont = 0;
                        foreach ($listaHorarios as $hItem):
                            ?>
                            <input class="checkbox-inline check <?php echo $cont . ' ' . $alunos->getRa(); ?>" 
                            <?php
                            if (in_array($alunos, $alunosPresentes[$cont])) {
                                echo ' checked ';
                            }
                            ?> style="height: 18px; width: 18px;" <?php echo $fechamentoC->getSituacao() == 1 ? 'disabled' : ''; ?> type="checkbox" name="presenca[]" id="<?php echo $alunos->getRa() . '-' . $cont; ?>" value="<?php echo $alunos->getRa() . '|' . $hItem->getId_horario(); ?>" /> &nbsp;

                            <?php
                            $cont++;
                        endforeach;
                        ?> 
                        <b> <?php echo $alunos->getRa() . '</b> - ' . abrevia($alunos->getNome(), 23); ?>
                    </label>
                    <hr />
                </div>
            </div>
        <?php endforeach; ?>

        <br />
        <button name="submit" id="mpass" type="submit" class="btn btn-lg btn-success"><i class="glyphicon glyphicon-chevron-right"></i> Próximo</button>
    </form>
    <div class="col-lg-2 col-sm-offset-0"></div>
</div>