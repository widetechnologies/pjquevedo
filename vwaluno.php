<?php

include_once './include/session.include.php';
include './include/autoload.include.php';
include './include/access.include.php';

if ($operador->getTipo() != 1) {
    header("Location: ./");
    exit();
}

ob_start();
$model = new vw_aluno();

if (isset($_POST['excluir'])) {
    $model->setRa($_POST['excluir']);
    $model->delete();
}

if (isset($_GET['id'])) {
    try {
        if (isset($_POST['submit'])) {
            $ra = $_POST['ra'];
            $nome = trim(strtoupper($_POST['nome']));
            $cpf = $_POST['cpf'];
            $turno = $_POST['turno'];
            $id = $_POST['id'];
            
            $model->setRa($ra);
            $model->setNome($nome);
            $model->setCpf($cpf);
            $model->setTurno($turno);

            if ($id != '') {
                $model->update();
                header('location: vwaluno');
            } else {
                $model->insert();
                header('location: vwaluno');
            }
        }else{
            $model = new vw_aluno($_GET['id']);
            $model->select();
            
        }
    } catch (Exception $exc) {
        $msg = $exc->getTraceAsString();
        die();
    }
}else if(isset($_POST['submit'])){
            $ra = $_POST['ra'];
            $nome = trim(strtoupper($_POST['nome']));
            $cpf = $_POST['cpf'];
            $turno = $_POST['turno'];
            
            $model->setRa($ra);
            $model->setNome($nome);
            $model->setCpf($cpf);
            $model->setTurno($turno);

            $model->insert();
}
$models = $model->selectAll();

$title = 'Aluno | Chamada - FACENS';
include './layout/page/vwaluno.page.php';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
?>
