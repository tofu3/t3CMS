<?php

function a_do_edit_page($page,$tab){
    global $_DB;
    global $a_new_page;
    $tab=$tab?$tab:'content';
    if($a_new_page){
        $title = 'New page';
    }
    else{
        $r = db_page($page);
        $title = htmlentities($r['title']);
    }
    $red = base64_encode("?edit=page&page=$page&tab=$tab");
	print <<<END
     <table style="height:100%;padding-top:6px" width="100%" height="100%">
      <tr>
       <td id="ped_tabshead"><h3 style="margin:0px;display:inline;margin-left:10px">$title&nbsp;</h3>

END;
    print a_do_tabs($page,$tab);
    print <<<END
       </td>
       <td style="text-align:right;padding-right:10px;height:30px">
        <a href="javascript:deletePage('$page','$title')" class="butlink butdanger">Delete page</a>
        <a href="javascript:document.forms[0].submit()" class="butlink">Save changes</a>
       </td>
      </tr>
      <tr>
       <td colspan="3" style="padding:10px;padding-top:0px">

END;
    if($tab == 'settings'){
        print "        <div id=\"settings\" class=\"tabcontainer\"><h3>Nothing here yet...</h3></div>\n";
    }
    elseif($tab == 'add') {
        print <<<END
       <form style="display:block;height:100%;margin:0px;padding:0px;" action="?save=page&page=$page&tab=$tab&red=$red" method="post">
        <div id="add" class="tabcontainer">
         <h3>Add a new page</h3>
        <table>
         <tr>
          <td align="right">Page Title:</td>
          <td><input name="_newp_title" id="_title" onchange="title2name()" class="bigtext" /></td>
          <td><a class="help_img" href="javascript:showhelp('new_page_title')"><img src="img/help-browser32.png" alt="?" /></a></td>
         </tr>
         <tr>
          <td align="right">Page Name:</td>
          <td><input name="_newp_name" id="_name" onchange="title2name()" class="bigtext" /></td>
          <td><a class="help_img" href="javascript:showhelp('new_page_name')"><img src="img/help-browser32.png" alt="?" /></a></td>
         </tr>
         <tr>
          <td align="right">Page Type:</td>
          <td>
           <select name="_newp_type" class="bigtext">
            <option value="html">HTML</option>
            <option value="guestbook">Guestbook</option>
            <option value="news">News</option>
           </select>
          </td>
          <td><a class="help_img" href="javascript:showhelp('new_page_type')"><img src="img/help-browser32.png" alt="?" /></a></td>
         </tr>
         <tr>
          <td align="right">Create where?</td>
          <td>
           <select name="_newp_location" class="bigtext">
            <option value="_">/</option>
           </select>
          </td>
          <td><a class="help_img" href="javascript:showhelp('new_page_location')"><img src="img/help-browser32.png" alt="?" /></a></td>
         </tr>
         <tr>
          <td colspan="2" align="right" class="submit"><a class="butlink" href="javascript:title2name(); document.forms[0].submit()">Create page!</a></td>
          <td>&nbsp;</td>
         </tr>
        </table>
        </div>
       </form>
END;
    }
    elseif($tab == 'content') {
        $content = htmlentities($r['content']);
        print "       <form style=\"display:block;height:100%;margin:0px;padding:0px;\" action=\"?save=page&page=$page&tab=$tab&red=$red\" method=\"post\">\n";
        print "        <textarea id=\"content\" name=\"content\">$content</textarea>\n";
        print "       </form>\n";
    }
    else a_do_custom_tab($tab);
    print <<<END
       </td>
      </tr>
     </table>

END;
 }
 ?>