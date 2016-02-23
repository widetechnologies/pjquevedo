<?php

//includes
//include_once './include/session.include.php';
//include_once './include/classes.include.php';

//objetos


ob_start();


//metas
$title = 'Erro 400 - Temos Um Problema | Wide Technologies';
$description = 'Ops, temos um problema, você não é um robô?';
$keywords = 'criar sites, sorocaba, web design, SEO, mobile, google analitycs, links patrocinados, widetec, wide Technologies';

include './layout/page/error/400.page.php';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';


