<?php
/*
 t3CMS:pt:inc.admin.php
 Administration page type includes
 TODO: Tab support, fix file layout designs
*/
    include('def.db.php');

    // Custom  tabs used by PageType
    $a_ext_tabs = array(
        'music' => array('Music','pt_music_settings')
    );
    
    // Database tables used by PageType
    $a_ext_dbs = array( // Move to def.db.php ?
        array('pt_music_settings', $db_pt_music_settings),
        array('pt_music_data',     $db_pt_music_data)
    );
?>