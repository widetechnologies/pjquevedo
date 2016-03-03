<?php

include_once './include/session.include.php';
include './include/autoload.include.php';
include './include/access.include.php';

if ($operador->getTipo() != 1) {
    header("Location: ./");
    exit();
}

ob_start();
$model = new vw_turma();

if (isset($_POST['excluir'])) {
    $model->setId_turma($_POST['excluir']);
    $model->delete();
}

if (isset($_GET['id'])) {
    try {
        if (isset($_POST['submit'])) {
            $perletivo = trim(strtoupper($_POST['perletivo']));
            $disciplina = $_POST['disciplina'];
            $turma = $_POST['turma'];
            $cod_prof = $_POST['cod_prof'];
            $id = $_POST['id'];
            
            $model->setCod_prof($cod_prof);
            $model->setPerletivo($perletivo);
            $model->setDisciplina($disciplina);
            $model->setTurma($turma);
            $model->setId_turma($id);

            if ($id != '') {
                $model->update();
                header('location: turma');
            } else {
                $model->insert();
                header('location: turma');
            }
        }else{
            $model = new vw_turma($_GET['id']);
            $model->select();
            
        }
    } catch (Exception $exc) {
        $msg = $exc->getTraceAsString();
        die();
    }
}else if(isset($_POST['submit'])){
             $perletivo = trim(strtoupper($_POST['perletivo']));
            $disciplina = $_POST['disciplina'];
            $turma = $_POST['turma'];
             $cod_prof = $_POST['cod_prof'];
            $id = $_POST['id'];
            
            $model->setCod_prof($cod_prof);
            $model->setPerletivo($perletivo);
            $model->setDisciplina($disciplina);
            $model->setTurma($turma);
            $model->setId_turma($id);
            
            $model->insert();
}
$models = $model->selectAll();
$profs = new vw_prof();
$profs = $profs->selectAll();
$disc = new vw_disc();
$discs = $disc->selectAll();

$title = 'Turma | Chamada - Wide Education';
include './layout/page/turma.page.php';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
?>
