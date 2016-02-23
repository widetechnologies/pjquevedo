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
$feriadosValidos = array();
while ($dataAtual <= date("Y-m-d")) {
    foreach ($diasDeAula1 as $diaSemanaOk) {
        if ($dataAtual <= $dataFinal && date("N", strtotime($dataAtual)) == ($diaSemanaOk->getDia_semana() - 1) &&
                !in_array($dataAtual, $feriadosValidos)) {
            $diaValido[] = date("Y-m-d", strtotime($dataAtual));
        }
    }
    $dataAtual = date("Y-m-d", strtotime("+ 1 days", strtotime($dataAtual)));
}//while

$_SESSION['diaValido'] = serialize($diaValido);
$title = 'Selecionar Dia Para o Histórico  | Chamada - FACENS';
include './layout/page/seleciona-dia-historico.page.php';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
