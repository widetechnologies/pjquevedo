
<div class="container">
    <h1>Relatório de entrega de diários</h1>
    <form method="GET" class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="cod_prof">Código do Professor: </label>
                <select class="form-control" required name="cod_prof">
                    <option value="" selected disabled>Selecione um Professor...</option>
                    <?php foreach ($listProfs as $itemProf): ?>
                        <option value="<?php echo $itemProf->getCodprof(); ?>"><?php echo $itemProf->getNome(); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-lg"><i class="glyphicon glyphicon-book"></i> Ver Entregas...</button>
            </div>

        </div>
    </form>
    <hr />
    <h3> <i class="glyphicon glyphicon-list"></i> Ver lista completa</h3>
    <form method="post">
        <div class="alert alert-info alert-dismissable fade in">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h3><i class="glyphicon glyphicon-info-sign"></i> Informações...</h3>
            <p>Atenção, o mês pré-selecionado é o mês anterior a este!</p>
        </div>
        <div class="btn-group" data-toggle="buttons">
            <?php foreach ($mesValido as $mes): ?>
                <label class="btn btn-primary <?php echo (date('m') - 1) == $mes ? 'active' : ''; ?>">
                    <input type="radio" name="mes" id="option" autocomplete="off" value="<?php echo $mes; ?>" <?php echo (date('m') - 1) == $mes ? ' checked' : ''; ?>> 
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

        <div class="form-group">
            <button name="todos" type="submit" class="btn btn-success btn-lg"><i class="glyphicon glyphicon-list"></i> Ver Todos...</button>
        </div>
    </form>
    <hr />
    <?php if (isset($_GET['cod_prof']) && $_GET['cod_prof'] != '' && !isset($_POST['todos'])) include './layout/grid/controle-diarios.grid.php'; ?>
    <div id="todos">   
        <?php if (isset($_POST['todos'])) include './layout/grid/faltantes-entregues.grid.php'; ?>
    </div>
</div>