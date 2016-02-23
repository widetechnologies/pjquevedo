<ol class="breadcrumb">
    <li><a href="./">Home</a></li>
    <li>Gerenciando usuários</li>
</ol>
<div class="container-fluid">
    <ul class="list-group col-sm-2">
        <li class="list-group-item active">Opções</li>
        <li class="list-group-item "><a href="?new">Novo usuário</a></li>
        <li class="list-group-item "><a href="usuario">Gerenciar</a></li>
    </ul>
    <div class="col-sm-10">
        <fieldset>
            <legend>Formulário de usuário</legend>
            <form method="post">
                <div class="col-sm-4">
                    <input type="hidden" name="Usuario[id]" value="<?php echo $usuario->getId()?>">
                    <div class="form-group">
                        <label>Tipo</label>
                        <select required name="Usuario[tipo]" class="form-control">
                            <option value="1" <?php echo $usuario->getTipo() == 1 ? 'selected' : '' ?>>Administrador</option>
                            <option value="2" <?php echo $usuario->getTipo() == 2 ? 'selected' : '' ?>>Comum</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Login</label>
                        <input required class="form-control" name="Usuario[login]" value="<?php echo $usuario->getLogin() ?>">
                    </div>
                    <div class="form-group">
                        <label>Nome</label>
                        <input class="form-control" name="Usuario[nome]" value="<?php echo $usuario->getNome() ?>">
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" required class="form-control" name="Usuario[email]" value="<?php echo $usuario->getEmail() ?>">
                    </div>
                    
                    <?php if ($usuario->getId() != ''): ?>
                        <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i> Salvar</button>
                    <?php else: ?>
                        <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i> Adicionar</button>
                    <?php endif; ?>
                        
                </div>
                <div class="col-sm-8 well">
                    <div class="form-group">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Sistema</th>
                                    <th class="text-center">Admin.</th>
                                    <th class="text-center">Gerente</th>
                                    <th class="text-center">Comum</th>
                                    <th class="text-center">Nenhum</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $item = new sistema();
                                foreach ($lSistemas as $item):
                                    ?>
                                    <tr>
                                        <td><?php echo $item->getNome() ?></td>
                                        <td class="text-center"><input type="radio" name="Sistema[<?php echo $item->getId() ?>]" value="1" <?php echo $item->getAcesso() == 1 ? 'checked' : '' ?>></td>
                                        <td class="text-center"><input type="radio" name="Sistema[<?php echo $item->getId() ?>]" value="2" <?php echo $item->getAcesso() == 2 ? 'checked' : '' ?>></td>
                                        <td class="text-center"><input type="radio" name="Sistema[<?php echo $item->getId() ?>]" value="3" <?php echo $item->getAcesso() == 3 ? 'checked' : '' ?>></td>
                                        <td class="text-center"><input type="radio" name="Sistema[<?php echo $item->getId() ?>]" value="0" <?php echo ($item->getAcesso() == 0 || $item->getAcesso() == '') ? 'checked' : '' ?>></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
            <?php if(isset($msg_ok)): ?>
            <div class="container-fluid">
                <div class="alert alert-success text-center"><?php echo $msg_ok?></div>
            </div>
            <?php elseif(isset($msg_error)):?>
            <div class="container-fluid">
                <div class="alert alert-danger text-center"><?php echo $msg_error?></div>
            </div>
            <?php endif?>
        </fieldset>
    </div>
</div>