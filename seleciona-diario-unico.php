<?php

include './include/session.include.php';
include './include/autoload.include.php';
include './include/access.include.php';
set_time_limit(0);
if ($operador->getTipo() != 1 && $operador->getTipo() != 2) {
    header("Location: ./login");
    exit();
}

ob_start();


$base = parse_ini_file('./config/conf.ini', true);
$perletivo = $base['perletivo'];
$mesIni = date("m", strtotime($perletivo['inicio']));
$mesFinal = date("m", strtotime($perletivo['fim']));
$mesValido = Array();

for ($i = $mesIni; $i <= date("m"); $i++)
    if ($i <= $mesFinal)
        $mesValido[] = $i;

$turma = new vw_turma;
$turma->setCod_prof($operador->getLogin());
$listaTurmas = $turma->selectAllByCod_prof();

if (isset($_POST['mes'])) {
    $mes = intval($_POST['mes']);
    include 'layout/grid/seleciona-diario-unico.grid.php';
    exit();
}

if (isset($_POST['submit'])) {
    $turmaR = $_POST['submit'];

    $turma = new vw_turma();
    $turma->setCod_prof($operador->getLogin());
    $turma->setId_turma($turmaR);

    if ($turmaR == 'todos')
        $listaTurmas = $turma->selectAllByCod_prof();
    else
        $listaTurmas = $turma->selectAllByCod_profUnico();

    $_SESSION['listaTurmas'] = serialize($listaTurmas);
    $_SESSION['mes'] = $_POST['options'];
    $_SESSION['prof-diario'] = $operador->getLogin();
    header("Location: ./diario-completo");
    exit();
}//submit

if (isset($_POST['exporta'])) {
    $post = $_POST['exporta'];
    $_SESSION['mes'] = $_POST['options'];
    $mes = intval($_POST['options']);
    $fechadas = unserialize($_SESSION['fechadas']);
    $abertas = unserialize($_SESSION['abertas']);

    if ($post == "abrir") {
        abrir($fechadas);
    } else if (is_numeric($post)) {
        $turma = new vw_turma($post);
        $turma->select();
        $turma = serialize($turma);
        if (in_array($turma, $abertas)) {
            fechar(array($turma));
            $_SESSION['turma'] = serialize(array($turma));
            include 'exporta.php';
        } else {
            abrir(array($turma));
        }
    } else if ($post == "todos") {
        fechar($abertas);
        $_SESSION['turma'] = serialize($abertas);
        include 'exporta.php';
    }


    include 'layout/grid/seleciona-diario-unico.grid.php';
    exit();
}


$title = 'Selecionar Turma Para Diário | Chamada - FACENS';
include './layout/page/seleciona-diario-unico.page.php';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';

function fechar($turmas) {
    try {
        foreach ($turmas as $t) {

            $t = unserialize($t);
            $fechamento = new fechamento();
            $fechamento->setId_turma($t->getId_turma());
            $fechamento->setMes($_SESSION['mes']);
            if ($fechamento->selectById_turmaMes()) {
                $fechamento->setSituacao(1);
                if (!$fechamento->update()) {
                    throw new Exception("Erro ao fechar turma: {$t->getTurma()}");
                }
            }
        }
    } catch (Exception $ex) {
        echo $ex->getTraceAsString();
    }
}

function abrir($turmas) {
    try {
        foreach ($turmas as $t) {

            $t = unserialize($t);
            $fechamento = new fechamento();
            $fechamento->setId_turma($t->getId_turma());
            $fechamento->setMes($_SESSION['mes']);
            if ($fechamento->selectById_turmaMes()) {
                $fechamento->setSituacao(0);
                if (!$fechamento->update()) {
                    throw new Exception("Erro ao fechar turma: {$t->getTurma()}");
                }
            }
        }
    } catch (Exception $ex) {
        echo $ex->getTraceAsString();
    }
}
