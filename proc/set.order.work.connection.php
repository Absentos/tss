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
    
    if((!isset($_POST['workOperation'])) || (!isset($_POST['workComments'])) || (!isset($_POST['workCode'])) || (!isset($_POST['workPrice'])) || (!isset($_POST['workEmpl'])) || (!isset($_POST['orderId']))){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    if((trim($_POST['workOperation']) == '') || (trim($_POST['workComments']) == '') || (trim($_POST['workCode']) == '') || (trim($_POST['workPrice']) == '') || (trim($_POST['workEmpl']) == '') || (trim($_POST['orderId']) == '')){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    $responseData = '';
    $orderId = ClearMySqlVariables($_POST['orderId']);
    $workOperation = ClearMySqlVariables($_POST['workOperation']);
    $workOperation = str_replace(';', '', $workOperation);
    $workComments = ClearMySqlVariables($_POST['workComments']);
    $workCode = ClearMySqlVariables($_POST['workCode']);
    $workPrice = ClearMySqlVariables($_POST['workPrice']);
    $workEmpl = ClearMySqlVariables($_POST['workEmpl']);
    $workEmplBuffer = substr($workEmpl, -1);
    if($workEmplBuffer == ';')
    {
        $workEmpl = substr($workEmpl, 0, strlen($workEmpl) - 1);
    }
    
    SetOrderWorkConnection($orderId, $workOperation, $workComments, $workCode, $workPrice, $workEmpl);
    
    $responseData = GetOrderWorkConnections($orderId);
    
    EventLogger('', '', 'Order-works data setting', '', 'orderId='.$orderId);
    
    print($responseData);
?>