<?php

include_once './include/session.include.php';
include './include/autoload.include.php';
include './include/access.include.php';

if ($operador->getTipo() != 1) {
    header("Location: ./");
    exit();
}

ob_start();
$model = new vw_prof();

if (isset($_POST['excluir'])) {
    $model->setId($_POST['excluir']);
    $model->delete();
}

if (isset($_GET['id'])) {
    try {
        if (isset($_POST['submit'])) {
            $nome = trim(strtoupper($_POST['nome']));
            $email = $_POST['email'];
            $cod_prof = $_POST['cod_prof'];
            $id = $_POST['id'];

            $model->setCodprof($id);
            $model->setNome($nome);
            $model->setEmail($email);
            $model->setCodprof($cod_prof);
            $model->setId($id);

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
    $nome = trim(strtoupper($_POST['nome']));
    $email = $_POST['email'];
    $cod_prof = $_POST['cod_prof'];
    $id = $_POST['id'];

    $model->setCodprof($id);
    $model->setNome($nome);
    $model->setEmail($email);
    $model->setCodprof($cod_prof);
    $model->setId($id);

    $model->insert();
}
$models = $model->selectAll();

$title = 'Professor | Chamada - FACENS';
include './layout/page/professor.page.php';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
?>
