<script>
    $(function () {
        $('.opt').click(function () {           
            gifLoad();
            var x = $(this).children()[0];
            $.ajax({
                url: "seleciona-diario-unico.php",
                type: 'POST',
                dataType: 'html',
                data: {'mes': x.value}
            }).done(function (data) {
                $('#load').html(data);              
            });
        });

    });
    function gifLoad() {            
            $("#load").html("<div style='min-height: 243px; text-align: center; margin: 0px auto; min-width: 50%;'><img src='layout/img/loading.gif'class='img-thumbnail img-responsive' style='max-height: 243px !important; margin-top:100px;' /></div>");
        }
</script>
<div class="container">
    <h1><i class="glyphicon glyphicon-print text-info"></i> Imprimir diários por turma</h1>
    <div class="alert alert-dismissable alert-info fade in text-center" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4><i class="glyphicon glyphicon-info-sign"></i> Informações...</h4>
        <p>
            Selecione o mês na caixa abaixo e clique na turma que deseja imprimir o diário. <b>O mês pré-selecionado 
                é o mês anterior</b>, mas você pode mudar o mês clicando sobre o mês desejado.<br /><br />
            Para sincronizar os dados com o sistema acadêmico, clique no botão da turma que deseja. Isso fechará a turma e liberará a impressão do diário!<br />
            <b> Apenas turmas fechadas podem ter os diários impressos! Turmas já fechadas ficam com o botão em vermelho. Para abri-las novamente, clique no botão novamente.  </b>
        </p>
    </div>
    <div>
        <h3 class="text-center"><i class="glyphicon glyphicon-calendar text-info"></i> Selecione o Mês</h3>
        <form method="POST" target="_blank">
            <div class="btn-group" data-toggle="buttons">
                <?php foreach ($mesValido as $mes): ?>
                    <label class="btn btn-primary opt <?php echo (date('m')-1) == $mes ? 'active' : ''; ?>">
                        <input type="radio" name="options" id="option" class="opt2" onclick="mes(<?php echo $mes;?>)" autocomplete="off" value="<?php echo $mes; ?>" <?php echo (date('m')) == $mes ? ' checked' : ''; ?>> 
                        <?php
                        switch ($mes) {
                            case 1:
                                echo 'Jan';
                                break;
                            case 2:
                                echo 'Fev';
                                break;
                            case 3:
                                echo 'Mar';
                                break;
                            case 4:
                                echo 'Abr';
                                break;
                            case 5:
                                echo 'Mai';
                                break;
                            case 6:
                                echo 'Jun';
                                break;
                            case 7:
                                echo 'Jul';
                                break;
                            case 8:
                                echo 'Ago';
                                break;
                            case 9:
                                echo 'Set';
                                break;
                            case 10:
                                echo 'Out';
                                break;
                            case 11:
                                echo 'Nov';
                                break;
                            case 12:
                                echo 'Dez';
                                break;
                        }
                        ?>
                    </label>
                <?php endforeach; 
                $mes = $mesValido[count($mesValido)-1];
                ?>
            </div>
            <br /><br />
            <div class="row">
                <div class="col-lg-2 col-md-2"></div>
                <div class="col-lg-8 col-md-8">
                    <h3 class="text-center"><i class="glyphicon glyphicon-book text-info"></i> Selecione a Turma</h3><br />

                    <div id="load"> <?php include_once 'layout/grid/seleciona-diario-unico.grid.php'; ?></div>
                </div>
                <div class="col-lg-2 col-md-2"></div>
            </div>
        </form>
    </div>
</div>
