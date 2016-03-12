<?php
include_once './include/session.include.php';
include './include/autoload.include.php';
include './include/access.include.php';
ob_start();
set_time_limit(0);
?>
<div class="container-fluid">
    <form enctype="multipart/form-data" method="POST">
        <input type="file" name="arquivo" />
        <button name="submit" class="btn btn-success" type="submit"> Enviar</button>
    </form>
</div>
<?php
if (isset($_POST['submit'])) {
    require_once './class/PHPExcel.class.php';
    $objReader = new PHPExcel_Reader_Excel5();
    $objReader->setReadDataOnly(true);
    $objPHPExcel = $objReader->load($_FILES['arquivo']['tmp_name']);
    $sheets = $objPHPExcel->getSheetCount();

    for ($i = 0; $i < $sheets; $i++) {
        $curso = new vw_curso();
        $sheet = $objPHPExcel->getSheet($i);
        $curso->setNome($sheet->getTitle());
        var_dump($curso);
        //$curso->insert();
        $colunas = array('B', 'C', 'F','E');
        $total_c = PHPExcel_Cell::columnIndexFromString($sheet->getHighestColumn());
        $total_l = intval($sheet->getHighestRow());
        for ($l = 2; $l <= $total_l; $l++) {
            $aluno = new vw_aluno();
            $c = 0;
            //echo "</br>Nome -> L: $l C: $c </br>";
            $aluno->setNome(strval($sheet->getCell($colunas[$c] . $l)->getValue()));
            $c++;
            //echo "</br>Ra -> L: $l C: $c </br>";
            $aluno->setRa(strval($sheet->getCell($colunas[$c] . $l)->getValue()));
            $c++;
            //echo "</br>Turno -> L: $l C: $c </br>";
            $aluno->setTurno(strval($sheet->getCell($colunas[$c] . $l)->getValue()));
            $c++;
            //$aluno->insert();
            //var_dump($aluno);
            $alunocurso = new vw_aluno_curso();
            $alunocurso->setRa($aluno->getRa());
            $alunocurso->setCodcurso($curso->getId());
            //$alunocurso->setPeriodo($aluno->getTurno());
            $alunocurso->setPerletivo(strval($sheet->getCell($colunas[$c] . $l)->getValue()));
            $alunocurso->setCodturno($aluno->getTurno());
            //$alunocurso->insert();
            //var_dump($alunocurso);
            
        }
//        echo '<table>';
//        for($l = 2; $l <= $total_l; $l++){
//            echo '<tr>';
//            for($c = 2; $c <= $total_c; $c++){
//                echo '<td>';
//                    echo $sheet->getCellByColumnAndRow($c++, $l)->getValue(). "  L: $l C: $c";
//                echo '</td>';
//            }
//            echo '</tr>';
//        }
//        echo '</table>';
    }
}

$title = 'Aluno | Chamada - Wide Education';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
?>
