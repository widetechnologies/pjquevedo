<?php

//includes
include_once './include/session.include.php';
include_once './include/classes.include.php';

//objetos


ob_start();


//metas
$title = 'Erro 500 - Erro no Servidor | Wide Technologies';
$description = 'Ops, temos um erro no servidor, isso é mal, muito mal!';
$keywords = 'criar sites, sorocaba, web design, SEO, mobile, google analitycs, links patrocinados, widetec, wide Technologies';

include './layout/page/error/500.page.php';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
