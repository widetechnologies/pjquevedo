<!DOCTYPE html>
<!--teste-->
<html lang="en"><head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="layout/img/favicon.ico">
        <title>Login - Chamada | FACENS</title>
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" type="text/css" href="layout/bootstrap/css/bootstrap.css">
        <!-- Custom styles for this template -->
        <link href="layout/bootstrap/css/signin.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4 col-md-offset-4">
                    <h1 class="text-center login-title">Autenticação Chamada - Facens</h1>
                    <div class="account-wall">
                        <img class="profile-img" src="layout/img/logo_login.png" alt="">
                        <form class="form-signin "method="post" >
                            <input type="text" class="form-control" placeholder="Usuário" name="usuario" required="" autofocus="" autocomplete="off">
                            <input type="password" class="form-control" placeholder="Senha" name="senha" required="">
                            <button class="btn btn-lg btn-primary btn-block" type="submit">
                                Log in</button><br>
<!--                                <a href="senha?esqueci">Esqueci minha senha</a>-->
                            <span class="pull-right need-help"></span><span class="clearfix"></span>
                        </form>
                    </div>
                    <?php if(isset($msg)):?>
                    <span class="text-center new-account-error"><?php echo $msg?></span>
                    <?php else:?>
                    <span class="text-center new-account">Entre com seu usuário e senha.</span
                    <?php endif;?>
                </div>
            </div>
        </div>
    </body>
</html>