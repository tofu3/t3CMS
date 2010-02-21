  <table id="tcont" border="0" cellspacing="0" cellpadding="0">
   <tr>
    <td rowspan="4" id="tleft"><div id="shadow"></div></td>
    <td id="thead"><h1><?=$title.': '.$page_title?></h1></td>
    <td rowspan="4" id="tright"><div id="shadow"></div></td>
   </tr>
   <tr>
    <td id="tmenu"><div><?php do_menu(0) ?></div></td>
   </tr>
   <tr>
    <td>
     <table cellspacing="0" cellpadding="0" style="width:100%;height:100%">
      <tr>
<?php do_submenu() ?>
       <td id="tmain">
