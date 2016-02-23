<div style="page-break-after: always; "><table style="width: 210mm; margin: 0mm;">

        <tr class="noborder">
            <td width="60%" colspan=3>
                <img alt="FACENS" src="./layout/img/logo-facens.png" style="max-height: 50px; margin-bottom: 10px;" />	
            </td>
            <td colspan="22" style="text-align: right; font-weight: bold; font-family: Arial; font-size: 16px;">
                FACULDADE DE ENGENHARIA DE SOROCABA<br/>
                CAMPUS ALEXANDRE BELDI NETTO

            </td>
        </tr>

        <tr>
            <td colspan="4" class="title-">
                <span class="titulo">Matéria</span><br />
                &nbsp; <?php echo strtoupper($disc->getNome()) . " (" . strtoupper($turma->getDisciplina()) . ")"; ?>
            </td>
            <td colspan="11" class="title-">
                <span class="titulo">Sala</span><br/> 
                &nbsp; <?php echo strtoupper($horaturma->getSala()); ?>
            </td>
            <td colspan="11" class="title-">
                <span class="titulo">Periodo Letivo</span><br/>
                &nbsp; <?php echo $turma->getPerletivo(); ?>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="title-">
                <span class="titulo">Professor</span><br/>
                &nbsp; <?php echo strtoupper($nomeProfessor) . ' (' . $_SESSION['prof-diario'] . ') '; ?>
            </td>
            <td colspan="11" class="title-">
                <span class="titulo">Turma</span><br/>

                &nbsp; <?php echo strtoupper($listaTurmasItem->getTurma()); ?>
            </td>
            <td colspan="11" class="title-">
                <span class="titulo">Turno</span><br/>
                &nbsp; <?php
                if ($horario->getTurno() == 'N')
                    echo 'NOITE';
                else
                    echo 'MANHÃ';
                ?>
            </td>
        </tr>
        <tr>
            <td rowspan="2" width="2%" style="vertical-align: bottom; text-align: center;">
                <span class="titulo">N&ordm;</span>
            </td>
            <td rowspan="2" width="6%" style="vertical-align: bottom; text-align: center;">
                <span class="titulo">Matrícula</span>
            </td>
            <td rowspan="2" width="42%" colspan="2" style="vertical-align: bottom;">
                <span class="titulo">Nome</span>
            </td>
            <td colspan="11" style="border-right: 0;"><b>Mês:</b> <?php echo $mesExtenso; ?></td>
            <td colspan="11" style="text-align: right; border-left: 0;"> <?php echo $listaTurmasItem->getId_turma(); ?> </td>

        </tr>
        <tr>
            <?php
            if (isset($aulasMes)):
                foreach ($aulasMes as $aulasMesI):
                    ?>
                    <td width="2.4%"><?php echo date("d", strtotime($aulasMesI->getData())); ?></td>
                <?php
                endforeach;

                for ($i = 0; $i < (21 - count($aulasMes)); $i++):
                    ?>

                    <td width="2.4%"></td>

                    <?php
                endfor;
            else:
                
                 for ($i = 0; $i < 21; $i++):
                    ?>

                    <td width="2.4%"></td>

                    <?php
                endfor;
            endif;
            ?>

            <td>
                <span class="titulo">TF</span>
            </td>

        </tr>