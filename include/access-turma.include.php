<?php

if (!isset($_SESSION['turma'])) {
    header("Location: ./");
    exit();
}

if ($operador->getTipo() != 1 && $operador->getTipo() != 2) {
    header("Location: ./");
    exit();
}
?>