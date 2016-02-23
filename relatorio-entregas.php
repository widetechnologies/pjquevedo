<?php

include_once './include/session.include.php';

include './include/autoload.include.php';
include_once './include/access.include.php';
ob_start();

if ($operador->getTipo() != 1 && $operador->getTipo() != 0) {
    header("Location: ./login");
    exit();
}

$base = parse_ini_file('./config/conf.ini', true);
$perletivo = $base['perletivo'];
$perlet = $perletivo['perlet'];
$ini = $perletivo['inicio'];
$fim = $perletivo['fim'];

//cria lista mes validos
for ($i = date("m", strtotime($ini)); $i < date("m", strtotime($fim)); $i++)
    if ($i <= date("m"))
        $mesValido[] = $i;
$prof = new vw_prof();
$listProfs = $prof->selectAll();


if (isset($_GET['cod_prof'])) {
    try {

        $listaEntregues = array();
        $listaTurmas = array();
        $controle = new controle_diario;
        $turma = new vw_turma();

        $turma->setCod_prof($_GET['cod_prof']);
        $listaTurmas = $turma->selectAllByCod_prof();
        $listaEntregues = $controle->selectAllByCodProf($_GET['cod_prof']);
    } catch (Exception $exc) {
        $msg = $exc->getTraceAsString();
    }//catch
}// isset post submit

if (isset($_POST['todos'])) {

    $control = new controle_turmas_e_f();
    $preAu = array();
    $preAu = $control->selectAllByMes($_POST['mes']);
}//if isset todos
$title = 'Relatório De Diários | Chamada - FACENS';
include './layout/page/relatorio-entrega-diarios.page.php';

$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
?>
