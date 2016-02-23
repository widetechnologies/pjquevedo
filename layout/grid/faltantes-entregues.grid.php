<script>
    $(function () {
        $('.table').DataTable({
            language: {url: 'layout/js/datatable.portugues.lang'}
        });
    });
</script>
<h3><i class="glyphicon glyphicon-calendar text-info"></i> Mês selecionado:<b class="text-info"> <?php
        switch ($_POST['mes']) {
            case 1:
                echo 'Janeiro';
                break;
            case 2:
                echo 'Fevereiro';
                break;
            case 3:
                echo 'Março';
                break;
            case 4:
                echo 'Abril';
                break;
            case 5:
                echo 'Maio';
                break;
            case 6:
                echo 'Junho';
                break;
            case 7:
                echo 'Julho';
                break;
            case 8:
                echo 'Agosto';
                break;
            case 9:
                echo 'Setembro';
                break;
            case 10:
                echo 'Outubro';
                break;
            case 11:
                echo 'Novembro';
                break;
            case 12:
                echo 'Dezembro';
                break;
        }
        ?></b>.</h3>
<table class="table table-striped table-condensed">
    <thead>
        <tr>
            <th></th>
            <th>Nome</th>
            <th class="text-center">Entregues <i class="glyphicon glyphicon-ok text-success"> </i></th>
            <th class="text-center">Faltantes  <i class="glyphicon glyphicon-remove text-danger"> </i></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $conti = 0;
        foreach ($preAu as $itemPA):
            $conti++;
            ?> 
            <tr>
                <td><?php echo $conti; ?></td>
                <td><a href="./relatorio-entregas?cod_prof=<?php echo $itemPA->getCodprof(); ?> "><?php echo $itemPA->getNome(); ?></a></td>
                <td class="text-success text-center"><b><?php echo $itemPA->getEntregues(); ?></b></td>
                <td  class="text-danger text-center"><b><?php echo $itemPA->getFaltantes(); ?></b></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
