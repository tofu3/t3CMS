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
    $active_page = $_GET['page'];
    foreach ($_DB->query("SELECT * FROM pages where sub='$sub' ORDER BY special,id") as $r){
        $spacing = str_repeat('&rarr;&nbsp;&nbsp;',$lvl);
        $active = $active_page==$r['name']?' active':'';
        print "   <a href=\"?edit=page&page={$r['name']}\" class=\"$active\">$spacing{$r['title']}</a>\n";
        a_do_pages($r['name'], $lvl+1);
    }
 }
 
  function a_get_menu_items($menu){
    global $_DB;
    $retarr = array();
    foreach ($_DB->query("SELECT * FROM menus where menu='$menu' ORDER BY sorting") as $r){
        $retarr[] = array($r['type'],$r['label'],$r['link'],$r['id']);
    }
    return $retarr;
 }

 function a_get_nonmenu_items(){
    global $_DB;
    foreach ($_DB->query("SELECT * FROM pages where sub='_'") as $r){
        $retarr[] = array($r['name'],$r['title']);
    }
    return $retarr;
 }
 
 function a_do_tabs($page,$sel){
    global $a_ext_tabs;
    global $a_edit_new;
    if(!$a_edit_new){
        $tabarray['content'] = array('Content');
        $tabarray['settings'] = array('Settings');
    }
    else {
        $tabarray['add'] = array('Add page');
    }
    if($a_ext_tabs) foreach($a_ext_tabs as $etident => $ettitle) $tabarray[$etident] = $ettitle;
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
 
  function a_get_page_type($page = False){ // Light version made for admin-pages, TODO: Move this?
    if (!$page) $page=$_GET['page'];
    if (!$page) return 0;
    $pagedata = db_page($page);
    return $pagedata['type'];
 }
 
  function a_get_page_title($page = False){ // Light version made for admin-pages, TODO: Move this?
    if (!$page) $page=$_GET['page'];
    if (!$page) return 0;
    $pagedata = db_page($page);
    return $pagedata['title'];
 }
 
 function a_save_and_redir(){
    $type = $_GET['save'];
    $tab = $_GET['tab'];
    $sub = $_GET['sub'];
    $red  = base64_decode($_GET['red']);
    $red==''?$red='?':0;
    $err  = '';
    switch($type){
        case('page'):
            switch($tab) {
                case('content'):
                    $page = $_GET['page'];
                    $updates = array('content'=>$_POST['content']);
                    db_update('pages',$page,$updates);
                    break;
                case('add'):
                    $updates = array(
                        'name' => $_POST['_newp_name'],
                        'title' => $_POST['_newp_title'],
                        'type' => $_POST['_newp_type'],
                        'sub' => $_POST['_newp_location']
                    );
                    db_new_row('pages',$updates);
                    $page = $_POST['_newp_name'];
                    $red = "?page=$page&edit=page&tab=content";
                    break;
                default:
                    $err = '&errorid='.E_NOT_IMPLEMENTED;
                    break;
                }
            break;
        case('menu'):
            switch($sub){
                case('additem'):
                    $link = $_POST['target'];
                    $label = $_POST['label']?$_POST['label']:a_get_page_title($link);
                    $sortnum = db_get_single('SELECT sorting FROM menus ORDER BY sorting DESC')+1;
                    $updates = array(
                        'menu' => $_GET['menu'],
                        'label' => $label,
                        'type' => 'page',//$_POST['type'],
                        'link' => $link,
                        'sorting' => $sortnum
                    );
                    db_new_row('menus',$updates);
                    break;
                case('moveitem'):
                        /*
                        // Move everything right of ITEM to one step to the right
                        // Why did I even write this code?
                        $items = db_get_rows('SELECT sorting,id FROM MENUS WHERE menu='.$menu.' ORDER BY sorting DESC');
                        //print_r($items);
                        foreach($items as $itemArr){
                            if ($itemArr['sorting'] < $currentsort) continue;
                            $newsort = $itemArr['sorting']+1;
                            //print 'Updating id'.$itemArr['id'].' sorting '.$itemArr['sorting'].'->'.$newsort.'<br/>';
                            db_update_by_id('menus',$itemArr['id'],array('sorting'=>$newsort));
                        }
                        */
                    $item = $_GET['item'];
                    $menu = $_GET['menu'];
                    $dir  = $_GET['dir'];
                    $oldsort = db_get_single('SELECT sorting FROM menus WHERE id='.$item);
                    $q=$dir==1?"SELECT id,sorting FROM menus WHERE sorting>$oldsort ORDER BY sorting LIMIT 1":"SELECT id,sorting FROM menus WHERE sorting<$oldsort ORDER BY sorting DESC";
                        list($ngbr,$newsort) = db_get_single_row($q);
                        // Set ITEM sorting to new sorting value
                        db_update_by_id('menus', $item, array('sorting'=>$newsort));
                        
                        // Set ITEM neighbour sorting to new sorting value
                        db_update_by_id('menus', $ngbr, array('sorting'=>$oldsort));
                    break;
                default:
                    $err = '&errorid='.E_NOT_IMPLEMENTED;
                    break;
                }
            break;
        default:
            $err = '&errorid='.E_UNKNOWN_SAVE;
            break;
        }
    header('Location: '.$red.$err);
 }
 
 function a_delete_and_redir(){
    $type = $_GET['delete'];
    $tab = $_GET['tab'];
    $sub = $_GET['sub'];
    $page = $_GET['page'];
    $item = $_GET['item'];
    $red  = base64_decode($_GET['red']);
    $red==''?$red='?':0;
    $err  = '';
    switch($type){
        case('page'):
            db_delete_row('pages',array('name'=>$page));
            break;
        case('menu'):
            $err = '&errorid='.E_NOT_IMPLEMENTED;
            break;
        case('menuitem'):
            // Remove from $var1 where $var2Ident = $var2Var
            db_delete_row('menus',array('id'=>$item));
            break;
        default:
            $err = '&errorid='.E_UNKNOWN_SAVE;
            break;
        }
    header('Location: '.$red.$err);
 }
 
 
 
?>
