<?php

include_once './include/session.include.php';
include './include/autoload.include.php';
include './include/access.include.php';

if ($operador->getTipo() != 1) {
    header("Location: ./");
    exit();
}

ob_start();
$model = new vw_disc();

if (isset($_POST['excluir'])) {
    $model->setCoddisc($_POST['excluir']);
    $model->delete();
}

if (isset($_GET['id'])) {
    try {
        if (isset($_POST['submit'])) {
            $coddisc = trim(strtoupper($_POST['coddisc']));
            $nome = trim(strtoupper($_POST['nome']));
            $complemento = $_POST['complemento'];
            $id = $_POST['id'];
            
            $model->setCoddisc($coddisc);
            $model->setNome($nome);
            $model->setComplemento($complemento);

            if ($id != '') {
                $model->update();
                header('location: disciplina');
            } else {
                $model->insert();
                header('location: disciplina');
            }
        }else{
            $model = new vw_disc($_GET['id']);
            $model->select();
            
        }
    } catch (Exception $exc) {
        $msg = $exc->getTraceAsString();
        die();
    }
}else if(isset($_POST['submit'])){
            $coddisc = trim(strtoupper($_POST['coddisc']));
            $nome = trim(strtoupper($_POST['nome']));
            $complemento = trim(strtoupper($_POST['complemento']));

            $model->setNome($nome);
            $model->setCoddisc($coddisc);
            $model->setComplemento($complemento);
            
            $model->insert();
}
$models = $model->selectAll();

$title = 'Disciplina | Chamada - FACENS';
include './layout/page/disciplina.page.php';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
?>
