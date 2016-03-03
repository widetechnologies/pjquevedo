<?php

include 'include/autoload.include.php';
include_once 'include/session.include.php';

ob_start();

if (isset($_GET['out'])) {
    session_destroy();
    header('Location: ./');
}

if (isset($_POST['usuario'])) {

    $usuario = new usuario();
    $usuario2 = ltrim($_POST['usuario']);
    $usuario2 = rtrim($usuario2);
    $usuario2 = strtolower($usuario2);
    $usuario->setLogin($usuario2);
    $usuario->setSenha($_POST['senha']);

    if ($usuario->getLogin() != '' && $usuario->getSenha() != '') {
        try {
            if (is_numeric($usuario->getLogin())) {
                $msg = "Ops! Você não tem acesso a esse sistema...";
            } else {
                if ($usuario->selectByLoginSenha()) {
                    $usuario->setSenha('');
                    $_SESSION['operador'] = serialize($usuario);
                    header('Location: ./');
                    exit();
                } else {
                    $msg = "Usuário ou senha inválidos.";
                }
            }
        } catch (Exception $ex) {
            $msg = "Erro: {$ex->getMessage()}";
        }
    } else {
        $msg = "Entre com seu usuário e senha.";
    }
}

$corpo = ob_get_clean();
include './layout/page/login.page.php';
?>
