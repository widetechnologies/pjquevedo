<script>
    $(function () {
        $('.table').DataTable({
            language: {url: 'layout/js/datatable.portugues.lang'}
        });
    });
</script>
<div class="container">
    <h1>Imprimir diários por professor</h1>
    <p>Selecione o professor para realizar a impressao do diário</p>
    <div class="table-responsive">
        <form method="POST" target="_blank">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-primary <?php echo date('m') == 1 ? 'active' : ''; ?>">
                    <input type="radio" name="options" autocomplete="off" value="1" <?php echo date('m') == 1 ? ' checked' : ''; ?>> Jan
                </label>
                <label class="btn btn-primary <?php echo date('m') == 2 ? 'active' : ''; ?>">
                    <input type="radio" name="options" autocomplete="off" value="2" <?php echo date('m') == 2 ? ' checked' : ''; ?>> Fev
                </label>
                <label class="btn btn-primary <?php echo date('m') == 3 ? 'active' : ''; ?>">
                    <input type="radio" name="options" autocomplete="off" value="3" <?php echo date('m') == 3 ? ' checked' : ''; ?>> Mar
                </label>
                <label class="btn btn-primary <?php echo date('m') == 4 ? 'active' : ''; ?>">
                    <input type="radio" name="options" autocomplete="off" value="4" <?php echo date('m') == 4 ? ' checked' : ''; ?> > Abr
                </label>
                <label class="btn btn-primary <?php echo date('m') == 5 ? 'active' : ''; ?>">
                    <input type="radio" name="options" autocomplete="off" value="5" <?php echo date('m') == 5 ? ' checked' : ''; ?>> Mai
                </label>
                <label class="btn btn-primary <?php echo date('m') == 6 ? 'active' : ''; ?>">
                    <input type="radio" name="options" autocomplete="off" value="6" <?php echo date('m') == 6 ? ' checked' : ''; ?>> Jun
                </label>
                <label class="btn btn-primary <?php echo date('m') == 7 ? 'active' : ''; ?>">
                    <input type="radio" name="options" autocomplete="off" value="7" <?php echo date('m') == 7 ? ' checked' : ''; ?> > Jul
                </label>
                <label class="btn btn-primary <?php echo date('m') == 8 ? 'active' : ''; ?>">
                    <input type="radio" name="options" autocomplete="off" value="8" <?php echo date('m') == 8 ? ' checked' : ''; ?>> Ago
                </label>
                <label class="btn btn-primary <?php echo date('m') == 9 ? 'active' : ''; ?>">
                    <input type="radio" name="options" autocomplete="off" value="9" <?php echo date('m') == 9 ? ' checked' : ''; ?>> Set
                </label>
                <label class="btn btn-primary <?php echo date('m') == 10 ? 'active' : ''; ?>">
                    <input type="radio" name="options" autocomplete="off" value="10" <?php echo date('m') == 10 ? ' checked' : ''; ?>> Out
                </label>
                <label class="btn btn-primary <?php echo date('m') == 11 ? 'active' : ''; ?>">
                    <input type="radio" name="options" autocomplete="off" value="11" <?php echo date('m') == 11 ? ' checked' : ''; ?>> Nov
                </label>
                <label class="btn btn-primary <?php echo date('m') == 12 ? 'active' : ''; ?>">
                    <input type="radio" name="options" autocomplete="off" value="12" <?php echo date('m') == 12 ? ' checked' : ''; ?>> Dez
                </label>

            </div>
            <br /><br />
            <?php include './layout/grid/gerar-diario-lista-profs.grid.php'; ?>
        </form>
    </div>

</div>