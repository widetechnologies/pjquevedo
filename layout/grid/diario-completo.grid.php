<!DOCTYPE html>
<?php include_once './include/autoload.include.php'; ?>
<?php include_once './include/util.php'; ?>
<html lang="pt-BR">
    <head>
        <title><?php echo $title; ?></title>
    </head>
    <body style="width: 210mm;">
        <?php
        $listaTurmas = unserialize($_SESSION['listaTurmas']);
        $prof = new vw_prof();
        $prof->setCodprof($_SESSION['prof-diario']);
        $prof->select();
        $nomeProfessor = $prof->getNome();
        foreach ($listaTurmas as $listaTurmasItem):
            $iniciok = 0;
            $iniciok = date("Y-m-d", strtotime($ano . '-' . $mesUsando . '-' . '01'));
            ?>

            <div style="page-break-before: auto; height: 300mm !important; clear: both; display: block;">


                <?php
                $aula = new aula();
                $aula->setId_turma($listaTurmasItem->getId_turma());
                $aulasMes = $aula->selectAllByTurmaMes($_SESSION['mes']);

                $horarioAula = new vw_horario();
                $diasDeAula1 = array();
                //
                $diasDeAula1 = $horarioAula->selectAllSemanaById_turma($listaTurmasItem->getId_turma());

                $listaDias = array();
                $dataAtual = $iniciok;
                $dataFinal = date("Y-m-d", strtotime($fimk));
                while ($dataAtual <= $dataFinal) {
                    //if ($dataInicio <= $dataFinal)
                    foreach ($diasDeAula1 as $diaSemanaOk) {
                        if (date("N", strtotime($dataAtual)) == ($diaSemanaOk->getDia_semana() - 1) && !in_array($dataAtual, $feriadosValidos)) {
                            $listaDias[] = $dataAtual;
                            break;
                        }
                    }
                    $dataAtual = date("Y-m-d", strtotime("+ 1 days", strtotime($dataAtual)));
                }//while

                $AulasNaSemana = array();
                $totalDiasValidos = 0;
                foreach ($listaDias as $diaValidoI) {
                    $horaTurma = new vw_horaturma();
                    $horaTurma->setId_turma($listaTurmasItem->getId_turma());
                    $aulasSemanaAtual = $horaTurma->selectAllByDia_semana((date('N', strtotime($diaValidoI)) + 1));
                    $totalDiasValidos +=count($aulasSemanaAtual);
                    $AulasNaSemana[] = $aulasSemanaAtual;
                }

                //instancio a lista de todos os alunos daquela turma
                $turma = $listaTurmasItem;
                //$turma->setId_turma($listaTurmasItem->getId_turma());
                //$turma->select();
                $disc = new vw_disc($turma->getDisciplina());
                $disc->select();
                $horaturma = new vw_horaturma($turma->getId_turma());
                $horaturma->select();
                $horario = new vw_horario($horaturma->getId_horario());
                $horario->select();

                //head diario
                include './include/head-diario.include.php';

                $aluno = new vw_aluno();
                $alunoCurso = new vw_aluno_curso();
                $listaAlunos = $aluno->selectAllById_turma($listaTurmasItem->getId_turma());
                $todosAlunosCursos = $alunoCurso->selectByIdTurma($listaTurmasItem->getId_turma());
                $count = 0;
                foreach ($listaAlunos as $aluno):
                    $count++;
                    ?>
                    <tr class="l" style="padding:0px">
                        <td style="text-align: center;"><?php echo $count; ?> </td>
                        <td style="text-align: center; width: 3%; font-size: 120%;"><?php echo $aluno->getRa(); ?></td>
                        <td  style=" width: 35%; font-size: 120%;"><?php echo abrevia(strtoupper($aluno->getNome()), 27); ?></td>
                        <td  style="text-align: center; width: 3%;"><?php
                            //define curso  
                            $alunoCurso = $alunoCurso->filtrarByRA($todosAlunosCursos,$aluno->getRa());
                            //$alunoCurso = array_search($aluno->getRa(), $todosAlunosCursos);
                            //$alunoCurs$todo->setRa($aluno->getRa());
                            //$alunoCurso->select();
                            $curso = $alunoCurso->getCodcurso();

                            switch ($curso) {

                                case $curso == 1:
                                    $curso = 'I';
                                    break;
                                case $curso == 2:
                                    $curso = 'E';
                                    break;
                                case $curso == 3:
                                    $curso = 'C';
                                    break;
                                case $curso == 4:
                                    $curso = 'M';
                                    break;
                                case $curso == 12:
                                    $curso = 'A';
                                    break;
                                case $curso == 14:
                                    $curso = 'P';
                                    break;
                                case $curso == 15:
                                    $curso = 'Q';
                                    break;
                                case $curso == 18:
                                    $curso = 'T';
                                    break;
                                case $curso == 19:
                                    $curso = 'J';
                                    break;
                            }//switch


                            echo $curso . $alunoCurso->getPeriodo();
                            ?></td>

                        <?php
                        $faltas = 0;
                        //preenche com ausencias e presencas
                        $aula->setId_turma($turma->getId_turma());
                        $aulasPresentes = array();
                        $aulasPresentes = $aula->selectAllByMesRaId_turma($_SESSION['mes'], $aluno->getRa());
                        $cont = 0;
                        $contF = 0;
                        $presencas = array();
                        foreach ($aulasMes as $a) {
                            if (in_array($a, $aulasPresentes)) {
                                echo '<span><td style="text-align: center; color: blue;">&bull;</td></span>';
                            } else {
                                echo "<td style='text-align: center; color: red;'><span>F</span></td>";
                                $contF++;
                            }
                            $cont++;
                        }


                        for ($i = 0; $i < 21 - count($aulasMes); $i++) {
                            echo'<td></td>';
                        }



                        //preenche as faltas do aluno
                        $faltas = $contF;
                        if ($faltas == 0)
                            $faltas = '-';
                        echo '<td style="text-align: center;">' . $faltas . '</td>';
                        ?>


                    </tr>

                    <?php
                    if ($count == 45) {
                        echo '</table></div>';

                        include './include/head-diario.include.php';
                    }// if count == 40

                endforeach;
                ?>
                <tr class="noborder">
                    <td colspan="10"></td>
                    <td colspan="15">
                        <span class="titulo">Data emiss&atilde;o:</span>
                        <span class="l"><?php echo date('d/m/Y'); ?></span>
                    </td>
                </tr><br style="clear:both; " /><br />   


            </table>

            <br /> 
            <br /> 
            <table>
                <tr style="width: 210mm;">
                    <td class="titulo" colspan="12" style="width:108mm !important; border: none; float: left; display: block; text-align: left;">Aulas Previstas: <?php echo $totalDiasValidos; ?> Aulas Dadas: <?php echo count($aulasMes); ?><br /><br />Data: _____/_____/_____</td>
                    <td colspan="12"  class="titulo" style="width:94mm !important; border:none; float: right; display: block;    ">Assinatura: _____________________________<br /> <br /><?php echo strtoupper($nomeProfessor) . ' (' . $_SESSION['prof-diario'] . ') '; ?> </td>
                </tr>
            </table>
            <br /><br />
        </div>

        <div style="clear: both; height: 10px;"> </div>
        <div style="page-break-before: auto; height: 300mm !important; clear: both; display: block;" ><p>
                <img alt="FACENS" src="./layout/img/logo-facens.png" style="max-height: 50px; margin-bottom: 10px; float: right; clear: both;" />	</p>
            <table style="width: 210mm; margin: 0mm;">
                <thead style="text-align: center; font-weight: normal; font-size: 100%;">
                    <tr class="title- ">
                        <th>Data</th>
                        <th>Matéria Lecionada</th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
                    <?php
//                endforeach;
                    $array = array();

                    foreach ($aulasMes as $aulasMesI3) {
                        if (!isset($array[$aulasMesI3->getData()]) && $aulasMesI3->getId_conteudo() != '') {
                            $array[$aulasMesI3->getData()] = $aulasMesI3->getId_conteudo();

                            $conteudo = new conteudo();
                            $conteudo->setId($aulasMesI3->getId_conteudo());
                            $conteudo->select();
                            ?>
                            <tr style="height: 10mm;">
                                <td style="height: 8mm;"><?php echo date("d/m/Y", strtotime($aulasMesI3->getData())); ?></td>
                                <td style="height: 8mm;" ><?php echo $conteudo->getConteudo(); ?></td>
                            </tr>
                            <?php
                        }//if
                    }//foreach
                    ?>

                    <?php
                    for ($i = 0; $i < (21 - count($aulasMes)); $i++):
                        ?>
                        <tr style="height: 10mm;">
                            <td style="height: 8mm;"></td>
                            <td style="height: 8mm;" ></td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
                <br />
                <br style="clear: both; padding: 20px; margin:20px;"/>
            </table>
            <br /><br /><br />
            <table>
                <tr>
                    <td colspan="12" class="titulo" style="width:108mm !important; border: none;  display: block; text-align: left;">     </td>
                    <td colspan="12" class="titulo" style="width:94mm !important; border:none;  display: block;    ">Assinatura: _____________________________<br /> <br /><?php echo strtoupper($nomeProfessor) . ' (' . $_SESSION['prof-diario'] . ') '; ?> </td>
                </tr><br />
            </table><br /><br/><br />
            <table style="padding-top: 20px; border:none;">
                <tr style="clear: both; border:none;" colspan="12">
                    <td>
                <u><b>Faltas:</b></u> O Professor deve realizar o controle de faltas em sala de aula e ao término do mês digitar no sistema o número de aulas dadas e as faltas de cada aluno, em seguida, entregar <b><u>este diário de classe </u>devidamente preenchido (nº de aulas dadas, faltas, matéria lecionada) e assinado na <u>Secretaria</u> </b>até o <b>décimo dia</b> do mês subsequente.
                <br />  <u><b>Avaliação:</b></u> Fazer a correção ou entrega de gabarito e mostrar a avaliação corrigida ao aluno <b>na aula seguinte</b> á avaliação. A nota deverá ser lançada no sistema até <b>uma semana</b> após a sua realização, mesmo que a nota tenha sido informada ao aluno.
                <br />  <u><b>Atenção:</b></u> A média é expressa em grau numérico de 0 (zero) a 10 (dez), <b>permitida fração de 0,5 grau.</b>                    (exemplos: 4; 5,5; 7; 8,5).
                </td>
                </tr>

            </table>

        <?php endforeach; ?>
    </div>
</body>

</html>