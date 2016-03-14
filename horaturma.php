<?php

include_once './include/session.include.php';
include './include/autoload.include.php';
include './include/access.include.php';

if ($operador->getTipo() != 1) {
    header("Location: ./");
    exit();
}

ob_start();
$model = new vw_horaturma();

if (isset($_POST['excluir'])) {
    $model->setId($_POST['excluir']);
    $model->delete();
}

if (isset($_GET['id'])) {
    try {
        if (isset($_POST['submit'])) {
            $id_turma = $_POST['id_turma'];
            $id_horario = $_POST['id_horario'];
            $sala = $_POST['sala'];
            $id = $_GET['id'];
            $model->setId($id);
            $model->setId_horario($id_horario);
            $model->setId_turma($id_turma);
            $model->setSala($sala);

            if ($id != '') {
                $model->update();
                header('location: horaturma');
            } else {
                $model->insert();
                header('location: horaturma');
            }
        } else {
            $model = new vw_horaturma($_GET['id']);
            $model->select();
        }
    } catch (Exception $exc) {
        $msg = $exc->getTraceAsString();
        die();
    }
} else if (isset($_POST['submit'])) {
    $id_turma = $_POST['id_turma'];
    $id_horario = $_POST['id_horario'];
    $sala = $_POST['sala'];
    $id = $_POST['id'];
    //var_dump($_POST['id_horario']);
    //die();
    foreach ($id_horario as $idh) {
        $model = new vw_horaturma();
        $model->setId($id);
        $model->setId_horario($idh);
        $model->setId_turma($id_turma);
        $model->setSala($sala);

        $model->insert();
    }
}
$models = $model->selectAll();
$hora = new vw_horario();
$horarios = $hora->selectAll();
$turma = new vw_turma();
$turmas = $turma->selectAll();

$title = 'Hora turma | Chamada - Wide Education';
include './layout/page/horaturma.page.php';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
?>
