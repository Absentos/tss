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
    
    if((!isset($_POST['workKey'])) || (!isset($_POST['workCategory'])) || (!isset($_POST['workValue'])) || (!isset($_POST['workPrice']))){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    if((trim($_POST['workKey']) == '') || (trim($_POST['workCategory']) == '') || (trim($_POST['workValue']) == '') || (trim($_POST['workPrice']) == '')){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    $workId = ClearMySqlVariables($_POST['workId']); 
    $workKey = ClearMySqlVariables($_POST['workKey']);
    $workCategory = ClearMySqlVariables($_POST['workCategory']);
    $workValue = ClearMySqlVariables($_POST['workValue']);
    $workPrice = ClearMySqlVariables($_POST['workPrice']);
    
    SetWorkData($workId, $workKey, $workCategory, $workValue, $workPrice);
    
    EventLogger('', '', 'Work data setting', '', 'workId='.$workId.'&workKey='.$workKey.'&workCategory='.$workCategory.'&workValue='.$workValue.'&workPrice='.$workPrice);
    
    $userHttpReferer = ClearCommonVariables($_SERVER['HTTP_REFERER']);
    
    print($userHttpReferer);
?>