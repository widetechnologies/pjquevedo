<?php

//includes
include_once './include/session.include.php';
include_once './include/classes.include.php';

//objetos


ob_start();


//metas
$title = 'Erro 404 - Página Não encontrada | Wide Technologies';
$description = 'Ops, a página que você procura não foi encontrada';
$keywords = 'criar sites, sorocaba, web design, SEO, mobile, google analitycs, links patrocinados, widetec, wide Technologies';

include './layout/page/error/404.page.php';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
