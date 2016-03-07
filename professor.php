<?php

include_once './include/session.include.php';
include './include/autoload.include.php';
include './include/access.include.php';

if ($operador->getTipo() != 1) {
    header("Location: ./");
    exit();
}
$usuario = new usuario();
$users = $usuario->selectAll();
ob_start();
$model = new vw_prof();

if (isset($_POST['excluir'])) {
    $model->setId($_POST['excluir']);
    $model->delete();
    header("Location: ./professor");
}

if (isset($_GET['id'])) {
    try {
        if (isset($_POST['submit'])) {
            $exp = explode("|", $_POST['nome']);
            $nome = trim(strtoupper($exp[1]));
            $email = $_POST['email'];
            $cod_prof = $exp[0];
            $id = $_POST['id'];

            $model->setCodprof($id);
            $model->setNome($nome);
            $model->setEmail($email);
            $model->setCodprof($cod_prof);
            $model->setId($id);
            //  var_dump($model);
            //  die();
            if ($id != '') {
                $model->update();
                header('location: professor');
            } else {
                $model->insert();
                header('location: professor');
            }
        } else {
            $model = new vw_prof($_GET['id']);
            $model->select();
        }
    } catch (Exception $exc) {
        $msg = $exc->getTraceAsString();
        echo $msg;
        die();
    }
} else if (isset($_POST['submit'])) {
    $exp = explode("|", $_POST['nome']);
    $nome = trim(strtoupper($exp[1]));
    $email = $_POST['email'];
    $cod_prof = $exp[0];
    $id = $_POST['id'];

    $model->setCodprof($id);
    $model->setNome($nome);
    $model->setEmail($email);
    $model->setCodprof($cod_prof);
    $model->setId($id);

    $model->insert();
}
$models = $model->selectAll();

$title = 'Professor | Chamada - Wide Education';
include './layout/page/professor.page.php';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
?>
