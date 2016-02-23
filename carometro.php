<?php

include './include/session.include.php';
include './include/autoload.include.php';
include './include/access.include.php';
include_once './include/access-turma.include.php';
include_once './include/util.php';

ob_start();
$alunoTurma = new vw_alunoturma();
$turma = unserialize($_SESSION['turma']);
$alunoTurma->setId_turma($turma->getId_turma());
$listaAlunos = $alunoTurma->selectAllbyId_turma();

$title = 'Carômetro | Chamada - FACENS';
include './layout/page/carometro.page.php';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
