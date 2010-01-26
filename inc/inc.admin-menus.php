<?php

 function a_do_edit_menu($menu){
    global $_DB;
    $a_new_menu = $_GET['menu']=='_new'?True:False;
    #$tab=$tab?$tab:'content';
    $red = base64_encode("?edit=menu&menu=$menu");
    
    if($a_new_menu){
        print "        <div id=\"settings\" class=\"tabcontainer\"><h3>Sorry - You cannot add more menus for now.</h3></div>\n";
    }
    else{

	print <<<END
    <form style="display:block;height:100%;margin:0px;padding:0px;" action="?save=menu&menu=$menu&sub=additem&red=$red" method="post">
     <table style="height:100%;padding-top:6px" width="100%" height="100%">
      <tr>
       <td height="14">
        <h3 style="margin:0px;display:inline;margin-left:10px">Edit menu</h3>
       </td>
       <td style="text-align:right;padding-right:10px;height:30px">
        <a href="javascript:deleteMenu()" class="butlink butdanger">Delete menu</a>
        <a href="javascript:document.forms[0].submit()" class="butlink">Save changes</a>
       </td>
      </tr>
      <tr>
       <td colspan="3" style="padding:10px;padding-top:0px">
        <div id="menu" class="tabcontainer">
         <h3>Current menu items:</h3>
END;
    $a_menu_items = a_get_menu_items($menu);
    foreach($a_menu_items as $menu_item){
        $esc_text = htmlentities($menu_item[1]);
        $miID = "mi{$menu}-{$menu_item[3]}";
        print "         <span id=\"$miID\" class=\"editMenuItem\">".
        "<a href=\"javascript:moveMenuItem($menu,{$menu_item[3]},-1)\"><img src=\"img/go-previous16.png\" alt=\"[<]\" title=\"Move left\" /></a>".
        " $esc_text ".
        "<a href=\"javascript:removeMenuItem($menu,{$menu_item[3]},'$esc_text')\"><img src=\"img/process-stop16.png\" alt=\"[x]\" title=\"Remove this item\" /></a> ".
        "<a href=\"javascript:moveMenuItem($menu,{$menu_item[3]},1)\"><img src=\"img/go-next16.png\" alt=\"[>]\" title=\"Move right\" /></a>".
        "</span>\n";
    }
print <<<END
         <h3>Add an item:</h3>
          <table>
           <tr>
            <td align="right">Add what page:</td>
            <td>
             <select name="target">
END;
    $a_page_addables = a_get_nonmenu_items();
    print_r($a_page_addables);
    foreach($a_page_addables as $a_page_addable){
        print "           <option value=\"{$a_page_addable[0]}\">{$a_page_addable[1]}</option>\n";
    }

print <<<END
             </select>
             <input type="submit" value="Add menu item" />
           </td>
          </tr>
          <tr>
           <td align="right">Menu item name:</td>
           <td><input type="text" name="label" /> (will be same as page title if left blank)</td>
          </tr>
         </table>
        </div>
       </td>
      </tr>
     </table>
    </form>

END;
 }
 }
?>