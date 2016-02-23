<div class="container">
    <h1><i class="glyphicon glyphicon-book text-info"></i> Dar baixas em diários</h1>
    <h3><i class="glyphicon glyphicon-calendar text-info"></i> Selecione o mês</h3>

    <div class="row">
        <form method="POST">
            <p class="alert alert-danger"><i class="glyphicon glyphicon-warning-sign"></i> O MÊS PRÉ-SELECIONADO POR PADRÃO É O MÊS PASSADO!!!</p>
            <div class="btn-group" data-toggle="buttons">
                <?php foreach ($mesValido as $mes): ?>
                    <label class="btn btn-primary <?php echo (date('m') - 1) == $mes ? 'active' : ''; ?>">
                        <input type="radio" name="options" id="option" autocomplete="off" value="<?php echo $mes; ?>" <?php echo (date('m') - 1) == $mes ? ' checked' : ''; ?>> 
                        <?php
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
                        ?>
                    </label>
                <?php endforeach; ?>
            </div><br /><br />
            <div class="col-md-6">
                <div class="form-group" >
                    <label for="cod_turma"><i class="glyphicon glyphicon-barcode text-info"></i> Código da Turma: </label><br />
                    <input type="text" class="form-control" name="cod_turma" required autofocus placeholder="Digite o código da turma. Ex.: CA3TEI1" />
                </div>

                <div class="form-group">
                    <button name="submit" class="btn btn-success btn-lg"><i class="glyphicon glyphicon-save"></i> Salvar diário como entregue</button>
                </div>
            </div>

        </form>

    </div>
    <?php if (isset($erro)): ?>

        <div class="alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h3><i class="glyphicon glyphicon-warning-sign"></i> Ops!!!</h3>
            <p> <?php echo $erro; ?> </p>
        </div>
    <?php endif; ?>
    <?php if (isset($sucesso)): ?>

        <div class="alert alert-success fade in">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h3><i class="glyphicon glyphicon-warning-sign"></i> Sucesso!!!</h3>
            <p> <?php echo $sucesso; ?> </p>
        </div>
    <?php endif; ?>
    
</div>
