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

    if(!isset($_POST['userLanguage'])){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    if(trim($_POST['userLanguage']) == ''){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    $userLanguage = ClearCommonVariables($_POST['userLanguage']);
    $userHttpReferer = ClearCommonVariables($_SERVER['HTTP_REFERER']);
    
    if($userLanguage == 'ru')
    {
        $userLanguage = 'ru';
    }
    else
    {
        if($userLanguage == 'ua')
        {
            $userLanguage = 'ua';
        }
        else
        {
            $userLanguage = 'ru';
        }
    }
    
    SwitchLanguage($userLanguage);
    
    print($userHttpReferer);
?>