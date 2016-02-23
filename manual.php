<?php

include './include/session.include.php';
include './include/autoload.include.php';
include './include/access.include.php';
include_once './include/access-turma.include.php';



ob_start();
$aluno = new vw_aluno();
$aulas = unserialize($_SESSION['aulas']);
$turma = unserialize($_SESSION['turma']);
include_once './include/turma-fechada.include.php';
redirectFechado($fechamentoC);
//$aluno->setId_turma();
$listaAlunos = $aluno->selectAllbyId_turma($turma->getId_turma());
$listaHorarios = $turma->getHorarios();

$alunosAusentes = array();
$alunosNomes = array();
$alunosPresentes = array();

foreach ($aulas as $au) {
    foreach ($listaAlunos as $a) {
        $alunosAusentes[] = $a->getRa() . '|' . $au->getId_horario();
    }
    $alu = new vw_aluno();
    $alunosPresentes[] = $alu->selectAllPresentesByAula($au->getId());
}

if (isset($_POST['submit'])) {
    $listaRaPresente = array();
    $listaRaPresente = $_POST['presenca'];
    $_SESSION['presenca'] = serialize($_POST['presenca']);
//    echo '<pre>';
//    print_r($listaRaPresente);
//    echo '</pre>';
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
    header("Location: ./conteudo");
    exit();
}//isset submit
$title = 'Chamada Manual | FACENS';
include './layout/page/manual.page.php';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
