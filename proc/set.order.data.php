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
    
    if((!isset($_POST['customerId'])) || (!isset($_POST['customerDetails'])) || (!isset($_POST['carId'])) || (!isset($_POST['carDetails']))){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    if((trim($_POST['customerId']) == '') || (trim($_POST['customerDetails']) == '') || (trim($_POST['carId']) == '') || (trim($_POST['carDetails']) == '')){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    $responseData = '';
    $customerId = ClearMySqlVariables($_POST['customerId']);
    $customerDetails = ClearMySqlVariables($_POST['customerDetails']);
    $customerDetails = str_replace(';', ';<br />', $customerDetails);
    $carId = ClearMySqlVariables($_POST['carId']);
    $carDetails = ClearMySqlVariables($_POST['carDetails']);
    $carDetails = str_replace(';', ';<br />', $carDetails);
    
    $responseData = SetOrderData($customerId, $customerDetails, $carId, $carDetails);
    
    EventLogger('', '', 'Order data setting', '', 'customerId='.$customerId.'&carId='.$carId);
    
    print($responseData);
?>