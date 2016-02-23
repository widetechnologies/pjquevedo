<div class="container">
    <h1><i class="glyphicon glyphicon-user text-info"></i> Carômetro da Turma <?php echo $turma->getTurma(); ?></h1>
    <div class="alert alert-info fade in">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <p><i class="glyphicon glyphicon-info-sign"></i> Clique no aluno para ver mais detalhes sobre ele! </p>
    </div>
    <?php
    foreach ($listaAlunos as $alunoI):
        $a = new vw_aluno();
        $a->setRa($alunoI->getRa());
        $a->select();
        ?>
        <div class="">
            <div class="col-sm-4 text-center">
                <a href="aluno?ra=<?php echo $alunoI->getRa(); ?>&i=1">
                <?php if (@fopen("http://172.16.0.120/controle/fotos/{$alunoI->getRa()}.jpg", "r")): ?>
                    <img src="http://172.16.0.120/controle/fotos/<?php echo $alunoI->getRa(); ?>.jpg" class="img-thumbnail img-responsive" style="max-height: 243px !important;">
                <?php else: ?>
                    <img src="./layout/img/to-sem-foto.jpg" class="img-thumbnail img-responsive">
                <?php endif; ?>
                </a>
                    <div class="caption">
                        <h5 class="text-center">
                            <a href="aluno?ra=<?php echo $alunoI->getRa(); ?>&i=1">
                            <?php echo abrevia($a->getNome(), 28); ?><br>
                            RA: <?php echo $alunoI->getRa(); ?>
                            </a>
                        </h5>
                    </div>
            </div>
            </div>
        <?php endforeach; ?>
    
    <div class="col-lg-12">
        <a href="./tipo-chamada" class="btn btn-lg btn-warning"><i class="glyphicon glyphicon-chevron-left"></i> Voltar</a>
    </div>
</div>