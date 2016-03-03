<?php

include './include/session.include.php';
include './include/autoload.include.php';
include './include/access.include.php';

$base = parse_ini_file('./config/conf.ini', true);
$perletivo = $base['perletivo'];
$perlet = $perletivo['perlet'];
$ini = $perletivo['inicio'];
$fim = $perletivo['fim'];

//cria lista mes validos
for ($i = date("m", strtotime($ini)); $i < date("m", strtotime($fim)); $i++)
    if ($i <= date("m"))
        $mesValido[] = $i;

ob_start();

if (isset($_POST['submit']) && $_POST['cod_turma'] != '' && $_POST['options'] != '') {
    try {
        $turmaCont = new vw_turma();
        $turmaCont->setTurma(strtoupper(trim($_POST['cod_turma'])));

        //if (is_numeric($turmaCont->getTurma()))
        //$turmaCont->select();
        //else
        $turmaCont->selectByCodTurma();

        if ($turmaCont->getCod_prof() != '') {
            $controle = new controle_diario();

            $controle->setId_turma($turmaCont->getId_turma());
            $controle->setMes(intval($_POST['options']));
            $controle->selectInserido();

            if ($controle->getEntregue() == 1) {
                $erro = 'Esse diário já foi inserido dia <b>' . date('d/m/Y', strtotime($controle->getDt_modif())) . '</b> pelo usuário <b>' . $controle->getCod_func() . '</b>.'
                        . '<br /><br /> <a href="./relatorio-entregas?cod_prof=' . $turmaCont->getCod_prof() . '"> clique aqui para ver o relário de ' . $turmaCont->getCod_prof() . '</a>';
            } else {

                $controle->setEntregue(1);
                $controle->setCod_func($operador->getLogin());
                if ($controle->insert())
                    $sucesso = 'O diário da turma <b>' . $turmaCont->getTurma() . '</b> foi recebido dia <b>' . date("d/m/Y") . '</b> pelo usuário: <b>' . $operador->getLogin() . '</b>.'
                            . '<br /><br /> <a href="./relatorio-entregas?cod_prof=' . $turmaCont->getCod_prof() . '"> clique aqui para ver o relário de ' . $turmaCont->getCod_prof() . '</a>. ';
                else
                    $erro = "Houve um erro ao inserir o diario, tente novamente mais tarde. <br /><br />Se esse erro persistir, consulte o LEC!";
            }
        } else {
            $erro = 'Não encontramos nenhuma turma com esse código... Tente novamente!';
        }//else
    } catch (Exception $exc) {
        $msg = $exc->getTraceAsString();
    }//catch
}//isset
$title = 'Controle de Entrega de Diários | Wide Education';
include './layout/page/controle-diario.page.php';
$corpo = ob_get_clean();

include './layout/page/mestre.page.php';
?>
