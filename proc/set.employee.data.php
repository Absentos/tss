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
    
    if((!isset($_POST['emplKey'])) || (!isset($_POST['emplFn'])) || (!isset($_POST['emplLn'])) || (!isset($_POST['emplMn'])) || (!isset($_POST['emplBd'])) || (!isset($_POST['emplPosition']))){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    if((trim($_POST['emplKey']) == '') || (trim($_POST['emplFn']) == '') || (trim($_POST['emplLn']) == '') || (trim($_POST['emplMn']) == '') || (trim($_POST['emplBd']) == '') || (trim($_POST['emplPosition']) == '')){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    $emplId = ClearMySqlVariables($_POST['emplId']);
    $emplKey = ClearMySqlVariables($_POST['emplKey']);
    $emplFn = ClearMySqlVariables($_POST['emplFn']);
    $emplLn = ClearMySqlVariables($_POST['emplLn']);
    $emplMn = ClearMySqlVariables($_POST['emplMn']);
    $emplBd = ClearMySqlVariables($_POST['emplBd']);
    $emplPosition = ClearMySqlVariables($_POST['emplPosition']);
    $emplPassport = ClearMySqlVariables($_POST['emplPassport']);
    $emplNick = ClearMySqlVariables($_POST['emplNick']);
    $emplEmail = ClearMySqlVariables($_POST['emplEmail']);
    $emplPhone = ClearMySqlVariables($_POST['emplPhone']);
    $emplAddress = ClearMySqlVariables($_POST['emplAddress']);
    $emplIm = ClearMySqlVariables($_POST['emplIm']);
    $emplSkype = ClearMySqlVariables($_POST['emplSkype']);
    $emplSite = ClearMySqlVariables($_POST['emplSite']);
    $emplComments = ClearMySqlVariables($_POST['emplComments']);
    
    SetEmployeeData($emplId, $emplKey, $emplFn, $emplLn, $emplMn, $emplBd, $emplPosition, $emplPassport, $emplNick, $emplEmail, $emplPhone, $emplAddress, $emplIm, $emplSkype, $emplSite, $emplComments);
    
    EventLogger('', '', 'Employee data setting', '', 'emplId='.$emplId);
    
    $userHttpReferer = ClearCommonVariables($_SERVER['HTTP_REFERER']);
    
    print($userHttpReferer);
?>