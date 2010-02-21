<?php
/*
 t3CMS:inc.build-functions.php
 Functions for building HTML out of data
 TODO:
*/


 function do_menu($id,$orient = 'vertical'){
    global $_DB,$_DBp;
    global $page_name;
    global $page_sub;
    # Menu syntax: ('Name','Type','url')
    #$menudata = array(array('Home','redir','./'),array('Guestbook','page','guestbook'));
    foreach($_DB->query("SELECT label,type,link FROM {$_DBp}menus WHERE menu='$id' ORDER BY sorting") as $r){
        $linkname = $r['link'];
        $linkname=='./'?$linkname=db_setting('default_page'):0;
        $active = ($page_name==$linkname)||($page_sub==$linkname)?1:0;
        $menudata[] = array($r['label'],$r['type'],$r['link'],$active);
    }
    $m = build_menu($menudata,$orient);
    print $m;  
 }
 
 function build_menu($data,$orient){
    global $url_style;
    foreach ($data as $item){
        $class = $item[3]?' class="active"':'';
        switch($item[1]){
            case 'page':
                if($url_style != 'pretty'){
                    $url = '?page='.$item[2];// Used when no .htaccess is present
                }
                else {
                    $url = './'.$item[2]; break;
                }
                break; 
            case 'redir': $url = $item[2]; break;
            default: $url = '#';
        }
        if($orient == 'vertical'){
            $r .= '&nbsp;<a href="'.$url.'"'.$class.'>'.$item[0].'</a>&nbsp;';
        }
        else {
            $r .= '<a href="'.$url.'"'.$class.'>'.$item[0].'</a><br/>';
        }
    }
    return $r;
 }

 function do_submenu($orient = 'vertical'){
    global $_DB;
    global $page_name;
    global $page_sub;
    global $page_id;
    
    $sub=$page_sub=='_'?$page_name:$page_sub;
    $subpages = db_subpages($sub);
    
    if(!count($subpages)) return;
    
    # Menu syntax: ('Name','Type','url','active')
    foreach($subpages as $r){
        $active = $page_name==$r[1]?1:0;
        $menudata[] = array($r['title'],$r['name'],$active);
    }
    $m = build_submenu($menudata,$orient,$sub);
    print $m; 
 }

 function build_submenu($data,$orient,$top){
    $title = db_titlefromname($top);
    $r = <<<END
      <td id="smenu">
      <h3><a href="?page=$top">$title</a></h3>
END;
    foreach($data as $subpage){
        $class = $subpage[2]?' class="active"':'';
        $r .= "   <a href=\"?page={$subpage[1]}\"$class>{$subpage[0]}</a>";
    }
    $r .= ' </td>';
    return $r;
 }

?>
