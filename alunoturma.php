<?php

include_once './include/session.include.php';
include './include/autoload.include.php';
include './include/access.include.php';

if ($operador->getTipo() != 1) {
    header("Location: ./");
    exit();
}

ob_start();
$model = new vw_alunoturma();
if (isset($_POST['select'])) {
    $aluno = new vw_aluno();
    $alunos = $aluno->selectAllById_curso($_POST['select']);
    echo "<script>  $('#checkt').change(function(){
            var ch = $(this).prop('checked');
            $('.check').prop('checked',ch);
        });
</script>";
    echo "<label><input type='checkbox' id='checkt'/> Selecionar todos</label></br>";
    foreach ($alunos as $value) {
        echo "<label><input class='check' type='checkbox' value='{$value->getRa()}' name='aluno[]'/> {$value->getRa()} - {$value->getNome()}</label>";
    }
    exit();
}

if (isset($_POST['excluir'])) {
    $model->setId($_POST['excluir']);
    $model->delete();
    $model = new vw_alunoturma();
}

if (isset($_GET['id'])) {
    try {
        if (isset($_POST['submit'])) {
            $id_turma = $_POST['id_turma'];
            $ra = $_POST['ra'];
            $id = $_POST['id'];
            $perletivo = $_POST['perletivo'];

            $model->setId($id);
            $model->setId_turma($id_turma);
            $model->setRa($ra);
            $model->setPerletivo($perletivo);

            if ($id != '') {
                $model->update();
                header('location: alunoturma');
            } else {
                $model->insert();
                header('location: alunoturma');
            }
        } else {
            $model = new vw_alunoturma($_GET['id']);
            $model->select();
        }
    } catch (Exception $exc) {
        $msg = $exc->getTraceAsString();
        die();
    }
} else if (isset($_POST['submit'])) {
    $id_turma = $_POST['id_turma'];
    $ras = $_POST['aluno'];
    $id = $_POST['id'];
    $perletivo = $_POST['perletivo'];

    foreach ($ras as $ra) {
        $model->setId($id);
        $model->setId_turma($id_turma);
        $model->setRa($ra);
        $model->setPerletivo($perletivo);

        $model->insert();
    }
}
$turma = new vw_turma();
$turmas = $turma->selectAll();
$models = $model->selectAll();
$curso = new vw_curso();
$cursos = $curso->selectAll();

$title = 'Aluno turma | Chamada - Wide Education';
include './layout/page/alunoturma.page.php';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
?>
