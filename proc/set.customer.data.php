<?php
/**
 * @author Sergey Shimkiv
 * @copyright 2011
 */
    
    @session_start();
    
    require_once '../inc/melkov.core.php';
    require_once '../inc/db.connect.inc.php';
    
    if(isset($_COOKIE['userLanguage']))
    {
        $userLanguage = ClearCommonVariables($_COOKIE['userLanguage']);
    }
    else
    {
        $userLanguage = 'ru';
    }
    
    if($userLanguage == 'ru')
    {
        require_once('../inc/melkov.lang.ru.php');
    }
    else
    {
        require_once('../inc/melkov.lang.ua.php');
    }
    
    if((!isset($_POST['custKey'])) || (!isset($_POST['custFn'])) || (!isset($_POST['custLn'])) || (!isset($_POST['custMn'])) || (!isset($_POST['custAuto']))){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    if((trim($_POST['custKey']) == '') || (trim($_POST['custFn']) == '') || (trim($_POST['custLn']) == '') || (trim($_POST['custMn']) == '') || (trim($_POST['custAuto']) == '')){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    $custId = ClearMySqlVariables($_POST['custId']);
    $custKey = ClearMySqlVariables($_POST['custKey']);
    $custFn = ClearMySqlVariables($_POST['custFn']);
    $custLn = ClearMySqlVariables($_POST['custLn']);
    $custMn = ClearMySqlVariables($_POST['custMn']);
    $custDebt = ClearMySqlVariables($_POST['custDebt']);
    $custNick = ClearMySqlVariables($_POST['custNick']);
    $custEmail = ClearMySqlVariables($_POST['custEmail']);
    $custPhone = ClearMySqlVariables($_POST['custPhone']);
    $custAddress = ClearMySqlVariables($_POST['custAddress']);
    $custIm = ClearMySqlVariables($_POST['custIm']);
    $custSkype = ClearMySqlVariables($_POST['custSkype']);
    $custSite = ClearMySqlVariables($_POST['custSite']);
    $custComments = ClearMySqlVariables($_POST['custComments']);
    $custAuto = ClearMySqlVariables($_POST['custAuto']);
    
    SetCustomerData($custId, $custKey, $custFn, $custLn, $custMn, $custDebt, $custNick, $custEmail, $custPhone, $custAddress, $custIm, $custSkype, $custSite, $custComments, $custAuto);
    
    EventLogger('', '', 'Customer data setting', '', 'custId='.$custId);
    
    $userHttpReferer = ClearCommonVariables($_SERVER['HTTP_REFERER']);
    
    print($userHttpReferer);
?>