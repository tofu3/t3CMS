<?php
/*
 t3CMS:inc.error.php
 Error handling
 TODO: Add more error messages. Improve display.
*/

    $_ER = array();
    $_ELS = array();
    $__EL_I = 0;
    
    function add_error($n,$s,$l = 0){
        global $_ER;
        $_ER[] = array($s,$l);
        define($n,count($_ER)-1);
    }
    
    function add_error_level($n){
        global $__EL_I;
        define($n,$__EL_I);
        $__EL_I++;
    }
    
    function _e($id){
        if ($id == '') return '';
        global $_ER;
        global $_ELS;
        $o = $_ER[$id][0];
        $o .= '<br/>'.$_ELS[$_ER[$id][1]];
        return '<div id="error">'.$o.'</div>';
    }
    
    function print_error(){
        print _e($_GET['errorid']);
    }

    add_error_level('EL_UNKOWN');
    add_error_level('EL_CODE_FATAL');
    add_error_level('EL_CODE_NONFATAL');
    add_error_level('EL_CONFIG_FATAL');
    add_error_level('EL_CONFIG_NONFATAL');
    add_error_level('EL_USER_FATAL');
    add_error_level('EL_USER_NONFATAL');
    
    add_error('E_UNKNOWN','Unknown error.', EL_CODE_FATAL);
    add_error('E_UNKNOWN_SAVE','Unknown save option.', EL_CODE_NONFATAL);
    add_error('E_DATABASE_MISC','Database issues. Please try again later.', EL_CONFIG_FATAL);
    add_error('E_NOT_IMPLEMENTED','What you are trying to do is not supported yet.', EL_CODE_FATAL);
    
    $_ELS[EL_CODE_FATAL]    = 'Coding error. Contact <a href="javascript:void(0)">t3CMS support</a>. (Fatal)';
    $_ELS[EL_CODE_NONFATAL] = 'Coding error. Contact <a href="javascript:void(0)">t3CMS support</a>. (Non-fatal)';
?>