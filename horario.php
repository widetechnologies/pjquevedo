<?php

include_once './include/session.include.php';
include './include/autoload.include.php';
include './include/access.include.php';

if ($operador->getTipo() != 1) {
    header("Location: ./");
    exit();
}

ob_start();
$model = new vw_horario();

if (isset($_POST['excluir'])) {
    $model->setId_horario($_POST['excluir']);
    $model->delete();
}

if (isset($_GET['id'])) {
    try {
        if (isset($_POST['submit'])) {
            $id_horario = $_POST['id'];
            $hora_ini = $_POST['hora_ini'];
            $hora_fim = $_POST['hora_fim'];
            $dia_semana = $_POST['dia_semana'];
            $turno = $_POST['turno'];
            
            $model->setId_horario($id_horario);
            $model->setHora_ini($hora_ini);
            $model->setHora_fim($hora_fim);
            $model->setDia_semana($dia_semana);
            $model->setTurno($turno);

            if ($id_horario != '') {
                $model->update();
                header('location: horario');
            } else {
                $model->insert();
                header('location: horario');
            }
        }else{
            $model = new vw_horario($_GET['id']);
            $model->select();
            
        }
    } catch (Exception $exc) {
        $msg = $exc->getTraceAsString();
        die();
    }
}else if(isset($_POST['submit'])){
           $id_horario = $_POST['id'];
            $hora_ini = $_POST['hora_ini'];
            $hora_fim = $_POST['hora_fim'];
            $dia_semana = $_POST['dia_semana'];
            $turno = $_POST['turno'];
            
            $model->setId_horario($id_horario);
            $model->setHora_ini($hora_ini);
            $model->setHora_fim($hora_fim);
            $model->setDia_semana($dia_semana);
            $model->setTurno($turno);
            
            $model->insert();
}
$models = $model->selectAll();

$title = 'Horário | Chamada - FACENS';
include './layout/page/horario.page.php';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
?>
