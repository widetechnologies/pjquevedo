<div>
    <h2><?php echo $aluno->getNome(); ?></h2>
    <h4>RA: <?php echo $aluno->getRa(); ?></h4>
    <?php if (@fopen("http://172.16.0.120/controle/fotos/{$aluno->getRa()}.jpg", "r")): ?>
        <img src="http://172.16.0.120/controle/fotos/<?php echo $aluno->getRa(); ?>.jpg" class="img-thumbnail img-responsive" style="max-height: 243px !important;">
    <?php else: ?>
        <img src="./layout/img/to-sem-foto.jpg" class="img-thumbnail img-responsive">
    <?php endif; ?> 
</div>