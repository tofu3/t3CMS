<?php
/*
 t3CMS:inc.page.php
 Page inclusion handling.
 TODO:
*/
 include_once('inc/inc.db.php');

 function get_page($override = 0){
    if(!$override){
        $default = db_setting('default_page');
        @$page=$_GET['page']?$_GET['page']:$default;
    }
    else {
        $page = $override;
    }
    $pagedata = db_page($page);
    return array($pagedata['title'],$pagedata['type'],$pagedata['content'],$page,$pagedata['id'],$pagedata['sub']);
 }
 
 function get_subpages($id){
    $sp = db_subpages($id);
        if(!$sp) return 0;
    foreach($sp as $r)
        $o[] = array($r['title'],$r['name']);
    return $o;
 }
?>
