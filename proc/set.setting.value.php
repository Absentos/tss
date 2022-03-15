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
    
    if((!isset($_POST['settingName'])) || (!isset($_POST['settingKey'])) || (!isset($_POST['settingValue']))){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    if((trim($_POST['settingName']) == '') || (trim($_POST['settingKey']) == '') || (trim($_POST['settingValue']) == '')){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    $settingName = ClearMySqlVariables($_POST['settingName']); 
    $settingKey = ClearMySqlVariables($_POST['settingKey']);
    $settingValue = ClearMySqlVariables($_POST['settingValue']);
    
    SetSettingValue($settingName, $settingKey, $settingValue);
    
    EventLogger('', '', 'System settings setting', '', 'settingName='.$settingName.'&settingKey='.$settingKey.'&settingValue='.$settingValue);
    
    $userHttpReferer = ClearCommonVariables($_SERVER['HTTP_REFERER']);
    
    print($userHttpReferer);
?>