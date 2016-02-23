
<div class="container">
    <h1 class="text-center text-info"><i class="glyphicon glyphicon-book"></i> Turmas</h1>
    <!--<h2 class="text-center text-info"><i class="glyphicon glyphicon-book"></i></h2>-->
    <h4 class="text-center">
        Escolha uma das turmas abaixo para realizar a chamada.
    </h4>
    
    <div class="alert alert-dismissable alert-info fade in text-center" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4><i class="glyphicon glyphicon-info-sign"></i> Sobre os botões...</h4>
        <p>
            As turmas na cor <b class="text-success">verde</b> são turmas lecionadas no período da manhã / tarde e as turmas na cor
            <b class="text-primary">azul</b> são as turmas lecionadas no período noturno.
        </p>
    </div>
    <div class="row">
         <div class="col-lg-2"></div>
        <form  method="POST" class="col-lg-8">
            <div class="text-center">
                <?php
                for ($i = 2; $i <= 7; $i++):
                    if (isset($info[$i]) && count($info[$i]) > 0):
                        ?>
                        <h3><?php echo $dias[$i]; ?></h3><br/> 

                        <?php
                        foreach ($info[$i] as $v) :
                            ?>
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-lg <?php echo $v['turno'] == 'N' ? 'btn-primary' : $v['turno'] == 'M' ? 'btn-success' : 'btn-info'; ?> text-center btn-block" value="<?php echo $v['id_turma'] . '|' . $v['dia']; ?>">
                                    <?php echo $v['disc']; ?><br/>
                                    <?php echo $v['turma']; ?><br/>
                                    <?php echo $v['h_ini'] . ' - ' . $v['h_fim'] . ' (' . $v['sala'] . ')'; ?>
                                </button>
                            </div>
                            <?php
                        endforeach;
                    endif;
                endfor;
                ?>
            </div>
        </form>
        <div class="col-lg-2"></div>
    </div>
</div>

