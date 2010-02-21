<?php
 if(($_GET['cache'] != 0) and db_setting('cache_enabled')){
  include_once('lib/skycache/skycache.php');
  skycache_set_cache_dir('F:\www\ath.cx\tofu3\t3cms\__dev\cache');
  skycache_set_expiry(db_setting('cache_expiry'));
  skycache();
 }
?>