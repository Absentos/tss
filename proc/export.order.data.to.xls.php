<?php
/**
 * @author Sergey Shimkiv
 * @copyright 2011
 */
    
    @session_start();
    
    error_reporting(E_ALL);
    date_default_timezone_set('Europe/Simferopol');
    
    require_once '../inc/phpxls/PHPExcel.php';    
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
    
    if(!isset($_GET['orderId'])){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    if(trim($_GET['orderId']) == ''){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    $orderId = ClearMySqlVariables($_GET['orderId']);
    $timeStamp = date('dmY_His');
    $totalPrice = '0.00';
    $totalWorks = '';
    $insertingWorkDataRowPointer = 17;
    
    $getSystemDataQuery = mysql_query("SELECT * FROM purchase_orders WHERE purchase_orders.order_status=\"active\" AND purchase_orders.order_id=\"$orderId\"") or die(ErrorHandler('mysql', mysql_error()));
    $getSystemCount = mysql_num_rows($getSystemDataQuery);    
    if(($getSystemDataQuery != null) && $getSystemCount != '0')
    {
        while($responseData = mysql_fetch_array($getSystemDataQuery, MYSQL_BOTH))
        {
            $orderCustomerId = $responseData['order_customer_id'];
            $orderCarId = $responseData['order_car_id'];
        }
        
        $getSystemDataQuery = mysql_query("SELECT * FROM customers WHERE customers.customer_status=\"active\" AND customers.customer_id=\"$orderCustomerId\"") or die(ErrorHandler('mysql', mysql_error()));
        $getSystemCount = mysql_num_rows($getSystemDataQuery);            
        if(($getSystemDataQuery != null) && $getSystemCount != '0')
        {
            while($responseData = mysql_fetch_array($getSystemDataQuery, MYSQL_BOTH))
            {
                $customerLn = $responseData['customer_ln'];
                $customerFn = $responseData['customer_fn'];
                $customerMn = $responseData['customer_mn'];
                
                $customerPhone = $responseData['customer_phone'];
                $customerAddress = $responseData['customer_address'];
            }
            
            $customerLFM = $customerLn.' '.$customerFn.' '.$customerMn;
        }
        
        $getSystemDataQuery = mysql_query("SELECT * FROM cars WHERE cars.car_status=\"active\" AND cars.car_id=\"$orderCarId\"") or die(ErrorHandler('mysql', mysql_error()));
        $getSystemCount = mysql_num_rows($getSystemDataQuery);            
        if(($getSystemDataQuery != null) && $getSystemCount != '0')
        {
            while($responseData = mysql_fetch_array($getSystemDataQuery, MYSQL_BOTH))
            {
                $carModel = $responseData['car_model'];
                $carLP = $responseData['car_license_plates'];
                $carVin = $responseData['car_vin'];
                $carMileage = $responseData['car_mileage'];
            }
        }
    }
    
    $getSystemDataQuery = mysql_query("SELECT orders_works_connections.work_price FROM orders_works_connections WHERE orders_works_connections.connect_status=\"active\" AND orders_works_connections.order_id=\"$orderId\"") or die(ErrorHandler('mysql', mysql_error()));
    $getSystemCount = mysql_num_rows($getSystemDataQuery);
    
    if(($getSystemDataQuery != null) && $getSystemCount != '0')
    {
        while($responseData = mysql_fetch_array($getSystemDataQuery, MYSQL_BOTH))
        {
            $totalWorksPrice = floatval($responseData['work_price']);
            $totalPrice = floatval($totalPrice) + floatval($totalWorksPrice);
        }
        
        $totalPrice = floatval($totalPrice);
    }
    
    $responseDataBuffer = '';
        
    $getSystemDataQuery = mysql_query("SELECT COUNT(1) FROM orders_works_connections WHERE orders_works_connections.connect_status=\"active\" AND orders_works_connections.order_id=\"$orderId\"") or die(ErrorHandler('mysql', mysql_error()));
    $getSystemCount = mysql_num_rows($getSystemDataQuery);
    
    if(($getSystemDataQuery != null) && $getSystemCount != '0')
    {
        while($responseData = mysql_fetch_array($getSystemDataQuery, MYSQL_BOTH))
        {
            $totalWorksCount = $responseData[0];
            $totalWorks = $totalWorksCount;
        }
    }
    
    $objPHPExcel = new PHPExcel();    
    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load("../media/melkov.order.report.".$userLanguage.".tpl.xls");    
    $objPHPExcel->getProperties()->setCreator("ЧП Мелков")->setLastModifiedBy("ЧП Мелков")->setTitle("Заказ-наряд №".$orderId)->setSubject("Заказ-наряд №".$orderId)->setDescription("Заказ-наряд №".$orderId)->setKeywords("Заказ-наряд №".$orderId)->setCategory("Заказ-наряд №".$orderId);
    $objPHPExcel->getActiveSheet()->setTitle('Заказ-наряд №'.$orderId);
    $objPHPExcel->setActiveSheetIndex(0);
    
    $objPHPExcel->getActiveSheet()->getCell('A1')->setValue($melkovTranslation['ordersXlsMelkovDataLabel']);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getCell('D1')->setValue($melkovTranslation['ordersXlsOrderIdLabel'].$orderId);
    $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setWrapText(true);
    
    $objPHPExcel->getActiveSheet()->getCell('D2')->setValue($melkovTranslation['ordersXlsCustLFMLabel']."\n".$customerLFM);
    $objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getCell('H2')->setValue($melkovTranslation['ordersXlsAutoModelLabel']."\n".$carModel);
    $objPHPExcel->getActiveSheet()->getStyle('H2')->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getCell('J2')->setValue($melkovTranslation['ordersXlsAutoLPLabel']."\n".$carLP);
    $objPHPExcel->getActiveSheet()->getStyle('J2')->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getCell('D5')->setValue($melkovTranslation['ordersXlsCustAPLabel']."\n".$customerAddress.";\n".$customerPhone);
    $objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getCell('H5')->setValue($melkovTranslation['ordersXlsAutoVinLabel']."\n".$carVin);
    $objPHPExcel->getActiveSheet()->getStyle('H5')->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getCell('J5')->setValue($melkovTranslation['ordersXlsAutoMileageLabel']."\n".$carMileage);
    $objPHPExcel->getActiveSheet()->getStyle('J5')->getAlignment()->setWrapText(true);
    
    $objPHPExcel->getActiveSheet()->getCell('A18')->setValue($melkovTranslation['ordersXlsTotalSumLabel'].' '.$totalPrice);
    $objPHPExcel->getActiveSheet()->getStyle('A18')->getAlignment()->setWrapText(true);
    
    $getSystemDataQuery = mysql_query("SELECT * FROM orders_works_connections WHERE orders_works_connections.connect_status=\"active\" AND orders_works_connections.order_id=\"$orderId\" ORDER BY orders_works_connections.connect_id") or die(ErrorHandler('mysql', mysql_error()));
    $getSystemCount = mysql_num_rows($getSystemDataQuery);
    
    if(($getSystemDataQuery != null) && $getSystemCount != '0')
    {
        $objPHPExcel->getActiveSheet()->insertNewRowBefore($insertingWorkDataRowPointer, $totalWorks);
        $objPHPExcel->getActiveSheet()->removeRow($insertingWorkDataRowPointer + $totalWorks, 1);
        
        while($responseData = mysql_fetch_array($getSystemDataQuery, MYSQL_BOTH))
        {
            $workOperation = $responseData['work_value'];
            $workComments = $responseData['work_comments'];
            $workCode = $responseData['work_code'];
            $workPrice = $responseData['work_price'];
            $workEmpl = $responseData['work_executors'];
            
            $objPHPExcel->getActiveSheet()->mergeCells('B'.$insertingWorkDataRowPointer.':G'.$insertingWorkDataRowPointer);
            $objPHPExcel->getActiveSheet()->mergeCells('H'.$insertingWorkDataRowPointer.':I'.$insertingWorkDataRowPointer);
            $objPHPExcel->getActiveSheet()->mergeCells('J'.$insertingWorkDataRowPointer.':K'.$insertingWorkDataRowPointer);
            
            $objPHPExcel->getActiveSheet()->getCell('A'.$insertingWorkDataRowPointer)->setValue($workCode);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$insertingWorkDataRowPointer)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getCell('B'.$insertingWorkDataRowPointer)->setValue($workOperation."\n(".$workComments.")");
            $objPHPExcel->getActiveSheet()->getStyle('B'.$insertingWorkDataRowPointer)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getCell('H'.$insertingWorkDataRowPointer)->setValue($workPrice);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$insertingWorkDataRowPointer)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getCell('J'.$insertingWorkDataRowPointer)->setValue($workEmpl);
            $objPHPExcel->getActiveSheet()->getStyle('J'.$insertingWorkDataRowPointer)->getAlignment()->setWrapText(true);
            
            $insertingWorkDataRowPointer++;
        }
    }
    
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="order_'.$orderId.'_'.$timeStamp.'.xls"');
    header('Cache-Control: max-age=0');
    
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit();
?>