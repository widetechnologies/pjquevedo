<?php



if (isset($_SESSION['turma'])) {
    $mes = intval($_SESSION['mes']);
    $usuario = unserialize($_SESSION['operador']);
    try {

        $turmas = unserialize($_SESSION['turma']);
        foreach ($turmas as $t) {
            $t = unserialize($t);
            $registro = new registro();
            $registro->setMes($mes);
            $registro->setId_turma($t->getId_Turma());
            $registro->setMes($mes);
            $registro->setTipo_op("INSERT");

            if ($registro->selectById_turmaTipo_opMes()) {
                exporta($t, $mes, "UPDATE");
                registro($usuario, $t, $mes, "UPDATE");
            } else {
                exporta($t, $mes, "INSERT");
                registro($usuario, $t, $mes, "INSERT");
            }
            $exporta = new exporta();
            $exporta->setPerletivo($t->getPerletivo());
            if (!$exporta->webServiceExporta($t->getTurma(), $mes)) {
                throw new Exception("Exportação Falhou");
            }
        }
    } catch (Exception $ex) {
        echo $ex->getTraceAsString();
    }
}


function exporta($turma, $mes, $op) {
    $exporta = new exporta();
    $exporta->setCodtur($turma->getTurma());
    $exporta->setPerletivo($turma->getPerletivo());
    $exporta->setCodmat($turma->getDisciplina());
    $exporta->setNum($mes);

    $aluno = new vw_aluno();
    $alunos = $aluno->selectAllById_turma($turma->getId_turma());

    $aula = new aula();
    $aula->setId_turma($turma->getId_turma());
    $aulasDadas = count($aula->selectAllByTurmaMes($mes));

    foreach ($alunos as $a) {
        $exporta->setMatricula($a->getRa());

        $presenca = new presenca();
        $presenca->setRa($a->getRa());
        $presencaMes = $presenca->countById_turmaRaMes($turma->getId_turma(), $mes);
        $f = abs($aulasDadas - $presencaMes);
        $exporta->setF($f);
        $exporta->setAd($aulasDadas);
        $exporta->insert();
     
    }
}

function registro($usuario, $turma, $mes, $op) {
    $registro = new registro();
    $registro->setUsuario($usuario->getLogin());
    $registro->setId_turma($turma->getId_turma());
    $registro->setMes($mes);
    $registro->setTipo_op($op);
    $registro->insert();
    if($op == "INSERT"){
        $fechamento = new fechamento();
        $fechamento->setId_turma($turma->getId_turma());
        $fechamento->setMes($mes);
        $fechamento->setPerletivo($turma->getPerletivo());
        $fechamento->setSituacao(1);
        $fechamento->insert();
    }
}

?>