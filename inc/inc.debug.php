<?php
 function d_gap($a,$n = 'Unknown Array'){
    $s = str_replace(array(')','(','Array'),'',print_r($a,1));
    $o = '';
    $na = explode("\n",$s);
    foreach($na as $r)
        if(trim($r) != '')
            $o .= $r."\n";
        
    //return print_r($na,1);
    return $o;
 }
 
 function d_getdbasarray(){
    global $_DB;
    $d_inctables = array('settings','pt_guestbook','pages');
 
    $DBC = array();
 
    foreach ($d_inctables as $t){
        $i = 0;
        foreach ($_DB->query("SELECT * from $t") as $r){
            $i++;
                foreach($r as $n=>$v)
                    if (!is_int($n))
                        $DBC[$t][$i][$n] = $v;
        }
    }
            
    return $DBC;
 }
 
 function d_dohtml($DBC){
    global $_S;
    $ds = d_gap($_S,'Settings');
    $dp = d_gap($_POST,'POST');
    $dg = d_gap($_GET,'GET');
    $db = d_gap($DBC,'DB');
    print <<<END
<div id="debug">
    <h2><a href="#" onclick="d_toptoggle(this);return false">debug</a></h2>
    <div id="debugsub">
        <a href="#" onclick="d_toggle('Settings',this);return false">[+] settings</a>
        <div class="varlist" id="dvlSettings"><pre>$ds</pre></div>
        <a href="#" onclick="d_toggle('Post',this);return false">[+] <b>POST</b></a>
        <div class="varlist" id="dvlPost"><pre>$dp</pre></div>
        <a href="#" onclick="d_toggle('Get',this);return false">[+] <b>GET</b></a>
        <div class="varlist" id="dvlGet"><pre>$dg</pre></div>
        <a href="#" onclick="d_toggle('Db',this);return false">[+] <b>db</b></a>
        <div class="varlist" id="dvlDb"><pre>$db</pre></div>
    </div>
</div>
END;
 }
 
?>
