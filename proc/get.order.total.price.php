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
    
    if(!isset($_POST['orderId'])){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    if(trim($_POST['orderId']) == ''){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    $responseData = '';
    
    $orderId = ClearMySqlVariables($_POST['orderId']);
    
    $responseDataBuffer = '0.00';
        
    $getSystemDataQuery = mysql_query("SELECT orders_works_connections.work_price FROM orders_works_connections WHERE orders_works_connections.connect_status=\"active\" AND orders_works_connections.order_id=\"$orderId\"") or die(ErrorHandler('mysql', mysql_error()));
    $getSystemCount = mysql_num_rows($getSystemDataQuery);
    
    if(($getSystemDataQuery != null) && $getSystemCount != '0')
    {
        while($responseData = mysql_fetch_array($getSystemDataQuery, MYSQL_BOTH))
        {
            $totalWorksPrice = floatval($responseData['work_price']);
            $responseDataBuffer = floatval($responseDataBuffer) + floatval($totalWorksPrice);
        }
    }
    
    print(floatval($responseDataBuffer));
?>