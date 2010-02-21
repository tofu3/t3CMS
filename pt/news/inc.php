<?php
/*
 t3CMS:pt:inc.php
 Page type: News
 TODO:
*/

 $gbstyle = 'default';

 include("$type_root/styles/$gbstyle.php");

 function do_page($content, $name){
    global $_DB,$_DBp;
    global $type_root;
    print $content;

    pt_do_head();

    foreach ($_DB->query("SELECT * FROM {$_DBp}pt_news_data WHERE pageid='$name'") as $r){
        pt_do_newsitem($r['author'],$r['content'],$r['time'],$r['ip'],$r['location'],$r['admin']);
    }
    
    pt_do_foot();
 }
?>
