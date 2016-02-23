<!--<script>
    $(function () {
        $('.tableAlunos').DataTable({
            language: {url: 'layout/js/datatable.portugues.lang'}
        });
    });
</script>-->
<div class="container-fluid">
<div class="clearfix"></div>
<h3>Resultados da sua pesquisa! <i class="glyphicon glyphicon-ok-circle text-success"></i></h3>
<p>Você pesquisou por: <b><i><?php echo str_replace('%', ' ', $pesquisa); ?></i></b>. </p>
<hr />
<div class="table-responsive">
    <form method="POST">
        <table class="table-striped table-condensed table tableAlunos">
            <thead>
                <tr>
                    <th>Selecionar</th>
                    <th>RA</th>
                    <th>Nome</th>
                    <th>Curso</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $cont = 0;
                foreach ($listaEnc as $aluno):
                    $cont++;
                    ?>
                    <tr>
                        <td><button class="glyphicon glyphicon-chevron-right btn btn-success btn-sm" value="<?php echo $aluno->ra; ?>" type="submit" name="escolher"></button></td>
                        <td><?php echo $aluno->ra; ?></td>
                        <td><?php echo $aluno->nome; ?></td>
                        <td><?php echo $aluno->getCurso(); ?></td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </form>
</div>
</div>