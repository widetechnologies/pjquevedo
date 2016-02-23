<div class="container-fluid">
    <table class="table table-striped table-condensed text-center">
        <thead>
            <tr>
                <th class="text-center">codprof</th>
                <th class="text-center">Nome</th>
                <th class="text-center">imprimir</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listProfs as $itemProf): ?>
                <tr>
                    <td><?php echo $itemProf->getCodprof(); ?></td>
                    <td><?php echo $itemProf->getNome(); ?></td>
                    <td><button class="btn btn-xs btn-success" value="<?php echo $itemProf->getCodprof(); ?>" name="submit"><i class="glyphicon glyphicon-print"></i></button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>