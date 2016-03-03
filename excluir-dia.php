<?php

include './include/session.include.php';
include './include/autoload.include.php';
include './include/access.include.php';
include_once './include/access-turma.include.php';

ob_start();

$turma = unserialize($_SESSION['turma']);
$base = parse_ini_file('./config/conf.ini', true);
$inicio = $base['perletivo']['inicio'];
$fim = $base['perletivo']['fim'];

$horarioAula = new vw_horario();
$diasDeAula1 = array();
$diasDeAula1 = $turma->getHorarios();
$feriadoLista = new feriado();
$feriados = $feriadoLista->selectAll();

foreach ($feriados as $item) {
    $feriadosValidos[] = date("Y-m-d", strtotime($item->getData()));
}//foreach

$diaValido = array();
$dataAtual = date("Y-m-d", strtotime($inicio));
$dataFinal = date("Y-m-d", strtotime($fim));
while ($dataAtual <= date("Y-m-d")) {
    foreach ($diasDeAula1 as $diaSemanaOk) {
        if ($dataAtual <= $dataFinal && date("N", strtotime($dataAtual)) == ($diaSemanaOk->getDia_semana() - 1) &&
                !in_array($dataAtual, $feriadosValidos)) {
            $diaValido[] = date("Y-m-d", strtotime($dataAtual));
        }
    }
    $dataAtual = date("Y-m-d", strtotime("+ 1 days", strtotime($dataAtual)));
}//while


if (!isset($_GET['dia'])) {
    header("Location: ./");
    exit();
}
if (!in_array($_GET['dia'], $diaValido)) {
    header('Location: ./seleciona-dia-historico');
    exit();
}


if (isset($_POST['submit'])) {
    try {
        $aula = new aula();
        $aula->setData($_GET['dia']);
        $aula->setId_turma($turma->getId_turma());
        $aulas = $aula->selectAllByTurmaAndData();

        foreach ($aulas as $item) {
            $presenca = new presenca();
            $presenca->deleteFromidAula($item->getId());
        }
        foreach ($aulas as $item) {
            if ($item->getId_conteudo() != '') {
                $conteudo = new conteudo();
                $conteudo->setId($item->getId_conteudo());
                $conteudo->delete();
            }
            $item->delete();
        }

        header("Location: ./seleciona-dia-historico");
        exit();
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }
}//if

$title = 'Apagar aula | Chamada - Wide Education';
include './layout/page/excluir-dia.page.php';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
