<script>
    $(function () {
        $("#mpass").click(function () {
            $(window).off('beforeunload');
        });
        $(window).on('beforeunload', function () {
            return 'Você ainda não salvou o conteúdo...';
        });
    });
</script>

<div class="container text-center">
    <div class="row">
        <div class="col-lg-2"></div>
        <form method="POST" class="col-lg-8">
            <h2><i class="glyphicon glyphicon-edit text-info"></i> <?php echo isset($_SESSION['dia']) ? 'Digite o conteúdo da aula do dia ' . date("d/m/Y", strtotime($_SESSION['dia'])) : 'Digite o conteúdo dessa aula'; ?>  </h2>
            <?php if ($fechamentoC->getSituacao() == 1): ?>
                <div class="alert alert-danger alert-dismissable fade in">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3><i class="glyphicon glyphicon-warning-sign"></i> Turma fechada para esse mês!</h3>
                    <p>Para fazer a chamada ou fazer alterações nessa turma, nesse mês, você deve abrir a turma <a href="./seleciona-diario-unico">na página de diários.</a></p>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="conteudo">Digite o conteúdo que foi ministrado nessa aula e clique em salvar.</label><br />
                <textarea <?php echo $fechamentoC->getSituacao() == 1 ? 'disabled' : ''; ?>  rows="8" placeholder="Digite o conteúdo ministrado nessa aula!" name="conteudo"class="form-control" required autofocus><?php
                    if (isset($conteudo)) {
                        echo $conteudo->getConteudo();
                    }
                    ?></textarea>
            </div>
            <?php if ($fechamentoC->getSituacao() == 1): ?>
                <a href="./" class="btn btn-lg btn-success"><i class="glyphicon glyphicon-chevron-left"></i> Voltar Para as Turmas</a>
            <?php else: ?>
                <button type="submit" name="submit" id="mpass" class="btn btn-success btn-lg"><i class="glyphicon glyphicon-save"></i> Salvar Chamada</button>
            <?php endif; ?>
        </form>
        <div class="col-lg-2"></div>
    </div>
</div>
