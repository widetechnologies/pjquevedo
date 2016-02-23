<?php
include_once './include/session.include.php';

include './include/autoload.include.php';
include_once './include/access.include.php';
ob_start();
//$usuario = new usuario();
//$usuario->setLogin('amachado');
//$_SESSION['operador'] = 'amachado';

//$turma = new vw_turma();
//$turma->setCod_prof($_SESSION['operador']);
//$turmas = $turma->selectAllByCod_prof();

//$_SESSION['operador'] = serialize($usuario);

if($operador->getTipo() != 1 && $operador->getTipo() != 0){
    header("Location: ./login");
    exit();
}

$prof = new vw_prof();
$listProfs = $prof->selectAll();


if(isset($_POST['submit'])){
    $turma = new vw_turma();
    $turma->setCod_prof($_POST['submit']);
    $listaTurmas = $turma->selectAllByCod_prof();
    
    $_SESSION['listaTurmas'] = serialize($listaTurmas);
    $_SESSION['mes'] = $_POST['options'];
    $_SESSION['prof-diario'] = $_POST['submit']; 
    header("Location: ./diario-branco");
    exit();
}// isset post submit
$title = 'Gerar Diário | Chamada - FACENS';
include './layout/page/gerar-diario.page.php';

$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
?>
