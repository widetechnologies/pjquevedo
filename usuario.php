<?php

include_once './include/session.include.php';
include './include/autoload.include.php';
include './include/access.include.php';

if ($operador->getTipo() != 1) {
    header("Location: ./");
    exit();
}

ob_start();

$usuarioU = new usuario();

if (isset($_POST['excluir'])) {
    $usuarioU = new usuario();
    $usuarioU->setId($_POST['excluir']);
    $usuarioU->delete();
}

if (isset($_GET['id'])) {
    try {
        if (isset($_POST['submit'])) {
            $login = trim(strtolower($_POST['login']));
            $nome = trim(strtoupper($_POST['nome']));
            $permissao = $_POST['tipo'];
            $id = $_POST['id'];
            $senha = $_POST['senha'];

            $usuarioU = new usuario();
            $usuarioU->setId($id);
            $usuarioU->setNome($nome);
            $usuarioU->setLogin($login);
            $usuarioU->setTipo($permissao);
            $usuarioU->setSenha($senha);

            if ($usuarioU->getId() != '') {
                $usuarioU->update();
                header('location: usuario');
            } else {
                $usuarioU->insert();
                header('location: usuario');
            }
        } else {
            $usuarioU = new usuario($_GET['id']);
            $usuarioU->select();
        }
    } catch (Exception $exc) {
        $msg = $exc->getTraceAsString();
        die();
    }
} else if (isset($_POST['submit'])) {
    $login = trim(strtolower($_POST['login']));
    $nome = trim(strtoupper($_POST['nome']));
    $permissao = $_POST['tipo'];
   
    //$id = $_POST['id'];

    $usuarioU = new usuario();
    $usuarioU->setSenha($_POST['senha']);
    //$usuarioU->setId($id);
    $usuarioU->setNome($nome);
    $usuarioU->setLogin($login);
    $usuarioU->setTipo($permissao);

    $usuarioU->insert();
    header("Location: usuario");
}

$usuarios = $usuarioU->selectAll();
$title = 'Usuários | Chamada - Wide Education';
include './layout/page/usuario.page.php';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
?>
