<?php
/*
 t3CMS:index.php
 Main page
 TODO: ALOT
*/
 $_D = False;#True; // Enable debugging

 include_once('inc/inc.session.php');
 include_once('inc/inc.settings.php');
 include_once('inc/inc.db.php');
 include_once('inc/inc.build-functions.php');
 include_once('inc/inc.page.php');
 
 include_once('inc/inc.debug.php');
 
 $DBC = d_getdbasarray();

 $sel_style = db_setting('style');
 $style_root = "styles/$sel_style";
 
 list($page_title, $page_type, $page_content, $page_name, $page_id, $page_sub) = get_page();
 #$subpages = get_subpages($page_name);
 $type_root = "pt/$page_type";
 include("pt/$page_type/inc.php");
 
 $title = db_setting('title');

?>
<html>
 <head>
  <title><?=$title.': '.$page_title?></title>
<?php if($_D){ ?>
  <link rel="stylesheet" href="etc/debug.css" type="text/css" />
  <script src="js/debug.js" language="javascript"></script>
<?php } ?>
  <style></style>
<?php @include("styles/$sel_style/head.inc.php") ?>
 </head>
 <body>
<?php if($_D) d_dohtml($DBC); /* Include debugging HTML */ ?>
<?php $_=' '; @include("$style_root/header.php") ?>
<?php
    //TODO: Include page (module)
    do_page($page_content,$page_name);
?>
<?php $_=' '; @include("styles/$sel_style/footer.php") ?>
 </body>
</html>