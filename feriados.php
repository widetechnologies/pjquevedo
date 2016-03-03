<?php

include './include/session.include.php';
include './include/autoload.include.php';
include './include/access.include.php';
if ($operador->getTipo() != 0 && $operador->getTipo() != 1) {
    header("Location: ./");
    exit();
}
ob_start();
if (isset($_POST['submit'])) {
    if ($_POST['calendario'] != '') {
        try {
            $feriado = new feriado();
            $feriado->setData($_POST['calendario']);
            $feriado->insert();
        } catch (Exception $ex) {
            
        }
    }
}//if 

if (isset($_POST['excluir'])) {
    try {
        $feriadoExclui = new feriado();
        $feriadoExclui->setId_feriado($_POST['excluir']);
        $feriadoExclui->delete();
    } catch (Exception $ex) {
        
    }
}//if
try {
    $feriadoLista = new feriado();
    $feriados = $feriadoLista->selectAll();
    foreach ($feriados as $item) {
        $feriadosValidos[] = date("Y-m-d", strtotime($item->getData()));
    }//foreach
} catch (Exception $ex) {
    
}

$title = 'Gerenciar feriados | Chamada - Wide Education';
include './layout/page/feriados.page.php';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
?>
