<?php

function __autoload($class_name) {
    if (file_exists("class/$class_name.class.php")) {
        include("class/$class_name.class.php");
    } 
    else if (file_exists("./class/bd/$class_name.class.php")) {
        include("class/bd/$class_name.class.php");
    }
    else {
        echo "Não foi possível carregar a arquivo de classe.";
    }
}
