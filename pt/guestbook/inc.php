<?php
/*
 t3CMS:html:inc.php
 Page type: HTML
 TODO:
*/

 $gbstyle = 'default';

 include("$type_root/styles/$gbstyle.php");

 function do_page($content, $name){
    global $_DB, $_DBp;
    global $type_root;
    print $content;

    do_gbhead();

    foreach ($_DB->query("SELECT * FROM {$_DBp}pt_guestbook WHERE pageid='$name'") as $r){
        do_gbrow($r['author'],$r['message'],$r['time'],$r['ip'],$r['location'],$r['admin']);
    }
    
    do_gbfoot();
 }
?>
