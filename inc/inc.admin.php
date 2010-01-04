<?php
/*
 t3CMS:inc.admin.php
 Administration includes
 TODO: Security!
*/

 include_once('inc/inc.session.php');
 include_once('inc/inc.settings.php');
 include_once('inc/inc.db.php');
 include_once('inc/inc.error.php');
 #include_once('inc/inc.build-functions.php');
 #include_once('inc/inc.page.php');
 
 #include_once('inc/inc.debug.php');

 
 function a_do_pages($sub = '_', $lvl = 0){
    global $_DB;
    foreach ($_DB->query("SELECT * FROM pages where sub='$sub';") as $r){
        $spacing = str_repeat('&rarr;&nbsp;&nbsp;',$lvl);
        print "   <a href=\"?edit=page&page={$r['name']}\">$spacing{$r['title']}</a>\n";
        a_do_pages($r['name'], $lvl+1);
    }
 }
 
 function a_do_tabs($page,$sel){
    global $a_ext_tabs;
    $tabarray['content'] = array('Content');
    $tabarray['settings'] = array('Settings');
    foreach($a_ext_tabs as $etident => $ettitle) $tabarray[$etident] = $ettitle;
    $r = '';
    foreach($tabarray as $tabident => $tabdata){
        $active = $tabident==$sel?' tabactive':'';
        $r .= "        <a href=\"?edit=page&page=$page&tab=$tabident\" class=\"edittab$active\">{$tabdata[0]}</a>\n";
    }
    return $r;
 }
 
 function a_do_menus(){
    global $_DB;
	$a = array();
    foreach ($_DB->query("SELECT * FROM menus") as $r){
		if (! in_array($r['menu'],$a)){
			print "   <a href=\"?edit=menu&menu={$r['menu']}\">Menu #{$r['menu']}</a>\n";
			$a[] = $r['menu'];
		}
    }
 }
 
 function a_do_custom_tab($tab){
    global $a_ext_tabs;
    print "      <div id=\"settings\" class=\"tabcontainer\">\n";
    print "       <h3>{$a_ext_tabs[$tab][0]}</h3>\n";
    print "      </div>\n";
 }
 
  function a_get_page_type(){ // Light version made for admin-pages, TODO: Move this?
    $page=$_GET['page'];
    if (!$page) return 0;
    $pagedata = db_page($page);
    return $pagedata['type'];
 }
 
 function a_save_and_redir(){
    $type = $_GET['save'];
    $red  = base64_decode($_GET['red']);
    $red==''?$red='?':0;
    $err  = '';
    switch($type){
        case('page'):
            $page = $_GET['page'];
            $updates = array('content'=>$_POST['content']);
            db_update('pages',$page,$updates);
            break;
        case('menu'):
            $err = '&errorid='.E_NOT_IMPLEMENTED;
            break;
        default:
            $err = '&errorid='.E_UNKNOWN_SAVE;
            break;
        }
    header('Location: '.$red.$err);
 }
 
 function a_do_edit_page($page,$tab){
    global $_DB;
    $tab=$tab?$tab:'content';
	$r = db_page($page);
    $red = base64_encode("?edit=page&page=$page");
    $content = htmlentities($r['content']);
	print <<<END
    <form style="display:block;height:100%;margin:0px;padding:0px;" action="?save=page&page=$page&red=$red" method="post">
     <table style="height:100%;padding-top:6px" width="100%" height="100%">
      <tr>
       <td height="14"><h3 style="margin:0px;display:inline;margin-left:10px">{$r['title']}&nbsp;</h3>

END;
    print a_do_tabs($page,$tab);
    print <<<END
       </td>
       <td style="text-align:right;padding-right:10px;height:30px">
        <a href="javascript:deletePage()" class="butlink butdanger">Delete page</a>
        <a href="javascript:document.forms[0].submit()" class="butlink">Save changes</a>
       </td>
      </tr>
      <tr>
       <td colspan="3" style="padding:10px;padding-top:0px">

END;
    if($tab == 'settings'){
        print "        <div id=\"settings\" class=\"tabcontainer\"><h3>Nothing here yet...</h3></div>\n";
    }
    elseif($tab == 'content') {
        print "        <textarea id=\"content\" name=\"content\">$content</textarea>\n";
    }
    else a_do_custom_tab($tab);
    print <<<END
       </td>
      </tr>
     </table>
    </form>

END;
 }
?>
