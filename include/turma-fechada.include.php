<?php

if (isset($_SESSION['turma'])) {
    $fechamentoC = new fechamento();

    if (isset($_POST['mes']) || isset($_SESSION['mes']) || isset($mes) || isset($_GET['dia']) || isset($_SESSION['dia'])) {
        if(isset($_POST['mes'])){
            $mes = $_POST['mes'];
        }else if(isset($_SESSION['mes'])){
            $mes = $_SESSION['mes'];
        }else if(isset($_GET['dia'])){
            $mes = date("m", strtotime($_GET['dia']));
        }else if(isset ($_SESSION['dia'])){
            $mes = date("m", strtotime($_SESSION['dia']));
        }
        $fechamentoC->setMes($mes);
    } else {
        $fechamentoC->setMes(date("m"));
    }
    
    $fechamentoC->setId_turma($turma->getId_turma());
    $fechamentoC->selectById_turmaMes();
}//if

function redirectFechado($fechamentoC) {
    if ($fechamentoC->getSituacao() == 1) {
        header("Location: ./");
        exit();
    }
}

?>
