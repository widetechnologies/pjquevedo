<?php

set_time_limit(0);

ini_set("memory_limit", "2048M");

//include_once './include/controle.include.php';
include_once './include/session.include.php';
include_once './include/util.php';
//include_once './include/controle-turma.include.php';

if ($_SESSION['mes'] == 1)
    $mesExtenso = 'JANEIRO';
elseif ($_SESSION['mes'] == 2)
    $mesExtenso = 'FEVEREIRO';
elseif ($_SESSION['mes'] == 3)
    $mesExtenso = 'MARÇO';
elseif ($_SESSION['mes'] == 4)
    $mesExtenso = 'ABRIL';
elseif ($_SESSION['mes'] == 5)
    $mesExtenso = 'MAIO';
elseif ($_SESSION['mes'] == 6)
    $mesExtenso = 'JUNHO';
elseif ($_SESSION['mes'] == 7)
    $mesExtenso = 'JULHO';
elseif ($_SESSION['mes'] == 8)
    $mesExtenso = 'AGOSTO';
elseif ($_SESSION['mes'] == 9)
    $mesExtenso = 'SETEMBRO';
elseif ($_SESSION['mes'] == 10)
    $mesExtenso = 'OUTUBRO';
elseif ($_SESSION['mes'] == 11)
    $mesExtenso = 'NOVEMBRO';
elseif ($_SESSION['mes'] == 12)
    $mesExtenso = 'DEZEMBRO';


//variaveis de meta
$title = 'Diário de Sala - '  . ' - ' . $mesExtenso . ' | FACENS';

ob_start();
include_once './layout/grid/diarioBranco.grid.php';
$pdf = ob_get_clean();

define('MPDF_PATH', 'include/mpdf/');
include(MPDF_PATH . 'mpdf.php');

//criando o objeto com os parametros de tipo de folha e margens
$mpdf = new mPDF('c', 'A4', '', '', 5, 5, 5, 10);


//incluindo rodapé
$mpdf->defaultfooterline = 0;
//$mpdf->defaultfooterfontstyle = 'B';
//
////configurando paginas impares
$mpdf->SetFooter(array(
    'L' => array(
        'content' => $content,
        'font-family' => 'arial',
        //'font-style' => '', /* blank, B, I, or BI */
        'font-size' => '9', /* in pts */
    ),
    'line' => 0, /* 1 to include line below header/above footer */
        ), 'E'
);
//condigurando paginas pares
$mpdf->SetFooter(array(
    'L' => array(
        'content' => $content,
        'font-family' => 'arial',
        //'font-style' => '', /* blank, B, I, or BI */
        'font-size' => '9', /* in pts */
    ),
    'line' => 0, /* 1 to include line below header/above footer */
        ), 'O'
);
$mpdf->SetTitle($title);
$stylesheet = file_get_contents('layout/css/css-pdf.css');
$mpdf->WriteHTML($stylesheet, 1);

//quando for mandar para o servidor, comentar a linha abaixo.
//$pdf = utf8_encode($pdf);


$mpdf->WriteHTML($pdf);
//$mpdf->SetJS('this.print();');
//imprimindo
$mpdf->Output();

//unset ($_SESSION['mes']);
//unset($_SESSION['turma']);

exit();
?>
