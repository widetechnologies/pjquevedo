<?php

include './include/session.include.php';
include './include/autoload.include.php';
include './include/access.include.php';

$alunoPesquisa = new pesquisa_aluno();
$usuario = unserialize($_SESSION['operador']);
ob_start();


// teste do git
if (isset($_POST['submit'])) {
    if (!isset($_POST['aluno'])) {
        header("Location: ./aluno");
        exit();
    } else {
        $pesquisa = $_POST['aluno'];
        $pesquisa = ltrim($pesquisa);
        $pesquisa = rtrim($pesquisa);
        if ($pesquisa != '' && $pesquisa != ' ') {
            if (is_numeric($pesquisa)) {
                try {
                    if (($alunoPesquisa->selectRA($pesquisa))) {
                        if (isset($alunoPesquisa->nome) && $alunoPesquisa->nome != '') {
                            header("location: ./aluno?ra={$alunoPesquisa->ra}");
                            exit();
                        } else {
                            $erro = 'Não encontramos nenhum RA correspondente a sua pesquisa... Tente uma nova pesquisa.';
                        }
                    } else {

                        //  exit();
                    }
                } catch (Exception $exc) {
                    $msg = $exc->getTraceAsString();
                }
            } else {
                try {
                    $pesquisa = str_replace(' ', '%', $pesquisa);
                    $pesquisa = '%' . $pesquisa . '%';
                    $listaEnc = Array();
                    if (($listaEnc = $alunoPesquisa->selectAllPesquisa($pesquisa))) {
                        $encontrado = true;
                    } else
                        $erro = 'Não conseguimos encontrar nada relacionado a sua pesquisa, tente uma nova pesquisa.';
                } catch (Exception $exc) {
                    $msg = $exc->getTraceAsString();
                }
            }//else
        } else {
            $erro = 'Para realizar pesquisas você precisa digitar algo... Tente uma nova pesquisa!';
            $null = true;
        }
    }
}//post aluno

if(isset($_POST['escolher'])){
    header("Location: ./aluno?ra={$_POST['escolher']}");
    exit();
}

if (isset($_GET['ra'])) {
    $ra = $_GET['ra'];
    $aluno = new vw_aluno();
    $aluno->setRa($ra);
    $aluno->selectComTurno();
    if ($aluno->getNome() == '' || $aluno->getNome() == '') {
        header("Location: ./aluno");
        exit();
    } else {
        $turma = new vw_turma();
        $listaTurmasAluno = Array();
        $turma->setCod_prof($usuario->getLogin());
        $listaTurmasAluno = $turma->selectAllAlunosByCodprof($ra);
        $curso = new vw_curso();
        $curso->selectByRa($ra);
    }
    include './layout/page/aluno.page.php';
    $title = 'Detalhes do aluno '.$ra.' | Chamada - FACENS';
} else{
    include './layout/form/pesquisar-aluno.form.php';
    $title = 'Pesquisa de Alunos | Chamada - FACENS';
}

$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
?>