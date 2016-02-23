<?php
include_once './include/autoload.include.php';
include_once 'uri.php';
$operador = isset($_SESSION['operador']) ? unserialize($_SESSION['operador']) : new usuario();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Cache-Control" content="no-store" />

        <title><?php echo isset($title) ? $title : 'Chamada | FACENS - Faculdade de Engenharia de Sorocaba' ?></title>
        <link rel="icon" type="image/png" href="<?php echo _URI_ ?>/layout/img/favicon.ico">

        <!--Estilos da pagina-->
        <link rel="stylesheet" type="text/css" href="<?php echo _URI_ ?>/layout/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="<?php echo _URI_ ?>/layout/bootstrap/css/bootstrap-datatable.css">

        <link rel="stylesheet" type="text/css" href="<?php echo _URI_ ?>/layout/bootstrap/css/bootstrap-datepicker3.min.css">



        <!--Scripts da pagina-->
        <script type="text/javascript" src="<?php echo _URI_ ?>/layout/js/jquery-1.11.2.js"></script>
        <script type="text/javascript" src="<?php echo _URI_ ?>/layout/js/jquery.maskedinput.js"></script>
        <script type="text/javascript" src="<?php echo _URI_ ?>/layout/js/jquery.datatables.min.js"></script>
        <script type="text/javascript" src="<?php echo _URI_ ?>/layout/bootstrap/js/bootstrap.js"></script>
        <script type="text/javascript" src="<?php echo _URI_ ?>/layout/bootstrap/js/bootstrap-datatable.js"></script>
        <script type="text/javascript" src="<?php echo _URI_ ?>/layout/js/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript" src="<?php echo _URI_ ?>/layout/bootstrap/locales/bootstrap-datepicker.pt-BR.min.js"></script>

        <!-- calendario -->
        <link rel="stylesheet" type="text/css" href="./layout/css/calendar.css" />
        <link rel="stylesheet" type="text/css" href="./layout/css/custom_2.css" />
        <script src="./layout/js/modernizr.custom.63321.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo _URI_ ?>/layout/css/mestre.css">

    </head>
    <body class="body">
        <!-- Part 1: Wrap all page content here -->
        <div id="wrap">
            <!-- Fixed navbar -->
            <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid">
                    <!--Brand and toggle get grouped for better mobile display--> 
                    <div class="navbar-header">
                        <a class="navbar-brand" href="<?php echo _URI_ ?>/">Chamada - Facens</a>
                        <?php if ($operador->getLogin() != ''): ?>
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Menu</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        <?php endif; ?>
                    </div>

                    <!--Collect the nav links, forms, and other content for toggling--> 
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            <?php if ($operador->getTipo() == 2): ?>
                                <li><a href="<?php echo _URI_ ?>/">Turmas</a></li>
                                <li><a href="<?php echo _URI_ ?>/aluno">Alunos</a></li>
                                <li><a href="<?php echo _URI_ ?>/seleciona-diario-unico">Diário</a></li>
                                <?php
                            endif;

                            if ($operador->getTipo() == 0 || $operador->getTipo() == 1):
                                ?>
                                <li><a href="<?php echo _URI_ ?>/">Turmas</a></li>
                                <li><a href="<?php echo _URI_ ?>/aluno">Alunos</a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Diário</a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="<?php echo _URI_ ?>/seleciona-diario-unico"><i class="glyphicon glyphicon-education"></i> Professor</a></li>
                                        <li class="divider"></li>
                                        <li><a href="<?php echo _URI_ ?>/controle-diario"><i class="glyphicon glyphicon-pushpin"></i> Controle de Entrega</a></li>
                                        <li><a href="<?php echo _URI_ ?>/relatorio-entregas"><i class="glyphicon glyphicon-list"></i> Relatório de Entrega</a></li>
                                        <li class="divider"></li>
                                        <li><a href="<?php echo _URI_ ?>/gerar-diario"><i class="glyphicon glyphicon-print"></i> Imprimir</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>

                            <?php if ($operador->getLogin() != ''): ?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span> <?php echo $operador->getLogin(); ?></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <?php if ($operador->getTipo() == 1): ?>
                                            <li><a href="<?php echo _URI_ ?>/usuario"><i class="glyphicon glyphicon-user"></i> Usuários</a></li>
                                            <?php
                                        endif;
                                        if ($operador->getTipo() == 0 || $operador->getTipo() == 1):
                                            ?>
                                            <li><a href="<?php echo _URI_ ?>/feriados"><i class="glyphicon glyphicon-sunglasses"></i> Feriados</a></li>
                                            <li><a href="<?php echo _URI_ ?>/disciplina"><i class="glyphicon glyphicon-list"></i> Disciplinas</a></li>
                                            <li><a href="<?php echo _URI_ ?>/horario"><i class="glyphicon glyphicon-time"></i> Horários</a></li>
                                            <li><a href="<?php echo _URI_ ?>/professor"><i class="glyphicon glyphicon-education"></i> Professores</a></li>
                                            <li><a href="<?php echo _URI_ ?>/turma"><i class="glyphicon glyphicon-book"></i> Turmas</a></li>
                                            <li><a href="<?php echo _URI_ ?>/curso"><i class="glyphicon glyphicon-object-align-right"></i> Cursos</a></li>
                                            <li><a href="<?php echo _URI_ ?>/vwaluno"><i class="glyphicon glyphicon-sort-by-alphabet"></i> Alunos</a></li>
                                            <li><a href="<?php echo _URI_ ?>/alunocurso"><i class="glyphicon glyphicon-sort-by-attributes"></i> Aluno curso</a></li>
                                            <li><a href="<?php echo _URI_ ?>/alunoturma"><i class="glyphicon glyphicon-link"></i> Aluno turma</a></li>
                                            <li><a href="<?php echo _URI_ ?>/horaturma"><i class="glyphicon glyphicon-tags"></i> Hora turma</a></li>
                                            <li class="divider"></li>
                                        <?php endif; ?>
                                        <li><a href="<?php echo _URI_ ?>/login?out"><i class="glyphicon glyphicon-off"></i> Sair</a></li>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div> <!--.navbar-collapse -->
                </div> <!-- .container-fluid -->
            </nav>
            <!-- Begin page content -->
            <!--<div class="container">-->
            <div id="corpo">
                <?php echo isset($corpo) ? $corpo : ''; ?>
                <?php if (isset($mensagem)): ?>
                    <br>
                    <div class="container-fluid">
                        <div align="center" class="alert alert-info"><?php echo $mensagem; ?></div>
                    </div>
                <?php elseif (isset($mensagem_error)): ?>
                    <br>
                    <div class="container-fluid">
                        <div align="center" class="alert alert-danger"><?php echo $mensagem_error; ?></div>
                    </div>
                <?php endif; ?>
            </div>
            <!--</div>-->
            <div id="push"></div>
        </div>
        <!--
                <div id="footer">
                    <div class="container">
                        <div id="rodape">
                            FACENS - Faculdade de Engenharia de Sorocaba<br />
                            &copy <?php // echo date('Y')    ?>
                        </div>
                    </div>
                </div>
        -->
    </body>
</html>
