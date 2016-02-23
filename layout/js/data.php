<script type="text/javascript">
    var codropsEvents = {
<?php
$presenca = new presenca();
$turmaData = Array();
$presentes = Array();

foreach ($diaValido as $dia) {
    $aula = new aula();
    $aula->setData($dia);
    $aula->setId_turma($turma->getId_turma());
    $turmaData = $aula->selectAllByTurmaAndData();

    $alunoTurma = new vw_alunoturma();
    $alunoTurma->setId_turma($turma->getId_turma());

    $turmaDatas = array();
    $alunosAtivos = $alunoTurma->countById_turma();
    foreach ($turmaData as $turmaDataI) {

        $turmaDatas[] = $turmaDataI->getId();
        //presentes é um array que guarda os presentes de cada aula
    }//foreach
    $presentes = $presenca->countAllPresentesByAulas(implode(',', $turmaDatas));
    foreach ($presentes as $value) {
        $presentes[$dia][] = $value;
    }

    $line = "'" . date("m-d-Y", strtotime($dia)) . "'" // '00-00-0000'
            . ' : ' // :
            . "'" //abre chaves 
            . '<a href="./historico?dia=' . $dia . '" class="btn btn-lg btn-block">Ver Histórico</a>';
    if (isset($presentes[$dia]))
        $line .= '<a href="./excluir-dia?dia=' . $dia . '" class="btn btn-lg btn-block text-danger">Excluir Aula</a>'; //conteudo html
    $cont = 0;
    if (isset($presentes[$dia])) {
        foreach ($presentes[$dia] as $presentesI) {
            $cont++;
            if ($presentesI > 0) {
                $line .= '<a class="falsea2">Presentes na ' . $cont . 'ª aula: ' . $presentesI . '</a>';
            }
        }
    }
    $line .= '<a class="falsea">Total de matriculados na turma: ' . $alunosAtivos . '</a>';
    $line .= "'," //termina a chave e poe virgula
            . "\n";

    echo $line;
}
?>
    };
</script>
