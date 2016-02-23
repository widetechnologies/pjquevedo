<?php

include './include/session.include.php';
include './include/autoload.include.php';
include './include/access.include.php';
include_once './include/access-turma.include.php';

$turma = unserialize($_SESSION['turma']);
include_once './include/turma-fechada.include.php';
$aulas = unserialize($_SESSION['aulas']);
$alunos = unserialize($_SESSION['alunos']);
$total = count($alunos);
ob_start();
if (($id_conteudo = $aulas[0]->getId_conteudo()) != "") {
    $conteudo = new conteudo($id_conteudo);
    $conteudo->select();
}
if (isset($_POST['submit'])) {
    if ($fechamentoC->getSituacao() != 1) {
        $c = $_POST['conteudo'];
        try {
            if (isset($conteudo)) {
                $conteudo->setConteudo($c);
                $conteudo->update();
            } else {
                $conteudo = new conteudo();
                $conteudo->setConteudo($c);
                $conteudo->insert();
                foreach ($aulas as $a) {
                    $a->setId_conteudo($conteudo->getId());
                    $a->update();
                }
            }
        } catch (Exception $exc) {
            $msg = $exc->getTraceAsString();
        }

        header("Location: ./conteudo?ok=1");
        exit();
    }
}

if (isset($_POST['voltar'])) {
    if (isset($_SESSION['dia']))
        unset($_SESSION['dia']);
    if (isset($_SESSION['diaValido']))
        unset($_SESSION['diaValido']);
    unset($_SESSION['turma']);
    header("Location: ./");
    exit();
}

if (isset($_POST['logout'])) {
    header("Location: ./login?out");
    exit();
}
$countPresentes = array();
foreach ($aulas as $a) {
    $presenca = new presenca();
    $presenca->setId_aula($a->getId());
    $countPresentes[] = $presenca->countPresentesByAula();
}

if (isset($_GET['ok']) && $_GET['ok'] == 1) {
    include './layout/page/fim.page.php';
    $title = 'Chamada Realizada Com Sucesso | Chamada - FACENS';
} else {
    include './layout/page/conteudo.page.php';
}
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
?>