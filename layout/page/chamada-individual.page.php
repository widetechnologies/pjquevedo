<script>
    var cont = <?php echo $cont; ?>;
    var i = <?php echo $_SESSION['indice']; ?>;

    $(function () {

        $('.esq').click(function () {
            gifLoad();
            $.ajax({
                url: "chamada-individual.php",
                type: 'POST',
                dataType: 'html',
                data: {'esq': $(this).val(), 'status': 0}
            }).done(function (data) {

                $('#info-aluno').html(data);
                gifLoaded();
                $('.dir').removeClass('disabled');
                i--;
                if (i === 0) {
                    $('.esq').addClass('disabled');
                }

            });
        });

        $('.dir').click(function () {
            gifLoad();
            $.ajax({
                url: "chamada-individual.php",
                type: 'POST',
                dataType: 'html',
                data: {'dir': $(this).val(), 'status': 0}
            }).done(function (data) {
                $('#info-aluno').html(data);
                gifLoaded();
                $('.esq').removeClass('disabled');
                i++;
                if (i === cont) {
                    $('.dir').addClass('disabled');
                }              
            });
        });

        $('.A').click(function () {
            gifLoad();
            $.ajax({
                url: "chamada-individual.php",
                type: 'POST',
                dataType: 'html',
                data: {'ausente': $(this).val(), 'status': 0}
            }).done(function (data) {
                if (data === "") {
                    window.location.href = "conteudo";
                    return;
                }
                $('#info-aluno').html(data);
                gifLoaded();
                $('.esq').removeClass('disabled');
                i++;
                if (i === cont) {
                    $('.dir').addClass('disabled');
                }

            });
        });


        $('.P').click(function () {
            gifLoad();
            $.ajax({
                url: "chamada-individual.php",
                type: 'POST',
                dataType: 'html',
                data: {'presente': $(this).val(), 'status': 0}
            }).done(function (data) {
                if (data === "") {
                    window.location.href = "conteudo";
                    return;
                }
                $('#info-aluno').html(data);
                gifLoaded();
                $('.esq').removeClass('disabled');
                i++;
                if (i === cont) {
                    $('.dir').addClass('disabled');
                }

            });
        });
        function gifLoad() {

            $(".btn").addClass("disabled");
            $("#info-aluno").html("<div style='min-height: 243px; text-align: center; margin: 0px auto; min-width: 50%;'><img src='layout/img/loading.gif'class='img-thumbnail img-responsive' style='max-height: 243px !important; margin-top:100px;' /></div>");
        }
        function gifLoaded() {
            $(".btn").removeClass("disabled");
        }     

    });
    

</script>
<div class="container">
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8 text-center">
           
            <div id="info-aluno"><?php include 'layout/grid/info-aluno.grid.php'; ?></div>
            <br />
            <button class="btn btn-danger btn-lg A" type="button" name="situacao" value="A">Ausente <i class="glyphicon glyphicon-remove"></i></button>
            <button class="btn btn-success btn-lg P" type="button" name="situacao" value="P">Presente <i class="glyphicon glyphicon-ok"></i></button>

            <br /><br />
            <button class="btn btn-default btn-lg esq" type="button" name="esq" value="esq"><i class="glyphicon glyphicon-chevron-left"></i></button>
            <button class="btn btn-default btn-lg dir" type="button" name="dir" value="dir"><i class="glyphicon glyphicon-chevron-right"></i></button>
         <h4>Chamada para a turma <strong><?php echo $turma->getTurma(); ?></strong> com <strong><?php echo count($turma->getHorarios()); ?></strong> aulas para o dia de hoje.</h4>

        </div>
        <div class="col-lg-2"></div>
    </div>
</div>
<script>
    $(function () {
        if (i === 0) {
            $('.esq').addClass('disabled');
        }
        if (i === cont) {
            $('.dir').addClass('disabled');

        }
    });
</script>