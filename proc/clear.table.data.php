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

    if(!isset($_POST['targetTable'])){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    if(trim($_POST['targetTable']) == ''){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    $targetTable = ClearMySqlVariables($_POST['targetTable']);
    
    if($targetTable == 'all')
    {
        ClearTableData('customers');
        ClearTableData('employees');
        ClearTableData('cars');
        ClearTableData('cars_customers_connections');
        ClearTableData('purchase_orders');
        ClearTableData('orders_works_connections');
        ClearTableData('list_of_works');
        ClearTableData('spares');
        ClearTableData('system_logs');
    }
    else
    {
        if($targetTable == 'customers')
        {
            ClearTableData($targetTable);
            ClearTableData('cars_customers_connections');
        }
        else if($targetTable == 'cars')
        {
            ClearTableData($targetTable);
            ClearTableData('cars_customers_connections');
        }
        else if($targetTable == 'purchase_orders')
        {
            ClearTableData($targetTable);
            ClearTableData('orders_works_connections');
        }
        else if($targetTable == 'list_of_works')
        {
            ClearTableData($targetTable);
            ClearTableData('orders_works_connections');
        }
        else
        {
            ClearTableData($targetTable);
        }
    }
    
    $userHttpReferer = ClearCommonVariables($_SERVER['HTTP_REFERER']);
    
    print($userHttpReferer);
?>