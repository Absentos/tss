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
    
    if(!isset($_POST['workOperation'])){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    if(trim($_POST['workOperation']) == ''){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    $responseData = '';
    
    $workOperation = ClearMySqlVariables($_POST['workOperation']);
    $workOperation = str_replace(';', '', $workOperation);
    
    $responseDataBuffer = '';
        
    $getSystemDataQuery = mysql_query("SELECT * FROM list_of_works WHERE list_of_works.work_status=\"active\" AND list_of_works.work_value=\"$workOperation\"") or die(ErrorHandler('mysql', mysql_error()));
    $getSystemCount = mysql_num_rows($getSystemDataQuery);
    
    if(($getSystemDataQuery != null) && $getSystemCount != '0')
    {
        while($responseData = mysql_fetch_array($getSystemDataQuery, MYSQL_BOTH))
        {
            $workPrice = $responseData['work_price'];
            $responseDataBuffer = $workPrice;
        }
    }
    
    print($responseDataBuffer);
?>