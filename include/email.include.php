<?php

function enviaEmail() {
    global $usuario;
    
    //$hash = base64_encode(date('Y-m-d', strtotime('now')).$usuario->getLogin());
    $hash = fcrypt::encrypt(date('Y-m-d', strtotime('now')).$usuario->getLogin());
    $hash = urlencode($hash);
    
    $dest = $usuario->getEmail();
//    $dest = 'fbogila@li.facens.br';
    $send_name = 'Facens';
    $send = "noreply@facens.com.br";

    $subj = "Troca de senha";
    $corpo = "Olá, você esqueceu sua senha e está tentando alterá-la? \r\n\r\n<br><br>";
    $corpo .= "Se sim, clique no link: <a href='http://www3.facens.br/global/trocasenha?code=$hash'>http://www3.facens.br/global/trocasenha?code=$hash</a>\r\n\r\n<br><br>";
    $corpo .= "Se não, desconsidere esse e-mail.\r\n\r\n<br><br>";
    $corpo .= "Facens - Faculdade de Engenharia de Sorocaba.";
    
    //$header .= "Bcc: " . $replyto . "\r\n";
    $header = "MIME-Version: 1.0\r\n";
    $header .= "Content-type:text/html;charset=UTF-8\r\n";
    $header .= "From: " . $send_name . " <" . $send . ">\r\n";


    return mail($dest, $subj, $corpo, $header);
}
?>

