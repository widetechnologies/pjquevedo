<?php

if (!isset($_SESSION['operador'])) {
    header('Location: login');
    exit();
} else {
    if (!isset($operador))
        $operador = unserialize($_SESSION['operador']);
}
?>