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
    
    if((!isset($_POST['targetId'])) || (!isset($_POST['targetTable'])) || (!isset($_POST['targetStatusField'])) || (!isset($_POST['targetIdField']))){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    if((trim($_POST['targetId']) == '') || (trim($_POST['targetTable']) == '') || (trim($_POST['targetStatusField']) == '') || (trim($_POST['targetIdField']) == '')){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    $targetId = ClearMySqlVariables($_POST['targetId']); 
    $targetTable = ClearMySqlVariables($_POST['targetTable']);
    $targetStatusField = ClearMySqlVariables($_POST['targetStatusField']);
    $targetIdField = ClearMySqlVariables($_POST['targetIdField']);
    
    ChangeTableDataStatus($targetId, $targetTable, $targetStatusField, $targetIdField);
    
    EventLogger('', '', 'Data status changing', '', 'targetId='.$targetId.'&targetTable='.$targetTable.'&targetStatusField='.$targetStatusField.'&targetIdField='.$targetIdField);
    
    $userHttpReferer = ClearCommonVariables($_SERVER['HTTP_REFERER']);
    
    print($userHttpReferer);
?>