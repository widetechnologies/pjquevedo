<script>
    $(function () {
        $('.table').DataTable({
            language: {url: 'layout/js/datatable.portugues.lang'}
        });
    });
</script>
<h2>Controle do professor (<?php echo $_GET['cod_prof']; ?>)</h2>
<div class="row">
    <div class="col-md-10">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Turma</th>
                    <?php foreach ($mesValido as $mes): ?>
                        <th  class="text-center"><?php
                            switch ($mes) {
                                case 1:
                                    echo 'Jan';
                                    break;
                                case 2:
                                    echo 'Fev';
                                    break;
                                case 3:
                                    echo 'Mar';
                                    break;
                                case 4:
                                    echo 'Abr';
                                    break;
                                case 5:
                                    echo 'Mai';
                                    break;
                                case 6:
                                    echo 'Jun';
                                    break;
                                case 7:
                                    echo 'Jul';
                                    break;
                                case 8:
                                    echo 'Ago';
                                    break;
                                case 9:
                                    echo 'Set';
                                    break;
                                case 10:
                                    echo 'Out';
                                    break;
                                case 11:
                                    echo 'Nov';
                                    break;
                                case 12:
                                    echo 'Dez';
                                    break;
                            }
                            ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaTurmas as $turmaI): ?>
                    <tr>
                        <td><?php echo $turmaI->getTurma(); ?></td>
                        <?php foreach ($mesValido as $mes): ?>
                            <td class="text-center">
                                <?php
                                $achou = $mostrou = false;
                                foreach ($listaEntregues as $entregue):
                                    if ($entregue->getMes() == $mes && $entregue->getId_turma() == $turmaI->getId_turma())
                                        $achou = true;
                                    if ($achou && !$mostrou) {
                                        echo '<i class="glyphicon glyphicon-ok text-success"></i>';
                                        $mostrou = true;
                                    }
                                endforeach;
                                if (!$achou)
                                    echo '<i class="glyphicon glyphicon-remove text-danger"></i>';
                                ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>