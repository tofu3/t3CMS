<?php
/*
 t3CMS:admin.php
 Administration main page
 TODO: Security!
*/


// TODO: Add login functions
 
 include_once("inc/inc.admin.php");
 if($_GET['save']){
    // Save data in POST and redirect browser
    die(a_save_and_redir());
 }
  if($_GET['delete']){
    // Save data in POST and redirect browser
    die(a_delete_and_redir());
 }
 
 
 $a_edit_new = $_GET['page']=='_new'?True:False;
 if($a_edit_new){
  $_GET['page'] = '';
  $page = array('type'=>'');
 }
 else {
  $page_type=a_get_page_type();
  if($page_type){
    $type_root = "pt/$page_type";
    include("pt/$page_type/inc.admin.php");
  }
 }

?>
<html>
 <head>
  <link rel="stylesheet" href="etc/admin.css" type="text/css" /> 
  <script src="js/tiny_mce/tiny_mce.js"></script>
  <script src="js/base64.js"></script>
  <script src="js/admin.js"></script>
  <title>t3CMS: Administration Panel</title>
 </head>
 <body onload="init_mce('full')">
<?php print_error() ?>
  <table id="tcont" cellspacing="0" border="0">
   <tr>
    <td id="thead" colspan="2">
     <table style="width:100%;height:100%;" cellspacing="0" cellpadding="0">
      <tr>
       <td style="vertical-align:bottom"><h1>t3CMS: Administration Panel</h1><h2>v0.1.0.257 (alpha release)</h2></td>
       <td width="140" style="vertical-align:middle;"><a href="." class="butlink" style="margin-right:16px">View page &rarr;</a></td>
      </tr>
     </table>
    </td>
   </tr>
   <tr>
    <td id="tmenu">
     <div>
      <b>pages</b>
<?php a_do_pages() ?>
      <a class="add" href="?edit=page&page=_new&tab=add">+ Add page&nbsp;</a>
      <b>menus</b>
<?php a_do_menus() ?>
      <a class="add" href="?edit=menu&menu=_new&tab=add">+ Add menu&nbsp;</a>
      <b>settings</b>
      <a href="?edit=setting&setting=appearence">appearence</a>
      <a href="?edit=setting&setting=users">users</a>
      <a href="?edit=setting&setting=database">database</a>
      <a href="?edit=setting&setting=appearence">media</a>
      <b class="end">&nbsp;</b>
      <b>etc</b>
      <a href="?special=database">database</a>
      <a href="?special=filebrowser">file browser</a>
      <b class="end">&nbsp;</b>
     </div>
    </td>
    <td id="tmain">
<?php
    switch($_GET['edit']){
        case('page'):
            include_once('inc/inc.admin-pages.php');
            a_do_edit_page($_GET['page'],$_GET['tab']);
            break;
        case('menu'):
            include_once('inc/inc.admin-menus.php');
            a_do_edit_menu($_GET['menu']);
            break;
        default: print ''; break;
    }
?>
    </td>
   </tr>
  </table>
 </body>
</html>