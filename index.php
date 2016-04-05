<?php
include './include/autoload.include.php';
include './include/session.include.php';
include './include/access.include.php';

if (isset($_SESSION['turma']))
    unset($_SESSION['turma']);
if (isset($_SESSION['dia']))
    unset($_SESSION['dia']);

ob_start();
//ooo
$usuario = $operador;



if ($usuario->getTipo() == 0) {
    header("Location: ./gerar-diario");
    exit();
}


if (isset($_POST['submit'])) {
    $post = explode("|", $_POST['submit']);
    $turma = new vw_turma($post[0]);
    $turma->select();

    $horaturma = new vw_horaturma();
    $horaturma->setId_turma($turma->getId_turma());
    $list = $horaturma->selectAllByDia_semana($post[1]);
    $horarios = array();
    foreach ($list as $ht) {
        $h = new vw_horario($ht->getId_horario());
        $h->select();
        $horarios[] = $h;
    }

    $turma->addAllHorario($horarios);
    $_SESSION['turma'] = serialize($turma);

    header("Location: tipo-chamada");
    exit();
}

$turma = new vw_turma();
$turma->setCod_prof($usuario->getLogin());
$turmas = $turma->selectAllByCod_prof();

//if (count($turmas) <= 0) {
//    session_destroy();
//    header("Location: ./login");
//    exit();
//}
$cont = 0;
$info = array();
foreach ($turmas as $itemTurmas) {

    $disc = new vw_disc($itemTurmas->getDisciplina());
    $disc->select();

    $horaturma = new vw_horaturma();
    $horaturma->setId_turma($itemTurmas->getId_turma());
    $list = $horaturma->selectAllById_turma();

    $horarios = array();
    $horario = array();
    foreach ($list as $value) {
        $h = new vw_horario($value->getId_horario());
        $h->select();
        $horarios[$h->getDia_semana()][] = $h;
    }
    for ($i = 2; $i <= 7; $i++) {
        if (isset($horarios[$i])) {
            if (count($horarios[$i]) == 1) {
                $horario[] = $horarios[$i][0];
            } else {
                $h1 = $horarios[$i][0];
                $h2 = $horarios[$i][count($horarios[$i]) - 1];

                if ($h1->getDia_semana() == $h2->getDia_semana()) {
                    $h3 = $h1;
                    $h3->setHora_fim($h2->getHora_fim());
                    $horario[] = $h3;
                } else {
                    $horario[] = $h1;
                    $horario[] = $h2;
                }
            }
        }
    }
    $horaturma = new vw_horaturma();
    $horaturma->setId_turma($itemTurmas->getId_turma());
    $horaturma->selectById_turma();
    foreach ($horario as $h) {
        $row = array();
        $row['turma'] = $itemTurmas->getTurma();
        $row['id_turma'] = $itemTurmas->getId_turma();
        $row['disc'] = $disc->getNome();
        $row['h_ini'] = $h->getHora_ini();
        $row['h_fim'] = $h->getHora_fim();
        $row['sala'] = $horaturma->getSala();
        $row['dia'] = $h->getDia_semana();
        $row['turno'] = $h->getTurno();
        $info[$h->getDia_semana()][] = $row;
    }
}
for ($i = 2; $i <= 7; $i++) {
    if (isset($info[$i])) {
        uasort($info[$i], 'cmp');
    }
}
$dias = array(
    2 => "<i class='glyphicon glyphicon-calendar text-info'></i> Segunda-Feira",
    3 => "<i class='glyphicon glyphicon-calendar text-info'></i> Terça-Feira",
    4 => "<i class='glyphicon glyphicon-calendar text-info'></i> Quarta-Feira",
    5 => "<i class='glyphicon glyphicon-calendar text-info'></i> Quinta-Feira",
    6 => "<i class='glyphicon glyphicon-calendar text-info'></i> Sexta-Feira",
    7 => "<i class='glyphicon glyphicon-calendar text-info'></i> Sábado"
);


include './layout/page/turmas-prof.page.php';

$corpo = ob_get_clean();
include './layout/page/mestre.page.php';

function cmp($a, $b) {
    if ($a['h_ini'] == $b['h_ini']) {
        return 0;
    } elseif ($a['h_ini'] > $b['h_ini']) {
        return 1;
    }
    return -1;
}

?>
