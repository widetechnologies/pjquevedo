<?php

include_once './include/session.include.php';
include './include/autoload.include.php';
include './include/access.include.php';

if ($operador->getTipo() != 1) {
    header("Location: ./");
    exit();
}

ob_start();
$model = new vw_curso();

if (isset($_POST['excluir'])) {
    $model->setId($_POST['excluir']);
    $model->delete();
}

if (isset($_GET['id'])) {
    try {
        if (isset($_POST['submit'])) {
            $nome = trim(strtoupper($_POST['nome']));
            $complemento = $_POST['complemento'];
            $id = $_POST['id'];
            
            $model->setId($id);
            $model->setNome($nome);
            $model->setComplemento($complemento);

            if ($id != '') {
                $model->update();
                header('location: curso');
            } else {
                $model->insert();
                header('location: curso');
            }
        }else{
            $model = new vw_curso($_GET['id']);
            $model->select();
            
        }
    } catch (Exception $exc) {
        $msg = $exc->getTraceAsString();
        die();
    }
}else if(isset($_POST['submit'])){
           $nome = trim(strtoupper($_POST['nome']));
            $complemento = $_POST['complemento'];
            $id = $_POST['id'];
            
            $model->setId($id);
            $model->setNome($nome);
            $model->setComplemento($complemento);
            
            $model->insert();
}
$models = $model->selectAll();

$title = 'Curso | Chamada - Wide Education';
include './layout/page/curso.page.php';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
?>
