<?php

function abrevia($nome, $limite) {
    if (strlen($nome) <= $limite)
        return $nome;
    else {
        $pedacos = explode(' ', $nome);
        $cont = count($pedacos) - 2;
        do {
            $abrevia = "";
            $atual = strtolower($pedacos[$cont]);
            if ($atual != "de" && $atual != "da" && $atual != "das" && $atual != "dos") {
                $pedacos[$cont] = $pedacos[$cont][0] . '.';
                if ($cont > 0) {
                    $anterior = strtolower($pedacos[$cont - 1]);
                    if ($anterior == "de" || $anterior == "da" || $anterior == "das" || $anterior == "dos") {
                        $pedacos[$cont - 1] = '';
                        $cont--;
                    }
                }
            }
            $cont--;
            foreach ($pedacos as $p) {
                $abrevia .= $p . ' ';
            }
        } while (strlen($abrevia) > $limite && $cont > 0);
        return substr($abrevia, 0, $limite);
    }
}

function formataData($data, $tipo) { //corrige formato de data (br <-> us)
    switch ($tipo) {
        case "br": //us -> br
            $partes = explode("-", $data);
            $hora = explode(" ", $partes[2]);
            $data2 = "$hora[0]/$partes[1]/$partes[0]";
            break;
        case "us": //br -> us
            $partes = explode("/", $data);
            $hora = explode(" ", $partes[2]);
            $data2 = "$hora[0]-$partes[1]-$partes[0]";
            break;
        default:
            $data2 = $data;
    }
    return $data2;
}

function registra($msg) {

    $log = fopen('log/chamada.log', 'a+');

    $msg = date("YmdHis") . ": $msg\n";

    fprintf($log, "%s", $msg);

    fclose($log);
}

?>
