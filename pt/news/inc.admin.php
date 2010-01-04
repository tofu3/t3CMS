<?php
/*
 t3CMS:pt:inc.admin.php
 Administration page type includes
 TODO: Tab support, fix file layout designs
*/
    include('def.db.php');

    $a_ext_tabs = array(
        'news_settings' => array('Display','pt_news_settings'),
        'news_data'     => array('News items','pt_news_data')
    );
    
    $a_ext_dbs = array( // Move to def.db.php ?
        array('pt_news_settings', $db_pt_news_settings),
        array('pt_news_data',     $db_pt_news_data)
    );
?>