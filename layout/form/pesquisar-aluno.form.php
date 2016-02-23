<div class="container">
    <div class="col-lg-2"></div>
    <div class="col-lg-8 table">
        <form method="POST">
            <div class="">
                <h2><i class="glyphicon glyphicon-search text-info"></i> Pesquisar Alunos</h2>
                <div class="col-lg-6">
                    <div class="form-group">
                    <label for="aluno">Digite o nome ou RA do aluno:</label>
                    <input type="text" required name="aluno" class="form-control" autofocus placeholder="Digite o nome ou o RA do aluno para pesquisa" />
                    </div>
                    <div class="form-group">
                    <button type="submit" class="btn btn-success" name="submit"><i class="glyphicon glyphicon-search"></i> Pesquisar Aluno</button>
                    </div>
                </div>
                <?php if(!isset($encontrado) && !isset($erro)): ?>
                <div class="col-lg-6 alert alert-info">
                    <h2><i class="glyphicon glyphicon-info-sign"></i> Informações...</h2>
                    <p>
                        Para pesquisar alunos é bastante simples:
                    </p>
                    <h3>Pesquisa por RA</h3>
                    <p>
                        Basta digitar o RA do aluno e clicar em <b class="text-success"> [<i class="glyphicon glyphicon-search"></i> Pesquisar Aluno]</b>, 
                        ao clicar no botão você será redirecionado para as informações dele!
                    </p>
                    <h3>Pesquisa Por Nome</h3>
                    <p>
                        Basta digitar o nome completo ou parte do nome do aluno 
                        e clicar em <b class="text-success"> [<i class="glyphicon glyphicon-search"></i> Pesquisar Aluno]</b>,
                        vamos retornar para você os resultados que mais se enquadradam na sua pesquisa.
                    </p>
                    <p>
                        Para selecionar o aluno, basta clicar no botão verde com um <b class="text-success">[<i class="glyphicon glyphicon-chevron-right"></i>] </b>
                        e você será redirecionado para as informações dele!
                    </p>
                </div>
                <?php endif; ?>
            </div>
            <br /><br />
        </form>
        <?php
        if (isset($encontrado) && $encontrado == TRUE && !isset($erro)):
            include './layout/grid/aluno.grid.php';
        elseif (isset($erro)):
            ?>
            <div class="clearfix"></div>
            <br />
            <div class="alert alert-warning alert-dismissable fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2><i class="glyphicon glyphicon-remove"></i> OPS!</h2>
                <?php if (!isset($null)): ?>
                    <p>Você pesquisou por: <b class="text-primary"><?php echo str_replace('%', ' ', $pesquisa); ?></b>. </p><br />
                <?php endif; ?>
                <p><?php echo $erro; ?></p>

            </div>
        <?php endif; ?>
    </div>
    <div class="col-lg-2"></div>
</div>