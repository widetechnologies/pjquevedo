<?php

include './include/session.include.php';
include './include/autoload.include.php';
include './include/access.include.php';
include_once './include/access-turma.include.php';

if (!isset($_SESSION['diaValido'])) {
    header("Location: ./seleciona-dia-historico");
    exit();
}
$diaValido = unserialize($_SESSION['diaValido']);


if (!isset($_GET['dia'])) {
    header("Location: ./");
    exit();
}
if (!in_array($_GET['dia'], $diaValido)) {
    header('Location: ./seleciona-dia-historico');
    exit();
}

$_SESSION['dia'] = $_GET['dia'];
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
}


ob_start();

include_once './include/turma-fechada.include.php';
$listaHorarios = $turma->getHorarios();
$horarios = $turma->getHorarios();

try {
    $aulas = array();
    $mes = new mes();
    $mes->setMes(date("m"), strtotime($_GET['dia']));
    $mes->selectByMes();
    foreach ($horarios as $h) {
        $aula = new aula();
        $aula->setId_turma($turma->getId_turma());
        $aula->setId_horario($h->getId_horario());
        $aula->setData($_GET['dia']);
        $aula->setId_mes($mes->getId());
        $a = $aula->selectByTurmaHorarioData();
        if ($a) {
            $aulas[] = $aula;
        } else {
            if (in_array($_GET['dia'], $diaValido)) {
                $aula->insert();
                $aulas[] = $aula;
            } else {
                header("Location: ./");
                exit();
            }
        }
    }
    $_SESSION['aulas'] = serialize($aulas);
} catch (Exception $ex) {
    $msg = $ex->getTraceAsString();
}


$aluno = new vw_aluno();
$listaAlunos = $aluno->selectAllbyId_turma($turma->getId_turma());

$alunosPresentes = array();
foreach ($aulas as $au) {
    foreach ($listaAlunos as $a) {
        $alunosAusentes[] = $a->getRa() . '|' . $au->getId_horario();
    }
    $aluno = new vw_aluno();
    $alunosPresentes[] = $aluno->selectAllPresentesByAula($au->getId());
}

if (isset($_POST['submit'])) {
    $listaRaPresente = array();
    $listaRaPresente = $_POST['presenca'];
    $_SESSION['presenca'] = serialize($_POST['presenca']);
    if ($fechamentoC->getSituacao() != 1) {
        try {

            foreach ($listaRaPresente as $l) {
                $key = array_search($l, $alunosAusentes);
                //if ($key != NULL) {
                unset($alunosAusentes[$key]);
                //}


                $l = explode("|", $l);
                $ra = $l[0];
                $id_horario = $l[1];
                foreach ($aulas as $a) {
                    if ($a->getId_horario() == $id_horario) {
                        $aula = $a;
                    }
                }

                $presenca = new presenca();
                $presenca->setId_aula($aula->getId());
                $presenca->setRa($ra);
                $presenca->setSituacao(1);
                if (!$presenca->selectByAulaRa()) {
                    $presenca->insert();
                }
            }
            foreach ($alunosAusentes as $l) {

                $l = explode("|", $l);
                $ra = $l[0];
                $id_horario = $l[1];
                foreach ($aulas as $a) {
                    if ($a->getId_horario() == $id_horario) {
                        $aula = $a;
                    }
                }

                $presenca = new presenca();
                $presenca->setId_aula($aula->getId());
                $presenca->setRa($ra);
                if ($presenca->selectByAulaRa()) {
                    $presenca->delete();
                }
            }
        } catch (Exception $ex) {
            $msg = $ex->getTraceAsString();
        }
    }
    header("Location: conteudo");
    exit();
}//isset submit
$title = 'Histórico | Chamada - FACENS';
include './layout/page/manual.page.php';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
?>