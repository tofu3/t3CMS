<?php
/*
 t3CMS:inc.db.php
 Database handling
 TODO: Security!
*/
 @include_once('settings.php');

 try {
  $_DB = new PDO($_S['dbType'].':'.$_S['dbPath']);
 }
 catch (PDOException $e) {
	print 'Database error.';
	die();
 }
 
 function db_setting($name){
    global $_DB;
    $q = $_DB->query("SELECT value FROM settings WHERE name='$name'");
    $r = $q->fetch();
    return $r[0];
 }
 
 function db_page($name) {
    global $_DB;
    $q = $_DB->query("SELECT * FROM pages WHERE name='$name'");
    $r = $q->fetch();
    return $r;
 }
 
 function db_subpages($sub){
    global $_DB;
    foreach($_DB->query("SELECT * FROM pages WHERE sub='$sub'") as $r){
        $o[] = $r;
    }
    return $o;
 }
 
 function db_titlefromname($name){
    global $_DB;
    $q = $_DB->query("SELECT title FROM pages WHERE name='$name'");
    $r = $q->fetch();
    return $r[0];
 }
 
 function db_add_page(){
    // TODO: Add this.
 }
 
 function db_delete_row($table, $conditions){
    global $_DB;
    foreach($conditions as $ident => $var){
        $constr .= "AND $ident='$var'";
    }
    $constr = substr($constr,3);
    $query = "DELETE FROM $table WHERE $constr";
    $r = $_DB->query($query);
    if(!$r){
        print _e(E_DATABASE_MISC);
        $ei = $_DB->errorInfo();
        print $ei[2]."<br/>\n";
        print_r(htmlentities($query));
        die();
    }
    return;
 }
 
 function db_new_row($table,$updates){
    global $_DB;
    foreach($updates as $ident=>$value){
        $ids .= "','".$ident;
        $vls .= "','".$value;
    }
    $ids = substr($ids,2)."'"; // Turn ','a','b','c into 'a','b','c'
    $vls = substr($vls,2)."'"; // dito
    $q = "INSERT INTO $table ($ids) VALUES ($vls)";
    $r = $_DB->query($q);
    if(!$r){
        print _e(E_DATABASE_MISC);
        $ei = $_DB->errorInfo();
        #if ($_D)
        print $ei[2]."<br/>\n";
        print_r(htmlentities($q));
        die();
    }
 }
 
  function db_get_single($query){
    global $_DB;
    $q = $_DB->query($query);
    $r = $q->fetch();
    return $r[0];
  }
  
  function db_get_single_row($query){
    global $_DB;
    $q = $_DB->query($query);
    if(!$q){
        print _e(E_DATABASE_MISC);
        $ei = $_DB->errorInfo();
        #if ($_D)
        print $ei[2]."<br/>\n";
        print_r(htmlentities($q));
        die();
    }
    $r = $q->fetch();
    return $r;
  }
   
  function db_get_rows($query){
    global $_DB;
    $q = $_DB->query($query);
    if(!$q){
        print _e(E_DATABASE_MISC);
        $ei = $_DB->errorInfo();
        #if ($_D)
        print $ei[2]."<br/>\n";
        print_r(htmlentities($q));
        die();
    }
    foreach($q->fetchall() as $v){
        $a[] = $v;
    }
    return $a;
  }
 
  function db_update($table,$name,$updates){
    global $_DB;
    foreach($updates as $ident=>$value){
        $ids .= ",$ident=?";
        $vls[] = stripslashes($value);
    }
    $ids = substr($ids,1);
    $q = "UPDATE $table SET $ids WHERE name='$name'";
    $s = $_DB->prepare($q);
    $r = $s->execute($vls);

    if(!$r){
        print _e(E_DATABASE_MISC);
        $ei = $_DB->errorInfo();
        #if ($_D)
        print $ei[2]."<br/>\n";
        print_r(htmlentities($q));
        die();
    }
  }
    
  function db_update_by_id($table,$id,$updates){
    global $_DB;
    foreach($updates as $ident=>$value){
        $ids .= ",$ident=?";
        $vls[] = stripslashes($value);
    }
    $ids = substr($ids,1);
    $q = "UPDATE $table SET $ids WHERE id='$id'";
    $s = $_DB->prepare($q);
    $r = $s->execute($vls);

    if(!$r){
        print _e(E_DATABASE_MISC);
        $ei = $_DB->errorInfo();
        #if ($_D)
        print $ei[2]."<br/>\n";
        print_r(htmlentities($q));
        die();
    }
    
 }
 
 /* SAVED FOR LATER USE, MAYHAPS
 function db_update_page($name,$updates){
    foreach($updates as $ident=>$value){
        $ids .= "','".$ident;
        $vls .= "','".$value;
    }
    $ids = substr($ids,2)."'";
    $vls = substr($vls,2)."'";
    $q = "UPDATE pages ($ids) VALUES ($vls) WHERE name='$name'";
    print $q;
 }
 */

?>
