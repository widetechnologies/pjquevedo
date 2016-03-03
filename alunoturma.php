<?php

include_once './include/session.include.php';
include './include/autoload.include.php';
include './include/access.include.php';

if ($operador->getTipo() != 1) {
    header("Location: ./");
    exit();
}

ob_start();
$model = new vw_alunoturma();

if (isset($_POST['excluir'])) {
    $model->setId($_POST['excluir']);
    $model->delete();
}

if (isset($_GET['id'])) {
    try {
        if (isset($_POST['submit'])) {
            $id_turma = $_POST['id_turma'];
            $ra = $_POST['ra'];
            $id = $_POST['id'];
            $perletivo = $_POST['perletivo'];
            
            $model->setId($id);
            $model->setId_turma($id_turma);
            $model->setRa($ra);
            $model->setPerletivo($perletivo);

            if ($id != '') {
                $model->update();
                header('location: alunoturma');
            } else {
                $model->insert();
                header('location: alunoturma');
            }
        }else{
            $model = new vw_alunoturma($_GET['id']);
            $model->select();
            
        }
    } catch (Exception $exc) {
        $msg = $exc->getTraceAsString();
        die();
    }
}else if(isset($_POST['submit'])){
            $id_turma = $_POST['id_turma'];
            $ra = $_POST['ra'];
            $id = $_POST['id'];
            $perletivo = $_POST['perletivo'];
            
            $model->setId($id);
            $model->setId_turma($id_turma);
            $model->setRa($ra);
            $model->setPerletivo($perletivo);
            
            $model->insert();
}
$turma = new vw_turma();
$turmas = $turma->selectAll();
$models = $model->selectAll();

$title = 'Aluno turma | Chamada - Wide Education';
include './layout/page/alunoturma.page.php';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
?>
