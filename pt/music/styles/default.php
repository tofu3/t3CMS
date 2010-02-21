<?php
 function do_musichead(){
    print '<pre>';
 }
 
 function do_musicfoot(){
    print '</pre>';
 }

/*
 function do_gbhead(){
    print '<table border="0" width="100%" cellspacing="0">';
 }
 
 function do_gbrow($author,$message,$time,$ip,$location,$admin){
    $author = htmlentities($author);
    $message = htmlentities(utf8_decode($message));
    $location = htmlentities($location);
    $isadmin = $admin?' style="color:red"':'';
    print <<<END
<tr style="background: #ddd">
 <td style="text-align:left"><b$isadmin>$author</b></td>
 <td style="text-align:right">$time</td>
</tr>
<tr style="background: #fff">
 <td colspan="2">$message</td>
</tr> 
<tr><td colspan="2">&nbsp;</td></tr>
END;
 }
 
 function do_gbfoot(){
    print '</table>';
 }
*/
?>
