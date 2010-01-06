<?php
 $title = 'Style Tester';
 $page_title = 'Dummy Page';
 $style_root = '.';

 // Dummy functions
 function do_menu($dummy) {
    print '&nbsp;<a href="#">NonActive</a>&nbsp;'."\n";
    print '&nbsp;<a href="#" class="active">Active</a>&nbsp;'."\n";
 }
 function do_submenu() {
    print '<td id="smenu">'."\n";
    print '  <h3><a href="?page=subs">Subpages</a></h3>'."\n";
    print '<a href="#">Subpage 1</a>'."\n";
    print '<a href="#">Subpage 2</a>'."\n";
    print '</td>'."\n";
 }
?>
<html>
 <head>
<?php
 include('head.inc.php');
?>
 </head>
  <body>
<?php
 include('header.php');
 print 'Pagecontent.';
 include('footer.php');
?>
 </body>
</html>