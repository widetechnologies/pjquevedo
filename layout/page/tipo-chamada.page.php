<div class="container">
    <div class="row">
        <form method="POST" class="col-lg-7 col-md-7 text-center">
            <h1>Tipo de chamada</h1>

            <p>Selecione a ação que será executada para a turma <strong><?php echo $turma->getTurma(); ?></strong>!</p>
            <?php if ($fechamentoC->getSituacao() == 1): ?>
                <div class="alert alert-danger alert-dismissable fade in">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3><i class="glyphicon glyphicon-warning-sign"></i> Turma fechada para esse mês!</h3>
                    <p>Para fazer a chamada ou fazer alterações nessa turma, nesse mês, você deve abrir a turma <a href="./seleciona-diario-unico">na página de diários.</a></p>
                </div>
            <?php endif; ?>
            <?php if (!in_array(date("Y-m-d"), $feriadosValidos) && $dia == (date("N") + 1) && date("N") != 7 && $fechamentoC->getSituacao() != 1): ?>
                <button type="submit" value="sequencial" name="submit" class="btn btn-primary btn-block btn-lg"><i class="glyphicon glyphicon-pencil"></i> Chamada Sequencial</button><br />
                <button type="submit" value="aleatoria" name="submit" class="btn btn-success btn-block btn-lg"><i class="glyphicon glyphicon-refresh"></i> Chamada Aleatória</button><br />
                <button type="submit" value="manual" name="submit" class="btn btn-default btn-block btn-lg"><i class="glyphicon glyphicon-list-alt"></i> Chamada Manual</button><br />
            <?php endif; ?>
            <button type="submit" value="historico" name="submit" class="btn btn-info btn-block btn-lg"><i class="glyphicon glyphicon-calendar"></i> Histórico da Turma</button><br />
            <button type="submit" value="carometro" name="submit" class="btn btn-info btn-block btn-lg"><i class="glyphicon glyphicon-user"></i> Carômetro</button>


        </form>
        <div class="col-lg-5 col-md-5 text-center">
            <br /><br />
            <div class="alert alert-info">
                <h2 class="text-center"><i class="glyphicon glyphicon-info-sign"></i> Informações...</h2>
                <h3><i class="glyphicon glyphicon-pencil"></i> Chamada Sequencial</h3>
                <p>
                    Na chamada sequencial você faz a chamada <b>aluno por aluno</b>. Nessa chamada 
                    você pode ver a foto do aluno, seu nome completo e RA.<br /><br />
                    <b>A chamada é realizada em ordem alfabética.</b>
                </p>
                <h3><i class="glyphicon glyphicon-refresh"></i> Chamada Aleatória</h3>
                <p>
                    A chamada aleatória é similar a chamada sequencial, a diferença é que a lista 
                    de alunos vem em <b>ordem aleatória</b>, ou seja, <b>não respeita a ordem alfabética</b>.
                </p>
                <h3><i class="glyphicon glyphicon-list-alt"></i> Chamada Manual</h3>
                <p>
                    Na chamada manual, os alunos são dispostos em <b>forma de lista</b>, ordenados por <b>ordem alfabética</b>.
                    Você pode selecionar as aulas individuais. Nesse método, aparecem apenas o nome e o RA do aluno.
                </p>
                <h3><i class="glyphicon glyphicon-calendar"></i> Histórico da Turma</h3>
                <p>
                    No histórico você encontrará um calendário com os dias válidos de aula, com ele você pode 
                    fazer a chamada de dias atrasados ou alterar a chamada de dias já realizados. 
                </p>
                <h3><i class="glyphicon glyphicon-user"></i> Carômetro</h3>
                <p>
                    No carômetro você pode ver a foto, nome e RA de todos os alunos de uma turma.
                </p>
            </div>
        </div>
    </div>
</div>