<script>
    $(function(){
        $('.table').dataTable({
            "language": {
                "url": "layout/js/datatable.portugues.lang"
            }
        });
        
    });
    

</script>
<div class="container">
    <h1><i class="glyphicon glyphicon-user"></i> Usuários</h1><hr>
<!--    <div class="alert alert-dismissable alert-info fade in text-center" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h3><i class="glyphicon glyphicon-info-sign"></i> Informações...</h3>
        <p>
            Aqui você pode fazer o controle dos usuários especiais, definindo suas permissões, seu nome de login e o nome definido pelo RM.
        </p>
        <p>
            <strong>
                Permissão 0: secretaria; 
                Permissão 1: Administrador; 
                Permissão 2: Professor; 
                Permissão 3: Aluno.
            </strong>
        </p>
    </div>-->

    <div class="row">
        <div class="col-lg-4">
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $usuarioU->getId()?>">
                <div class="form-group">
                    <label for="login">Login:</label><br />
                    <input value="<?php echo $usuarioU->getLogin()?>" type="text" class="form-control" autofocus required name="login" placeholder="Nome de usuário para login" />
                </div>
                <div class="form-group">
                    <label for="nome">Senha: </label><br />
                    <input type="password" class="form-control" value="" <?php if($usuarioU->getId() == '') echo "required"; ?> name="senha" placeholder="Digite a senha" />
                </div>
                <div class="form-group">
                    <label for="nome">Nome: </label><br />
                    <input value="<?php echo $usuarioU->getNome()?>" type="text" class="form-control" required name="nome" placeholder="Digite o Nome do usuário" />
                </div>
                <div class="form-group">
                    <label for="tipo">Tipo: </label><br />
                    <select name="tipo" required class="form-control">
                        <option value="2" <?php echo $usuarioU->getTipo() == 2 ? 'selected' : ''?>>Professor (2)</option>
                        <option value="0" <?php echo $usuarioU->getTipo() == 0 ? 'selected' : ''?>>Secretaria (0)</option>
                        <option value="1" <?php echo $usuarioU->getTipo() == 1 ? 'selected' : ''?>>Administrador (1)</option>
                        <option value="3" <?php echo $usuarioU->getTipo() == 3 ? 'selected' : ''?>>Aluno (3)</option>
                    </select>
                </div>
                <button name="submit" type="submit" class="btn btn-success"><i class="glyphicon glyphicon-save"></i> Salvar</button>
                <a href="usuario" class="btn btn-default"><i class="glyphicon glyphicon-erase"></i> Limpar</a>
            </form>
        </div>
        <div class="col-lg-8">
            <div class="table-responsive container-fluid">
                <form method="POST">
                    <table class="table table-striped table-condensed">
                        <thead>
                            <tr>
                                <th class="text-center col-sm-1">Nº</th>
                                <th>Login</th>
                                <th>Nome</th>
                                <th class="text-center col-sm-1">Tipo</th>
                                <th class="text-center col-sm-1">Excluir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cont = 0;
                            foreach ($usuarios as $user):
                                $cont++;
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $cont; ?></td>
                                    <td><?php echo $user->getLogin(); ?></td>
                                    <td><?php echo $user->getNome(); ?></td>
                                    <td class="text-center"><?php echo $user->getDescricaoTipo(); ?></td>
                                    <td class="text-center">
                                        <a class="btn-link" href="?id=<?php echo $user->getId(); ?>"><i class="glyphicon glyphicon-pencil"></i></a>
                                        <button class="btn-link" name="excluir" type="submit" value="<?php echo $user->getId(); ?>"><i class="glyphicon glyphicon-trash"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>

</div>