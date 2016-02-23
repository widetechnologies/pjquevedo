<script>
    $(function () {
        $('.table').dataTable({
            "language": {
                "url": "layout/js/datatable.portugues.lang"
            },
            "order": [[1, "asc"], [2, "asc"]]
        });
    })
</script>
<ol class="breadcrumb">
    <li><a href="./">Home</a></li>
    <li>Gerenciando usuários</li>
</ol>
<div class="container-fluid">
    <ul class="list-group col-sm-2">
        <li class="list-group-item active">Opções</li>
        <li class="list-group-item">
            <a href="?new"> Novo usuario</a>
        </li>
        <li class="list-group-item">
            <a href="?#">Gerenciar</a>
        </li>
    </ul>
    <div class="col-sm-10">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center" style="width: 10px;">Tipo</th>
                    <th>Login</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th class="text-center"><span class="glyphicon glyphicon-edit"></span></th>
                </tr>
            </thead>
            <tbody>
                <?php $usuario = new usuario;
                foreach ($lUsuarios as $usuario): ?>
                    <tr>
                        <td class="text-center"><?php echo $usuario->getTipo() ?></td>
                        <td><?php echo $usuario->getLogin() ?></td>
                        <td><?php echo $usuario->getNome() ?></td>
                        <td><?php echo $usuario->getEmail() ?></td>
                        <td class="text-center" title="Editar usuário"><a href="usuario?id=<?php echo $usuario->getId() ?>" <span class="glyphicon glyphicon-edit"></span></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>