<?php

include_once './include/session.include.php';
include './include/autoload.include.php';
include './include/access.include.php';

if ($operador->getTipo() != 1) {
    header("Location: ./");
    exit();
}

ob_start();
$model = new vw_aluno_curso();

if (isset($_POST['excluir'])) {
    $model->setId($_POST['excluir']);
    $model->delete();
}

if (isset($_GET['id'])) {
    try {
        if (isset($_POST['submit'])) {
            $ra = $_POST['ra'];
            $codcurso = $_POST['codcurso'];
            $periodo = $_POST['periodo'];
            $perletivo = $_POST['perletivo'];
            $codturno = $_POST['codturno'];
            $id = $_POST['id'];
            
            $model->setId($id);
            $model->setRa($ra);
            $model->setCodcurso($codcurso);
            $model->setPeriodo($periodo);
            $model->setPerletivo($perletivo);
            $model->setCodturno($codturno);

            if ($id != '') {
                $model->update();
                header('location: alunocurso');
            } else {
                $model->insert();
                header('location: alunocurso');
            }
        }else{
            $model = new vw_aluno_curso();
            $model->setId($_GET['id']);
            $model->select();
            
        }
    } catch (Exception $exc) {
        $msg = $exc->getTraceAsString();
        die();
    }
}else if(isset($_POST['submit'])){
           $ra = $_POST['ra'];
            $codcurso = $_POST['codcurso'];
            $periodo = $_POST['periodo'];
            $perletivo = $_POST['perletivo'];
            $codturno = $_POST['codturno'];
            $id = $_POST['id'];
            
            $model->setId($id);
            $model->setRa($ra);
            $model->setCodcurso($codcurso);
            $model->setPeriodo($periodo);
            $model->setPerletivo($perletivo);
            $model->setCodturno($codturno);
            
            $model->insert();
}
$models = $model->selectAll();
$curso = new vw_curso();
$cursos = $curso->selectAll();

$title = 'Aluno Curso | Chamada - FACENS';
include './layout/page/alunocurso.page.php';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
?>
