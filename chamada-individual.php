<?php

include './include/session.include.php';
include './include/autoload.include.php';
include './include/access.include.php';
include_once './include/access-turma.include.php';


ob_start();
$turma = unserialize($_SESSION['turma']);
include_once './include/turma-fechada.include.php';
redirectFechado($fechamentoC);
$aulas = unserialize($_SESSION['aulas']);
if (isset($_POST['proximo'])) {
    header("Location: conteudo");
    exit();
}
if (isset($_SESSION['alunos'])) {
    $alunos = unserialize($_SESSION['alunos']);
    $cont = count($alunos) - 1;
}

if (isset($_POST['esq'])) {
    $i = $_SESSION['indice'];
    if ($i == 0) {
        exit();
    } else {
        $i--;
        $aluno = $alunos[$i];
        $_SESSION['indice'] = $i;
        if (isset($_SESSION['presenca'][$aluno->getRa()])) {
            $presenca = $_SESSION['presenca'][$aluno->getRa()];
        }
        include './layout/grid/info-aluno.grid.php';
        exit();
    }
}

if (isset($_POST['dir'])) {
    avancaDir($alunos);
}
if (isset($_POST['presente'])) {
    try {
        $aluno = $alunos[$_SESSION['indice']];
        $_SESSION['presenca'][$aluno->getRa()] = 'P';
        foreach ($aulas as $a) {
            $presenca = new presenca();
            $presenca->setRa($aluno->getRa());
            $presenca->setId_aula($a->getId());
            $presenca->setSituacao(1);
            if (!$presenca->selectByAulaRa()) {
                if (!$presenca->insert()) {
                    throw new Exception("Erro ao marcar presença para este aluno!");
                }
            }
        }
    } catch (Exception $exc) {
        $msg = $exc->getTraceAsString();
    }

    avancaDir($alunos);
}
if (isset($_POST['ausente'])) {
    try {
        $aluno = $alunos[$_SESSION['indice']];
        $_SESSION['presenca'][$aluno->getRa()] = 'A';
        foreach ($aulas as $a) {
            $presenca = new presenca();
            $presenca->setRa($aluno->getRa());
            $presenca->setId_aula($a->getId());
            if ($presenca->selectByAulaRa()) {
                if (!$presenca->delete()) {
                    throw new Exception("Erro ao marcar falta para este aluno!");
                }
            }
        }
    } catch (Exception $exc) {
        $msg = $exc->getTraceAsString();
    }

    avancaDir($alunos);
}

$aluno = $alunos[$_SESSION['indice']];
$title = 'Chamada Individual | Chamada - FACENS';
include './layout/page/chamada-individual.page.php';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';

function avancaDir($alunos) {
    $i = $_SESSION['indice'];
    if ($i == count($alunos) - 1) {
        exit();
    } else {
        $i++;
        $aluno = $alunos[$i];
        $_SESSION['indice'] = $i;
        if (isset($_SESSION['presenca'][$aluno->getRa()])) {
            $presenca = $_SESSION['presenca'][$aluno->getRa()];
        }
        include './layout/grid/info-aluno.grid.php';
        exit();
    }
}
