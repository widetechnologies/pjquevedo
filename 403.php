<?php

//includes
include_once './include/session.include.php';
include_once './include/classes.include.php';

ob_start();

//metas
$title = 'Erro 403 - Erro de Acesso | Wide Technologies';
$description = 'Ops, a página ou pasta que você está tentando acessar não é permitida!';
$keywords = 'criar sites, sorocaba, web design, SEO, mobile, google analitycs, links patrocinados, widetec, wide Technologies';

include './layout/page/error/403.page.php';
$corpo = ob_get_clean();
include './layout/page/mestre.page.php';
