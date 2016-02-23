<!--<script>

    $(function () {
        load();
    });

    function load() {

        $('.table').dataTable({
            "language": {
                "url": "layout/js/datatable.portugues.lang"
            }
        });
    }

</script>-->
<div class="container">
    <div class="page-header text-center">
        <h1><i class="glyphicon glyphicon-sunglasses"></i> Feriados | Dias sem aula</h1>
        <p>Dias em que não haverão aulas</p>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <form method="POST">
                <div class="form-group text-center">
                    <div>
                        <div id="datepicker" style="width: 230px; height: auto; margin: 0px auto;  background-color: white; border-radius: 5px;"></div>
                    </div>
                    <input type="hidden" id="my_hidden_input" required value="" name="calendario" />

                    <script>
                        $('#datepicker').datepicker({
                            format: 'yyyy-mm-dd',
                            language: "pt-BR",
                            daysOfWeekDisabled: "0",
                            todayHighlight: false,
                            datesDisabled: <?php echo json_encode($feriadosValidos); ?>
                        });

                        $("#datepicker").on("changeDate", function (event) {
                            $("#my_hidden_input").val(
                                    $("#datepicker").datepicker('getFormattedDate')
                                    );
                        });
                    </script>
                </div>
                <div class="text-center">
                    <button class="btn btn-success" type="submit" name="submit"><i class="glyphicon glyphicon-pushpin"></i> Cadastrar feriado</button>
                </div>
            </form>
        </div>
        <div class="col-lg-8">
            <div class="table-responsive">
                <form method="POST">
                    <table class="table table-striped table-condensed">
                        <thead>
                            <tr>
                                <th class="col-sm-1 text-center">Nº</th>
                                <th>Data</th>
                                <th class="col-sm-1 text-center">Excluir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cont = 0;
                            foreach ($feriados as $feriadoItem):
                                $cont++;
                                ?>
                                <tr>
                                    <td class="col-sm-1 text-center"><?php echo $cont; ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($feriadoItem->getData())); ?></td>
                                    <td class="col-sm-1 text-center"><button type="submit" class="btn-link" value="<?php echo $feriadoItem->getId_feriado(); ?>" name="excluir"><i class="glyphicon glyphicon-remove"></i></button></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>

</div>
