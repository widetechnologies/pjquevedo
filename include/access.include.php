<?php
if (!isset($_SESSION['operador'])) {
    header('Location: login');
    exit();
} else {  
//    if(!isSerialized($_SESSION['operador'])){
//    echo '<pre>';
//    $ser = isSerialized($_SESSION['operador']);
//    echo 'IsSerialized = '.$ser.'<br/>';
//    echo 'DADOS SESSION= ';
//    print_r($_SESSION['operador']);
//    echo '</pre>';
//    }
    
    $operador = $_SESSION['operador'];
    if (isSerialized($operador)) {
        $operador = unserialize($operador);
    }
}

function isSerialized($str) {
    return ($str == serialize(false) || @unserialize($str) !== false);
}
?>