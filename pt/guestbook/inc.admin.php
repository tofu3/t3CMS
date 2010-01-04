<?php
/*
 t3CMS:pt:inc.admin.php
 Administration page type includes
 TODO: Tab support, fix file layout designs
*/
    include('def.db.php');

    $a_ext_tabs = array(
        'guestbook' => array('Guestbook','pt_guestbook_settings')
    );
    
    $a_ext_dbs = array( // Move to def.db.php ?
        array('pt_guestbook_settings', $db_pt_guestbook_settings),
        array('pt_guestbook_data',     $db_pt_guestbook_data)
    );
?>