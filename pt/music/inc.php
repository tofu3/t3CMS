<?php
/*
 t3CMS:html:inc.php
 Page type: HTML
 TODO:
*/

 $pt_musicstyle = 'default';

 include("$type_root/styles/$pt_musicstyle.php");

 function do_page($content, $name){
    global $_DB,$_DBp;
    global $type_root;
    print $content;

    do_musichead();

    foreach ($_DB->query("SELECT * FROM {$_DBp}pt_music_data WHERE pageid='$name'") as $r){
        $lyrics = $r['lyrics']?' (<a href=\"lyrics/'.$r['id'].'\">lyrics</a>)':'';
        $containers[$r['container']][] = array($r['title'],$r['url'],$lyrics);
        //do_musicrow($r['title'],$r['url'],$r['']);
    }
    
    foreach ($containers as $container=>$data){
        print "<h3 class=\"musiccontainer\" style=\"margin:0px;margin-top:16px;margin-bottom:4px;border-bottom:2px solid black\">$container</h3>";
        foreach($data as $row){
            $url = $row[1];
            $lyrics = $row[2];
            $title = htmlentities(utf8_decode($row[0])); /*FIXME! Deal with encoding in output/database */
            print "<a href=\"$url\">$title</a>$lyrics<br/>";
        }
    }
    
    do_musicfoot();
 }
?>
