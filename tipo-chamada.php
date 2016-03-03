<?php

include './include/session.include.php';
include './include/autoload.include.php';
include './include/access.include.php';
include_once './include/access-turma.include.php';

if (isset($_SESSION['mes'])) {
    unset($_SESSION['mes']);
}

ob_start();
$turma = unserialize($_SESSION['turma']);
include_once './include/turma-fechada.include.php';
$h = $turma->getHorarios();
$dia = $h[0]->getDia_semana();


///////


$base = parse_ini_file('./config/conf.ini', true);
$inicio = $base['perletivo']['inicio'];
$fim = $base['perletivo']['fim'];

$horarioAula = new vw_horario();
$diasDeAula1 = array();
$diasDeAula1 = $turma->getHorarios();
$feriadoLista = new feriado();
$feriados = $feriadoLista->selectAll();
$feriadosValidos = array();
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
}
///////////////

if (isset($_POST['submit'])) {
    $aluno = new vw_aluno();
    $alunos = $aluno->selectAllById_turma($turma->getId_turma());
    $_SESSION['alunos'] = serialize($alunos);
    $_SESSION['indice'] = 0;
    $_SESSION['presenca'] = array();
    $horarios = $turma->getHorarios();

//BANCO
    if ($_POST['submit'] != 'historico') {
        try {
            $aulas = array();
            $mes = new mes();
            $mes->setMes(date("m"));
            $mes->selectByMes();
            foreach ($horarios as $h) {
                $aula = new aula();
                $aula->setId_turma($turma->getId_turma());
                $aula->setId_horario($h->getId_horario());
                $aula->setData(date("Y-m-d"));
                $aula->setId_mes($mes->getId());
                $a = $aula->selectByTurmaHorarioData();
                if ($a) {
                    $aulas[] = $aula;
                } else {

                    if (in_array(date("Y-m-d"), $diaValido)) {
                        $aula->insert();
                        $aulas[] = $aula;
                    }else{
                        header("Location: ./");
                        exit();
                    }
                }
            }
            $_SESSION['aulas'] = serialize($aulas);
        } catch (Exception $ex) {
            $msg = $ex->getTraceAsString();
        }
    }

    switch ($_POST['submit']) {
        case 'sequencial':
            header("Location: chamada-individual");
            exit();
            break;
        case 'aleatoria':
            shuffle($alunos);
            $_SESSION['alunos'] = serialize($alunos);
            header("Location: chamada-individual");
            exit();
            break;
        case 'manual':
            header("Location: manual");
            exit();
            break;
        case 'historico':
            header("Location: seleciona-dia-historico");
            exit();
            break;
        case 'carometro':
            header("Location: carometro");
            exit();
            break;
        default :
            header("Location: ./");
            exit();
            break;
    }
}

$title = 'Selecionar Tipo de Chamada | Wide Education';
include './layout/page/tipo-chamada.page.php';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';


