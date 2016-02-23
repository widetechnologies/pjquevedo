<div class="container text-center">
    <div class="alert alert-success">
        <h1>Pronto!</h1>
        <h1><i class="glyphicon glyphicon-ok-circle"></i></h1>
        <h2><?php echo isset($_SESSION['dia']) ? 'A chamada do dia ' . date("d/m/Y", strtotime($_SESSION['dia'])) . ' foi realizada com sucesso!' : 'A chamada de hoje foi realizada com sucesso!'; ?></h2>
        <h3>Turma: <?php echo $turma->getTurma(); ?></h3>
        <p>Chamada realizada dia <b>
                <?php
                echo date("d/m/Y");
                echo '</b> às <b>' . date("H:i:s");
                ?></b>.</p><br />
        <?php
        $i = 1;
        foreach ($countPresentes as $p):
            ?>
            <p><b><?php echo $i . 'ª aula'; ?></b> - <b>Presentes: <?php echo $p; ?></b> | <b class = "text-danger">Ausentes: <?php echo abs($total - $p); ?></b><br/>
                <?php
                $i++;
            endforeach;
            ?>
            <b class="text-primary">Total de alunos matriculados na turma: <?php echo $total; ?></b></p>
    </div>
    <form method="POST">
        <button class="btn btn-lg btn-info" name="voltar" type="submit"><i class="glyphicon glyphicon-chevron-left"></i> Voltar</button><br /><br />
        <button class="btn btn-xs btn-danger" name="logout" type="submit"><i class="glyphicon glyphicon-off"></i> Fazer Logoff</button>

    </form>
</div>

<?php
if (isset($_SESSION['dia']))
    unset($_SESSION['dia']);
?>