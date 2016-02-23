<script>
    var mes = <?php echo $mes; ?>;
    $(function () {
        $('.exporta').click(function () {
            var $btn = $(this).button('loading');
            $.ajax({
                url: "seleciona-diario-unico.php",
                type: 'POST',
                dataType: 'html',
                data: {'exporta': $(this).val(), 'options': mes}
            }).done(function (data) {
                $('#load').html(data);
                $btn.button('reset');
                var y = ".d" + $(this).val();

            });
        });
    });
    function mes(m) {
        mes = m;
    }
</script>
<?php
$ad = new vw_turma();
$adArray = array();
$adArray2 = array();
$ad->setCod_prof($operador->getLogin());
$adArray2 = $ad->selectAllByMesAndCodprof($mes);

foreach ($adArray2 as $adI){
    $adArray[] = $adI->getId_turma();
}

$cont = 0;
$abertas = array();
$fechadas = array();
foreach ($listaTurmas as $listaTurmasI):
    $disc = new vw_disc($listaTurmasI->getDisciplina());
    $disc->select();
    $fechamento = new fechamento();
    $fechamento->setId_turma($listaTurmasI->getId_turma());
    $fechamento->setMes($mes);
    $f = $fechamento->selectById_turmaMes();
    if (!$f || $fechamento->getSituacao() == 0) {
        $abertas[] = serialize($listaTurmasI);
    } else {
        $fechadas[] = serialize($listaTurmasI);
    }
    ?>
    <div class="row">            
             <!--AQUI ESTAVA OS BOTÕES DE EXPORTA -->
        <div class="col-lg-8 col-xs-8 col-sm-8 col-md-8">
            <button class="btn btn-info btn-block <?php           
            echo ' ' . 'd' . $listaTurmasI->getId_turma();
            ?>" type="submit" name="submit" value="<?php echo $listaTurmasI->getId_turma(); ?>"><i class="glyphicon glyphicon-book"></i> <?php echo $listaTurmasI->getTurma() . ' <br /> ' . $disc->getNome();?></button>
        </div>
    </div><br /><br />
    <?php
endforeach;
$_SESSION['abertas'] = serialize($abertas);
$_SESSION['fechadas'] = serialize($fechadas);
?>

<div class="row">
    <!--AQUI ESTAVA O BOTÃO DE EXPORTAR TODOS -->
    <div class="col-lg-8 col-xs-8 col-sm-8 col-md-8">
        <button class="btn btn-info btn-block" type="submit" name="submit" value="todos"><i class="glyphicon glyphicon-th"></i> Todos</button>
    </div>
</div>
