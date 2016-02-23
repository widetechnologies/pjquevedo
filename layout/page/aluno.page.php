<div class="container text-center">
    <h2><?php echo $aluno->getNome(); ?></h2>
    <h3><?php echo $aluno->getRa() . ' - ' . $curso->getNome(); ?></h3>
    <h3><?php
        echo $aluno->getTurno();
        ;
        ?></h3>

    <?php if (@fopen("http://172.16.0.120/controle/fotos/{$aluno->getRa()}.jpg", "r")): ?>
        <img src="http://172.16.0.120/controle/fotos/<?php echo $aluno->getRa(); ?>.jpg" class="img-thumbnail img-responsive" style="max-height: 243px !important;">
    <?php else: ?>
        <img src="./layout/img/to-sem-foto.jpg" class="img-thumbnail img-responsive">
    <?php endif; ?>
    <br /><br />
    <?php
    //quando for usar essa funcionalidade, mudar o 100 do if para 0
    if (count($listaTurmasAluno) > 0):
        ?>
        <form method="POST">
            <h3>Turmas que você leciona para esse aluno:</h3>
            <?php
            foreach ($listaTurmasAluno as $item):
                $disc = new vw_disc($item->getDisciplina());
                $disc->select();
                $horaturma = new vw_horaturma($item->getId_turma());
                $horaturma->select();
                ?><div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <button class="btn btn-lg btn-primary disabled" value="<?php echo $item->getId_turma(); ?>">
                            <?php echo $item->getTurma() . ' - '; ?>
                            <?php echo $disc->getNome(); ?><br/>
                            <?php echo '(' . $horaturma->getSala() . ')'; ?>
                        </button><br /><br />
                    </div>
                    <div class="col-md-2"></div>
                </div>
            <?php endforeach; ?>
        </form>

    <?php endif; ?>
    <br /><br /><hr />
    <?php if (isset($_GET['i'])): ?>
        <a href="./carometro" class="btn btn-lg btn-warning"><i class="glyphicon glyphicon-chevron-left"></i> Voltar</a>
    <?php else: ?>
        <a href="./aluno" class="btn btn-lg btn-warning"><i class="glyphicon glyphicon-chevron-left"></i> Voltar</a>
    <?php endif; ?>
</div>