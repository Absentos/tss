<?php
/**
 * @author Sergey Shimkiv
 * @copyright 2011
 */
        
    // Setting cars mileage data
    function SetCarsMileageData($carId, $carKm)
    {
	   $setCarsMileageDataRequest = mysql_query("UPDATE cars SET cars.car_mileage=\"$carKm\", cars.car_edit_date=CURDATE(), cars.car_edit_time=CURTIME() WHERE cars.car_id=\"$carId\"") or die(ErrorHandler('mysql', mysql_error()));
    }
    
    // Getting order-works connections
    function GetOrderWorkConnections($orderId)
    {
        $responseDataBuffer = '<table id="orderWorkConnectionsTable" cellpadding="1" cellspacing="1" border="1" style="border-color: #D0D0D0;"><thead><tr><th style="width: 100px;">Код операции</th><th style="width: 290px;">Операция<br />(комментарии)</th><th style="width: 100px;">Стоимость</th><th style="width: 120px;">Исполнитель</th><th style="width: 25px;"></th></tr></thead><tbody>';
        
        $getSystemDataQuery = mysql_query("SELECT * FROM orders_works_connections WHERE orders_works_connections.connect_status=\"active\" AND orders_works_connections.order_id=\"$orderId\" ORDER BY orders_works_connections.connect_id") or die(ErrorHandler('mysql', mysql_error()));
        $getSystemCount = mysql_num_rows($getSystemDataQuery);
        
        if(($getSystemDataQuery != null) && $getSystemCount != '0')
        {
            while($responseData = mysql_fetch_array($getSystemDataQuery, MYSQL_BOTH))
            {
                $connectionId = $responseData['connect_id'];
                $workOperation = $responseData['work_value'];
                $workComments = $responseData['work_comments'];
                $workCode = $responseData['work_code'];
                $workPrice = $responseData['work_price'];
                $workEmpl = $responseData['work_executors'];
                $connectionStatus = $responseData['connect_status'];
                
                $statusImg = '<img align="middle" style="width: 16px; height: 16px; cursor: pointer;" alt="Delete operation" title="Удалить" id="delMe'.$connectionId.'" name="delMe'.$connectionId.'" border="0" onclick="$(this).ChangeOrderConnectionStatus(\''.$connectionId.'\', \'orders_works_connections\', \'connect_status\', \'connect_id\', \''.$orderId.'\');" src="./img/portal.delete.gif" />';
                
                $responseDataBuffer .= '<tr><td>'.$workCode.'</td><td>'.$workOperation.'<br /><font style="font-size: 8px;">('.$workComments.')</font></td><td>'.$workPrice.'</td><td>'.$workEmpl.'</td><td align="center">'.$statusImg.'</td></tr>';
            }
        }
        
        $responseDataBuffer .= '</tbody></table>';
        
        return $responseDataBuffer;
    }
    
    // Setting order-works connections
    function SetOrderWorkConnection($orderId, $workOperation, $workComments, $workCode, $workPrice, $workEmpl)
    {
        $setConnectionRequest = mysql_query("INSERT INTO orders_works_connections VALUES (NULL, \"$orderId\", \"$workOperation\", \"$workComments\", \"$workCode\", \"$workPrice\", \"$workEmpl\", \"active\")") or die(ErrorHandler('mysql', mysql_error()));
    }
    
    // Get system available employees list
    function GetAvailableEmployeesList()
    {
        $responseDataBuffer = '';
        
        $getSystemDataQuery = mysql_query("SELECT employees.employee_id, employees.employee_ln, SUBSTRING(employees.employee_fn, 1, 1), SUBSTRING(employees.employee_mn,1,1) FROM employees WHERE employees.employee_status=\"active\" ORDER BY employees.employee_ln") or die(ErrorHandler('mysql', mysql_error()));
        $getSystemCount = mysql_num_rows($getSystemDataQuery);
        
        if(($getSystemDataQuery != null) && $getSystemCount != '0')
        {
            while($responseData = mysql_fetch_array($getSystemDataQuery, MYSQL_BOTH))
            {
                $emplId = $responseData[0];
                $emplLn = $responseData[1];
                $emplFn = $responseData[2];
                $emplMn = $responseData[3];
                
                $responseDataBuffer .= "'$emplLn $emplFn. $emplMn.', ";
            }
        }
        
        $responseDataBuffer = substr($responseDataBuffer, 0, strlen($responseDataBuffer) - 2);
        return $responseDataBuffer;
    }
    
    // Get system available operations list
    function GetAvailableOperationsList()
    {
        $responseDataBuffer = '';
        
        $getSystemDataQuery = mysql_query("SELECT * FROM list_of_works WHERE list_of_works.work_status=\"active\" ORDER BY list_of_works.work_category, list_of_works.work_value") or die(ErrorHandler('mysql', mysql_error()));
        $getSystemCount = mysql_num_rows($getSystemDataQuery);
        
        if(($getSystemDataQuery != null) && $getSystemCount != '0')
        {
            while($responseData = mysql_fetch_array($getSystemDataQuery, MYSQL_BOTH))
            {
                $workId = $responseData['work_id'];
                $workPrice = $responseData['work_price'];
                $workValue = $responseData['work_value'];
                
                $responseDataBuffer .= "'$workValue', ";
            }
        }
        
        $responseDataBuffer = substr($responseDataBuffer, 0, strlen($responseDataBuffer) - 2);
        return $responseDataBuffer;
    }
    
    // Setting order data
    function SetOrderData($customerId, $customerDetails, $carId, $carDetails)
    {
        $setOrderDataRequest = mysql_query("INSERT INTO purchase_orders VALUES (NULL, \"$customerId\", \"$customerDetails\", \"$carId\", \"$carDetails\", CURDATE(), CURTIME(), CURDATE(), CURTIME(), \"active\")") or die(ErrorHandler('mysql', mysql_error()));
        $responseData = mysql_insert_id();
        
        return $responseData;
    }
    
    // Get system available cars list for customer
    function GetCustomersCarsList($customerId)
    {
        $responseDataBuffer = '<option value="-1">---</option>';
        
        $carId = '';
        $carIdList = '';
        
        $getSystemCustomerCarsQuery = mysql_query("SELECT * FROM cars_customers_connections WHERE cars_customers_connections.connect_status=\"active\" AND cars_customers_connections.customer_id=\"$customerId\" ORDER BY cars_customers_connections.connect_id") or die(ErrorHandler('mysql', mysql_error()));
        $getSystemCustomerCarsCount = mysql_num_rows($getSystemCustomerCarsQuery);
        
        if(($getSystemCustomerCarsQuery != null) && $getSystemCustomerCarsCount != '0')
        {
            while ($responseData = mysql_fetch_array($getSystemCustomerCarsQuery, MYSQL_BOTH))
            {
                $carIdList .= $responseData['car_id'].';';
            }
        }
        
        $carsArray = explode(';', $carIdList);
        $carsArrayCount = count($carsArray) - 1;
        
        for($i = 0; $i <= $carsArrayCount; $i++)
        {
            $carId = trim($carsArray[$i]);
            
            $getCarsLPQuery = mysql_query("SELECT * FROM cars WHERE cars.car_status=\"active\" AND cars.car_id=\"$carId\" ORDER BY cars.car_vin") or die(ErrorHandler('mysql', mysql_error()));
            $getCarsLPCount = mysql_num_rows($getCarsLPQuery);
            
            if(($getCarsLPQuery != null) && $getCarsLPCount != '0')
            {
                while ($responseData = mysql_fetch_array($getCarsLPQuery, MYSQL_BOTH))
                {
                    $carId = $responseData['car_id'];
                    $carLP = $responseData['car_license_plates'];
                }                            
                
                $responseDataBuffer .= '<option value="'.$carId.'">'.$carLP.'</option>';
            }
        }
        
        return $responseDataBuffer;
    }
    
    // Get customer data by ID
    function GetCustomerDataById($customerId)
    {
        $responseDataBuffer = '';
        
        $getSystemDataQuery = mysql_query("SELECT * FROM customers WHERE customers.customer_status=\"active\" AND customers.customer_id=\"$customerId\" ORDER BY customers.customer_ln") or die(ErrorHandler('mysql', mysql_error()));
        $getSystemCount = mysql_num_rows($getSystemDataQuery);
        
        if(($getSystemDataQuery != null) && $getSystemCount != '0')
        {
            while($responseData = mysql_fetch_array($getSystemDataQuery, MYSQL_BOTH))
            {
                $customerId = $responseData['customer_id'];
                $customerFn = $responseData['customer_fn'];
                $customerLn = $responseData['customer_ln'];
                $customerMn = $responseData['customer_mn'];
                $customerCode = $responseData['customer_code'];
                $customerNick = $responseData['customer_nick'];
                $customerEmail = $responseData['customer_email'];
                $customerPhone = $responseData['customer_phone'];
                $customerAddress = $responseData['customer_address'];
                $customerIm = $responseData['customer_im'];
                $customerSkype = $responseData['customer_skype'];
                $customerSite = $responseData['customer_site'];
                $customerComments = $responseData['customer_comments'];
                $customerDebt = $responseData['customer_debt'];
                $customerCreationDate = date('d.m.Y', strtotime($responseData['customer_creation_date']));
                $customerCreationTime = $responseData['customer_creation_time'];
                $customerEditDate = date('d.m.Y', strtotime($responseData['customer_edit_date']));
                $customerEditTime = $responseData['customer_edit_time'];
                $customerStatus = $responseData['customer_status'];
                
                $responseDataBuffer .= $customerCode.'; '.$customerNick.'; '.$customerEmail.'; '.$customerPhone.'; '.$customerAddress.'; '.$customerIm.'; '.$customerSkype.'; '.$customerSite.'; '.$customerComments.'; <font color="red">'.$customerDebt.'</font>; '.$customerCreationDate.' - '.$customerCreationTime;
            }
        }
        
        return $responseDataBuffer;
    }
    
    // Get system available customers list
    function GetAvailableCustomersList()
    {
        $responseDataBuffer = '<option value="-1" id="defaultCustomer">---</option>';
        
        $getSystemDataQuery = mysql_query("SELECT * FROM customers WHERE customers.customer_status=\"active\" ORDER BY customers.customer_ln") or die(ErrorHandler('mysql', mysql_error()));
        $getSystemCount = mysql_num_rows($getSystemDataQuery);
        
        if(($getSystemDataQuery != null) && $getSystemCount != '0')
        {
            while($responseData = mysql_fetch_array($getSystemDataQuery, MYSQL_BOTH))
            {
                $customerId = $responseData['customer_id'];
                $customerFn = $responseData['customer_fn'];
                $customerLn = $responseData['customer_ln'];
                $customerMn = $responseData['customer_mn'];
                $customerCode = $responseData['customer_code'];
                $customerNick = $responseData['customer_nick'];
                $customerEmail = $responseData['customer_email'];
                $customerPhone = $responseData['customer_phone'];
                $customerAddress = $responseData['customer_address'];
                $customerIm = $responseData['customer_im'];
                $customerSkype = $responseData['customer_skype'];
                $customerSite = $responseData['customer_site'];
                $customerComments = $responseData['customer_comments'];
                $customerDebt = $responseData['customer_debt'];
                $customerCreationDate = date('d.m.Y', strtotime($responseData['customer_creation_date']));
                $customerCreationTime = $responseData['customer_creation_time'];
                $customerEditDate = date('d.m.Y', strtotime($responseData['customer_edit_date']));
                $customerEditTime = $responseData['customer_edit_time'];
                $customerStatus = $responseData['customer_status'];
                
                $responseDataBuffer .= '<option value="'.$customerId.'">'.$customerLn.' '.$customerFn.' '.$customerMn.'</option>';
            }
        }
        
        return $responseDataBuffer;
    }
    
    // Get system orders list
    function GetSystemOrdersList($searchData, $searchDateFrom, $searchDateTo)
    {
        $responseTableData = '';
        
        $searchParam = "";
        
        if(($searchData != '') && ($searchDateFrom == '' || $searchDateTo == ''))
        {
            $searchParam = "";
                    
            $searchParamData = "purchase_orders.order_customer_details LIKE '%$searchData%' OR purchase_orders.order_car_details LIKE '%$searchData%' OR purchase_orders.order_id LIKE '%$searchData%'";
            $searchParam = "WHERE ".$searchParamData;
        }
            
        if(($searchData != '') && ($searchDateFrom != '') && ($searchDateTo != ''))
        {
            $searchParam = "";
                    
            $searchParamData = "purchase_orders.order_customer_details LIKE '%$searchData%' OR purchase_orders.order_car_details LIKE '%$searchData%' OR purchase_orders.order_id LIKE '%$searchData%'";
            $searchParam = "WHERE (".$searchParamData.")";
                    
            $searchParamDateFrom = "STR_TO_DATE(\"$searchDateFrom\", \"%d.%m.%Y\")";
            $searchParam .= " AND (purchase_orders.order_creation_date BETWEEN ".$searchParamDateFrom;
                    
            $searchParamDateTo = "STR_TO_DATE(\"$searchDateTo\", \"%d.%m.%Y\")";
            $searchParam .= " AND ".$searchParamDateTo.")";
        }
            
        if(($searchData == '') && ($searchDateFrom != '') && ($searchDateTo != ''))
        {
            $searchParam = "";
                    
            $searchParamDateFrom = "STR_TO_DATE(\"$searchDateFrom\", \"%d.%m.%Y\")";
            $searchParam = "WHERE purchase_orders.order_creation_date BETWEEN ".$searchParamDateFrom;
                    
            $searchParamDateTo = "STR_TO_DATE(\"$searchDateTo\", \"%d.%m.%Y\")";
            $searchParam .= " AND ".$searchParamDateTo;
        }
                
        $totalDataCount = GetCountTotalTableData(ClearMySqlVariables('purchase_orders'), $searchParam);
        
        if($totalDataCount != '0')
        {
            $getSystemOrdersDataQuery = mysql_query("SELECT * FROM purchase_orders ".$searchParam." ORDER BY purchase_orders.order_id DESC") or die(ErrorHandler('mysql', mysql_error()));
            $getSystemOrdersCount = mysql_num_rows($getSystemOrdersDataQuery);
            
            if(($getSystemOrdersDataQuery != null) && $getSystemOrdersCount != '0')
            {
                while($responseData = mysql_fetch_array($getSystemOrdersDataQuery, MYSQL_BOTH))
				{
				    $orderId = $responseData['order_id'];
                    $orderCustId = $responseData['order_customer_id'];
                    $orderCustDet = $responseData['order_customer_details'];
                    $orderCarId = $responseData['order_car_id'];
                    $orderCarDet = $responseData['order_car_details'];                    
                    $orderCreationDate = date('d.m.Y', strtotime($responseData['order_creation_date']));
                    $orderCreationTime = $responseData['order_creation_time'];
                    $orderEditDate = date('d.m.Y', strtotime($responseData['order_edit_date']));
                    $orderEditTime = $responseData['order_edit_time'];
                    $orderStatus = $responseData['order_status'];
                    
                    if($orderStatus == 'active')
                    {
                        $fontColor = '#000000';
                    }
                    else
                    {
                        $fontColor = '#C0C0C0';
                    }
                    
                    $orderExportImg = '<a href="./proc/export.order.data.to.xls.php?orderId='.$orderId.'"><img align="middle" style="width: 16px; height: 16px; cursor: pointer;" alt="XLS export" title="XLS" id="exportMe'.$carsId.'" name="exportMe'.$orderId.'" border="0" src="./img/portal.xls.png" /></a>';
                    
                    $responseTableData .= '<tr><td><font color="'.$fontColor.'"><a href="./" style="color: '.$fontColor.';" onclick="$(this).ViewCurrentOrderDetails(\''.$orderId.'\', $(\'#orderCustDet'.$orderId.'\').html(), $(\'#orderCarDet'.$orderId.'\').html()); return false;">'.$orderId.'</a></font></td><td><font color="'.$fontColor.'">'.$orderCreationDate.' - '.$orderCreationTime.'</font></td><td><font color="'.$fontColor.'" id="orderCustDet'.$orderId.'">'.$orderCustDet.'</font></td><td><font color="'.$fontColor.'" id="orderCarDet'.$orderId.'">'.$orderCarDet.'</font></td><td>'.$orderExportImg.'</td></tr>';
				}
            }
            else
            {
                $responseTableData = '<tr><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td></tr>';
            }
        }
        else
        {
            $responseTableData = '<tr><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td></tr>';
        }
        
        return $responseTableData;
    }
    
    // Get system available cars list
    function GetAvailableCarsList()
    {
        $responseDataBuffer = '';
        
        $getSystemCarsDataQuery = mysql_query("SELECT * FROM cars WHERE cars.car_status=\"active\" ORDER BY cars.car_vin") or die(ErrorHandler('mysql', mysql_error()));
        $getSystemCarsCount = mysql_num_rows($getSystemCarsDataQuery);
        
        if(($getSystemCarsDataQuery != null) && $getSystemCarsCount != '0')
        {
            while($responseData = mysql_fetch_array($getSystemCarsDataQuery, MYSQL_BOTH))
            {
                $carId = $responseData['car_id'];
                $carModel = $responseData['car_model'];
                $carLP = $responseData['car_license_plates'];
                
                $responseDataBuffer .= "'$carModel ($carLP)', ";
            }
        }
        
        $responseDataBuffer = substr($responseDataBuffer, 0, strlen($responseDataBuffer) - 2);
        return $responseDataBuffer;
    }
    
    // Get system customers list
    function GetSystemCustomersList($searchData)
    {
        $responseTableData = '';
        
        if($searchData != '')
        {
            $searchParam = "WHERE (customers.customer_fn LIKE '%$searchData%' OR customers.customer_ln LIKE '%$searchData%' OR customers.customer_mn LIKE '%$searchData%' OR customers.customer_debt LIKE '%$searchData%' OR customers.customer_code LIKE '%$searchData%' OR customers.customer_nick LIKE '%$searchData%' OR customers.customer_email LIKE '%$searchData%' OR customers.customer_phone LIKE '%$searchData%' OR customers.customer_address LIKE '%$searchData%' OR customers.customer_im LIKE '%$searchData%' OR customers.customer_skype LIKE '%$searchData%' OR customers.customer_site LIKE '%$searchData%' OR customers.customer_comments LIKE '%$searchData%')";
        }
        else
        {
            $searchParam = "";
        }
        
        $totalDataCount = GetCountTotalTableData(ClearMySqlVariables('customers'), $searchParam);
        
        if($totalDataCount != '0')
        {
            $getSystemCustDataQuery = mysql_query("SELECT * FROM customers ".$searchParam." ORDER BY customers.customer_ln") or die(ErrorHandler('mysql', mysql_error()));
            $getSystemCustCount = mysql_num_rows($getSystemCustDataQuery);
            
            if(($getSystemCustDataQuery != null) && $getSystemCustCount != '0')
            {
                while($responseData = mysql_fetch_array($getSystemCustDataQuery, MYSQL_BOTH))
				{
				    $customerId = $responseData['customer_id'];
                    $customerFn = $responseData['customer_fn'];
                    $customerLn = $responseData['customer_ln'];
                    $customerMn = $responseData['customer_mn'];
                    $customerCode = $responseData['customer_code'];
                    $customerNick = $responseData['customer_nick'];
                    $customerEmail = $responseData['customer_email'];
                    $customerPhone = $responseData['customer_phone'];
                    $customerAddress = $responseData['customer_address'];
                    $customerIm = $responseData['customer_im'];
                    $customerSkype = $responseData['customer_skype'];
                    $customerSite = $responseData['customer_site'];
                    $customerComments = $responseData['customer_comments'];
                    $customerDebt = $responseData['customer_debt'];
                    $customerCreationDate = date('d.m.Y', strtotime($responseData['customer_creation_date']));
                    $customerCreationTime = $responseData['customer_creation_time'];
                    $customerEditDate = date('d.m.Y', strtotime($responseData['customer_edit_date']));
                    $customerEditTime = $responseData['customer_edit_time'];
                    $customerStatus = $responseData['customer_status'];
                    
                    if($customerStatus == 'active')
                    {
                        $custStatusImg = '<img align="middle" style="width: 16px; height: 16px; cursor: pointer;" alt="Change status" title="Заблокировать" id="blockMe'.$customerId.'" name="blockMe'.$customerId.'" border="0" onclick="$(this).ChangeTableDataStatus(\''.$customerId.'\', \'customers\', \'customer_status\', \'customer_id\');" src="./img/portal_deactivate.gif" />';
                        
                        if($customerDebt > 0)
                        {
                            $fontColor = '#EE2F0D';
                        }
                        else
                        {
                            $fontColor = '#000000';
                        }
                    }
                    else
                    {
                        $custStatusImg = '<img align="middle" style="width: 13px; height: 13px; cursor: pointer;" alt="Change status" title="Активировать" id="activateMe'.$customerId.'" name="activateMe'.$customerId.'" border="0" onclick="$(this).ChangeTableDataStatus(\''.$customerId.'\', \'customers\', \'customer_status\', \'customer_id\');" src="./img/portal_key.gif" />';
                        
                        if($customerDebt > 0)
                        {
                            $fontColor = '#EE2F0D';
                        }
                        else
                        {
                            $fontColor = '#C0C0C0';
                        }
                    }
                    
                    $carId = '';
                    $carIdList = '';
                    $customerCarsList = '';
                    
                    $getSystemCustomerCarsQuery = mysql_query("SELECT * FROM cars_customers_connections WHERE cars_customers_connections.connect_status=\"active\" AND cars_customers_connections.customer_id=\"$customerId\" ORDER BY cars_customers_connections.connect_id") or die(ErrorHandler('mysql', mysql_error()));
                    $getSystemCustomerCarsCount = mysql_num_rows($getSystemCustomerCarsQuery);
                    
                    if(($getSystemCustomerCarsQuery != null) && $getSystemCustomerCarsCount != '0')
                    {
                        while ($responseData = mysql_fetch_array($getSystemCustomerCarsQuery, MYSQL_BOTH))
                        {
                            $carIdList .= $responseData['car_id'].';';
                        }
                    }
                    
                    $carsArray = explode(';', $carIdList);
                    $carsArrayCount = count($carsArray) - 1;
                                
                    for($i = 0; $i <= $carsArrayCount; $i++)
                    {
                        $carId = trim($carsArray[$i]);
                                        
                        $getCarsLPQuery = mysql_query("SELECT * FROM cars WHERE cars.car_status=\"active\" AND cars.car_id=\"$carId\" ORDER BY cars.car_vin") or die(ErrorHandler('mysql', mysql_error()));
                        $getCarsLPCount = mysql_num_rows($getCarsLPQuery);
                                        
                        if(($getCarsLPQuery != null) && $getCarsLPCount != '0')
                        {
                            while ($responseData = mysql_fetch_array($getCarsLPQuery, MYSQL_BOTH))
                            {
                                $carModel = $responseData['car_model'];
                                $carLP = $responseData['car_license_plates'];
                            }
                            
                            $customerCarsList .= $carModel.' ('.$carLP.'); ';
                        }
                    }
                    
                    $responseTableData .= '<tr><td><font color="'.$fontColor.'">'.$customerCode.'</font></td><td><font color="'.$fontColor.'">'.$customerNick.'</font></td><td><font color="'.$fontColor.'"><a href="./" style="color: '.$fontColor.';" onclick="$(this).ViewCurrentCustDetails(\''.$customerId.'\', \''.$customerCode.'\', \''.$customerFn.'\', \''.$customerLn.'\', \''.$customerMn.'\', \''.$customerDebt.'\', \''.$customerNick.'\', \''.$customerEmail.'\', \''.$customerPhone.'\', \''.$customerAddress.'\', \''.$customerIm.'\', \''.$customerSkype.'\', \''.$customerSite.'\', \''.$customerComments.'\', \''.$customerCreationDate.' - '.$customerCreationTime.'\', \''.$customerEditDate.' - '.$customerEditTime.'\', \''.$customerStatus.'\', \''.$customerCarsList.'\'); return false;">'.$customerLn.' '.$customerFn.' '.$customerMn.'</a></font></td><td><font color="'.$fontColor.'"><b>'.$customerDebt.'</b></font></td><td><font color="'.$fontColor.'">'.$customerPhone.'</font></td><td><font color="'.$fontColor.'">'.$customerEmail.'</font></td><td><font color="'.$fontColor.'">'.$customerIm.'</font></td><td>'.$custStatusImg.'</td></tr>';
				}
            }
            else
            {
                $responseTableData = '<tr><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td></tr>';
            }
        }
        else
        {
            $responseTableData = '<tr><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td></tr>';
        }
        
        return $responseTableData;
    }
    
    // Setting customer data
    function SetCustomerData($custId, $custKey, $custFn, $custLn, $custMn, $custDebt, $custNick, $custEmail, $custPhone, $custAddress, $custIm, $custSkype, $custSite, $custComments, $custAuto)
    {
		if($custId == '')
		{
			$setCustomerDataRequest = mysql_query("INSERT INTO customers VALUES (NULL, \"$custFn\", \"$custLn\", \"$custMn\", \"$custDebt\", \"$custKey\", \"$custNick\", \"$custEmail\", \"$custPhone\", \"$custAddress\", \"$custIm\", \"$custSkype\", \"$custSite\", \"$custComments\", CURDATE(), CURTIME(), CURDATE(), CURTIME(), \"active\")") or die(ErrorHandler('mysql', mysql_error()));
            
            $customerId = mysql_insert_id();
            $deleteCustomersCarsConnectionsRequest = mysql_query("DELETE FROM cars_customers_connections WHERE cars_customers_connections.customer_id=\"$customerId\"") or die(ErrorHandler('mysql', mysql_error()));
            
            $carsArray = explode(';', $custAuto);
            $carsArrayCount = count($carsArray) - 1;
            
            for($i = 0; $i <= $carsArrayCount; $i++)
            {
                $currentCarsDataArray = explode(' ', $carsArray[$i]);
				$currentCarsDataArrayCount = count($currentCarsDataArray);
                $currentCarLP = $currentCarsDataArray[$currentCarsDataArrayCount - 1];
                $currentCarLP = str_replace('(', '', $currentCarLP);
                $currentCarLP = str_replace(')', '', $currentCarLP);
                
                $carLP = ClearCommonVariables($currentCarLP);
                
				$getCarsIdQuery = mysql_query("SELECT * FROM cars WHERE cars.car_status=\"active\" AND cars.car_license_plates=\"$carLP\" ORDER BY cars.car_vin") or die(ErrorHandler('mysql', mysql_error()));
				$getCarsIdCount = mysql_num_rows($getCarsIdQuery);
				
				if(($getCarsIdQuery != null) && $getCarsIdCount != '0')
				{
					while ($responseData = mysql_fetch_array($getCarsIdQuery, MYSQL_BOTH))
					{
						$carId = $responseData['car_id'];
						
						$getSystemDataQuery = mysql_query("SELECT COUNT(1) FROM cars_customers_connections WHERE cars_customers_connections.connect_status=\"active\" AND cars_customers_connections.car_id=\"$carId\" AND cars_customers_connections.customer_id=\"$customerId\" ORDER BY cars_customers_connections.connect_id") or die(ErrorHandler('mysql', mysql_error()));
						$getSystemCount = mysql_num_rows($getSystemDataQuery);
						
						if(($getSystemDataQuery != null) && $getSystemCount != '0')
						{
							while ($responseDataCount = mysql_fetch_array($getSystemDataQuery, MYSQL_BOTH))
							{
								$dataCount = $responseDataCount[0];
							}
							
							if($dataCount == 0)
							{
								$setCustomersCarsConnectionRequest = mysql_query("INSERT INTO cars_customers_connections VALUES (NULL, \"$carId\", \"$customerId\", \"active\")") or die(ErrorHandler('mysql', mysql_error()));
							}
						}
					}
				}
            }
		}
		else
		{
			$setCustomerDataRequest = mysql_query("UPDATE customers SET customers.customer_fn=\"$custFn\", customers.customer_ln=\"$custLn\", customers.customer_mn=\"$custMn\", customers.customer_debt=\"$custDebt\", customers.customer_code=\"$custKey\", customers.customer_nick=\"$custNick\", customers.customer_email=\"$custEmail\", customers.customer_phone=\"$custPhone\", customers.customer_address=\"$custAddress\", customers.customer_im=\"$custIm\", customers.customer_skype=\"$custSkype\", customers.customer_site=\"$custSite\", customers.customer_comments=\"$custComments\", customers.customer_edit_date=CURDATE(), customers.customer_edit_time=CURTIME() WHERE customers.customer_id=\"$custId\"") or die(ErrorHandler('mysql', mysql_error()));
            $deleteCustomersCarsConnectionsRequest = mysql_query("DELETE FROM cars_customers_connections WHERE cars_customers_connections.customer_id=\"$custId\"") or die(ErrorHandler('mysql', mysql_error()));
            
            $carsArray = explode(';', $custAuto);
            $carsArrayCount = count($carsArray) - 1;
			$prevCarLP = '';
            
            for($i = 0; $i <= $carsArrayCount; $i++)
            {
                $currentCarsDataArray = explode(' ', $carsArray[$i]);
                $currentCarsDataArrayCount = count($currentCarsDataArray);
                $currentCarLP = $currentCarsDataArray[$currentCarsDataArrayCount - 1];
                $currentCarLP = str_replace('(', '', $currentCarLP);
                $currentCarLP = str_replace(')', '', $currentCarLP);
                
                $carLP = ClearCommonVariables($currentCarLP);
                
				$getCarsIdQuery = mysql_query("SELECT * FROM cars WHERE cars.car_status=\"active\" AND cars.car_license_plates=\"$carLP\" ORDER BY cars.car_vin") or die(ErrorHandler('mysql', mysql_error()));
				$getCarsIdCount = mysql_num_rows($getCarsIdQuery);
				
				if(($getCarsIdQuery != null) && $getCarsIdCount != '0')
				{
					while ($responseData = mysql_fetch_array($getCarsIdQuery, MYSQL_BOTH))
					{
						$carId = $responseData['car_id'];
						
						$getSystemDataQuery = mysql_query("SELECT COUNT(1) FROM cars_customers_connections WHERE cars_customers_connections.connect_status=\"active\" AND cars_customers_connections.car_id=\"$carId\" AND cars_customers_connections.customer_id=\"$custId\" ORDER BY cars_customers_connections.connect_id") or die(ErrorHandler('mysql', mysql_error()));
						$getSystemCount = mysql_num_rows($getSystemDataQuery);
						
						if(($getSystemDataQuery != null) && $getSystemCount != '0')
						{
							while ($responseDataCount = mysql_fetch_array($getSystemDataQuery, MYSQL_BOTH))
							{
								$dataCount = $responseDataCount[0];
							}
							
							if($dataCount == 0)
							{
								$setCustomersCarsConnectionRequest = mysql_query("INSERT INTO cars_customers_connections VALUES (NULL, \"$carId\", \"$custId\", \"active\")") or die(ErrorHandler('mysql', mysql_error()));
							}
						}
					}
				}
            }            
		}
    }
    
    // Get system cars list
    function GetSystemCarsList($searchData)
    {
        $responseTableData = '';
        
        if($searchData != '')
        {
            $searchParam = "WHERE (cars.car_model LIKE '%$searchData%' OR cars.car_year LIKE '%$searchData%' OR cars.car_vin LIKE '%$searchData%' OR cars.car_license_plates LIKE '%$searchData%' OR cars.car_mileage LIKE '%$searchData%' OR cars.car_code LIKE '%$searchData%' OR cars.car_nick LIKE '%$searchData%' OR cars.car_comments LIKE '%$searchData%' OR cars.car_ev LIKE '%$searchData%' OR cars.car_color LIKE '%$searchData%')";
        }
        else
        {
            $searchParam = "";
        }
        
        $totalDataCount = GetCountTotalTableData(ClearMySqlVariables('cars'), $searchParam);
        
        if($totalDataCount != '0')
        {
            $getSystemCarsDataQuery = mysql_query("SELECT * FROM cars ".$searchParam." ORDER BY cars.car_vin") or die(ErrorHandler('mysql', mysql_error()));
            $getSystemCarsCount = mysql_num_rows($getSystemCarsDataQuery);
            
            if(($getSystemCarsDataQuery != null) && $getSystemCarsCount != '0')
            {
                while($responseData = mysql_fetch_array($getSystemCarsDataQuery, MYSQL_BOTH))
				{
				    $carsId = $responseData['car_id'];
                    $carModel = $responseData['car_model'];
                    $carYear = $responseData['car_year'];
                    $carVin = $responseData['car_vin'];
                    $carLicensePlates = $responseData['car_license_plates'];
                    $carMileage = $responseData['car_mileage'];
                    $carCode = $responseData['car_code'];
                    $carNick = $responseData['car_nick'];
                    $carComments = $responseData['car_comments'];                    
                    $carCreationDate = date('d.m.Y', strtotime($responseData['car_creation_date']));
                    $carCreationTime = $responseData['car_creation_time'];
                    $carEditDate = date('d.m.Y', strtotime($responseData['car_edit_date']));
                    $carEditTime = $responseData['car_edit_time'];
                    $carStatus = $responseData['car_status'];
                    $carEv = $responseData['car_ev'];
                    $carColor = $responseData['car_color'];
                    $carOwners = '';
                    
                    $getSystemDataQuery = mysql_query("SELECT * FROM cars_customers_connections WHERE cars_customers_connections.connect_status=\"active\" AND cars_customers_connections.car_id=\"$carsId\" ORDER BY cars_customers_connections.connect_id") or die(ErrorHandler('mysql', mysql_error()));
                    $getSystemCount = mysql_num_rows($getSystemDataQuery);
                            
                    if(($getSystemDataQuery != null) && $getSystemCount != '0')
                    {
                        while($responseData = mysql_fetch_array($getSystemDataQuery, MYSQL_BOTH))
                        {
                            $carOwnerId = $responseData['customer_id'];
                            
                            $getSystemCustDataQuery = mysql_query("SELECT * FROM customers WHERE customers.customer_status=\"active\" AND customers.customer_id=\"$carOwnerId\" ORDER BY customers.customer_ln") or die(ErrorHandler('mysql', mysql_error()));
                            $getSystemCustCount = mysql_num_rows($getSystemCustDataQuery);
                                                        
                            if(($getSystemCustDataQuery != null) && $getSystemCustCount != '0')
                            {
                                while($responseCustData = mysql_fetch_array($getSystemCustDataQuery, MYSQL_BOTH))
                                {
                                    $custLn = $responseCustData['customer_ln'];
                                    $custFn = $responseCustData['customer_fn'];
                                    $custMn = $responseCustData['customer_mn'];
                                    $carOwners .= $custLn.' '.$custFn.' '.$custMn.'; ';
                                }
                            }                            
                        }
                    }
                    
                    if($carStatus == 'active')
                    {
                        $carsStatusImg = '<img align="middle" style="width: 16px; height: 16px; cursor: pointer;" alt="Change status" title="Заблокировать" id="blockMe'.$carsId.'" name="blockMe'.$carsId.'" border="0" onclick="$(this).ChangeTableDataStatus(\''.$carsId.'\', \'cars\', \'car_status\', \'car_id\');" src="./img/portal_deactivate.gif" />';
                        $fontColor = '#000000';
                    }
                    else
                    {
                        $carsStatusImg = '<img align="middle" style="width: 13px; height: 13px; cursor: pointer;" alt="Change status" title="Активировать" id="activateMe'.$carsId.'" name="activateMe'.$carsId.'" border="0" onclick="$(this).ChangeTableDataStatus(\''.$carsId.'\', \'cars\', \'car_status\', \'car_id\');" src="./img/portal_key.gif" />';
                        $fontColor = '#C0C0C0';
                    }
                    
                    $responseTableData .= '<tr><td><font color="'.$fontColor.'">'.$carCode.'</font></td><td><font color="'.$fontColor.'">'.$carNick.'</font></td><td><font color="'.$fontColor.'"><a href="./" style="color: '.$fontColor.';" onclick="$(this).ViewCurrentCarsDetails(\''.$carsId.'\', \''.$carModel.'\', \''.$carYear.'\', \''.$carVin.'\', \''.$carLicensePlates.'\', \''.$carCode.'\', \''.$carNick.'\', \''.$carComments.'\', \''.$carCreationDate.' - '.$carCreationTime.'\', \''.$carEditDate.' - '.$carEditTime.'\', \''.$carStatus.'\', \''.$carEv.'\', \''.$carColor.'\', \''.$carOwners.'\'); return false;">'.$carVin.'</a></font></td><td><font color="'.$fontColor.'">'.$carYear.'</font></td><td><font color="'.$fontColor.'">'.$carModel.'</font></td><td><font color="'.$fontColor.'">'.$carColor.'</font></td><td><font color="'.$fontColor.'">'.$carLicensePlates.'</font></td><td>'.$carsStatusImg.'</td></tr>';
				}
            }
            else
            {
                $responseTableData = '<tr><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td></tr>';
            }
        }
        else
        {
            $responseTableData = '<tr><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td></tr>';
        }
        
        return $responseTableData;
    }
    
    // Setting cars data
    function SetCarsData($carsId, $carsVin, $carsLP, $carsModel, $carsYear, $carsNick, $carsKey, $carsComments, $carEv, $carColor)
    {
		if($carsId == '')
		{
			$setCarsDataRequest = mysql_query("INSERT INTO cars VALUES (NULL, \"$carsModel\", \"$carsYear\", \"$carsVin\", \"$carsLP\", \"\", \"$carsKey\", \"$carsNick\", \"$carsComments\", CURDATE(), CURTIME(), CURDATE(), CURTIME(), \"active\", \"$carEv\", \"$carColor\")") or die(ErrorHandler('mysql', mysql_error()));
		}
		else
		{
			$setCarsDataRequest = mysql_query("UPDATE cars SET cars.car_model=\"$carsModel\", cars.car_year=\"$carsYear\", cars.car_vin=\"$carsVin\", cars.car_license_plates=\"$carsLP\", cars.car_code=\"$carsKey\", cars.car_nick=\"$carsNick\", cars.car_comments=\"$carsComments\", cars.car_ev=\"$carEv\", cars.car_color=\"$carColor\", cars.car_edit_date=CURDATE(), cars.car_edit_time=CURTIME() WHERE cars.car_id=\"$carsId\"") or die(ErrorHandler('mysql', mysql_error()));
		}
    }
    
    // Get system employees list
    function GetSystemEmployeesList($searchData)
    {
        $responseTableData = '';
        
        if($searchData != '')
        {
            $searchParam = "WHERE (employees.employee_fn LIKE '%$searchData%' OR employees.employee_ln LIKE '%$searchData%' OR employees.employee_mn LIKE '%$searchData%' OR employees.employee_birth_date LIKE '%$searchData%' OR employees.employee_code LIKE '%$searchData%' OR employees.employee_nick LIKE '%$searchData%' OR employees.employee_email LIKE '%$searchData%' OR employees.employee_phone LIKE '%$searchData%' OR employees.employee_address LIKE '%$searchData%' OR employees.employee_im LIKE '%$searchData%' OR employees.employee_skype LIKE '%$searchData%' OR employees.employee_site LIKE '%$searchData%' OR employees.employee_comments LIKE '%$searchData%' OR employees.employee_passport LIKE '%$searchData%' OR employees.employee_position LIKE '%$searchData%')";
        }
        else
        {
            $searchParam = "";
        }
        
        $totalDataCount = GetCountTotalTableData(ClearMySqlVariables('employees'), $searchParam);
        
        if($totalDataCount != '0')
        {
            $getSystemEmplDataQuery = mysql_query("SELECT * FROM employees ".$searchParam." ORDER BY employees.employee_ln") or die(ErrorHandler('mysql', mysql_error()));
            $getSystemEmplCount = mysql_num_rows($getSystemEmplDataQuery);
            
            if(($getSystemEmplDataQuery != null) && $getSystemEmplCount != '0')
            {
                while($responseData = mysql_fetch_array($getSystemEmplDataQuery, MYSQL_BOTH))
				{
				    $employeeId = $responseData['employee_id'];
                    $employeeFn = $responseData['employee_fn'];
                    $employeeLn = $responseData['employee_ln'];
                    $employeeMn = $responseData['employee_mn'];
                    $employeeBirthDate = date('d.m.Y', strtotime($responseData['employee_birth_date']));
                    $employeeCode = $responseData['employee_code'];
                    $employeeNick = $responseData['employee_nick'];
                    $employeeEmail = $responseData['employee_email'];
                    $employeePhone = $responseData['employee_phone'];
                    $employeeAddress = $responseData['employee_address'];
                    $employeeIm = $responseData['employee_im'];
                    $employeeSkype = $responseData['employee_skype'];
                    $employeeSite = $responseData['employee_site'];
                    $employeeComments = $responseData['employee_comments'];
                    $employeePassport = $responseData['employee_passport'];
                    $employeePosition = $responseData['employee_position'];
                    $employeeCreationDate = date('d.m.Y', strtotime($responseData['employee_creation_date']));
                    $employeeCreationTime = $responseData['employee_creation_time'];
                    $employeeEditDate = date('d.m.Y', strtotime($responseData['employee_edit_date']));
                    $employeeEditTime = $responseData['employee_edit_time'];
                    $employeeStatus = $responseData['employee_status'];
                    
                    if($employeeStatus == 'active')
                    {
                        $emplStatusImg = '<img align="middle" style="width: 16px; height: 16px; cursor: pointer;" alt="Change status" title="Заблокировать" id="blockMe'.$employeeId.'" name="blockMe'.$employeeId.'" border="0" onclick="$(this).ChangeTableDataStatus(\''.$employeeId.'\', \'employees\', \'employee_status\', \'employee_id\');" src="./img/portal_deactivate.gif" />';
                        $fontColor = '#000000';
                    }
                    else
                    {
                        $emplStatusImg = '<img align="middle" style="width: 13px; height: 13px; cursor: pointer;" alt="Change status" title="Активировать" id="activateMe'.$employeeId.'" name="activateMe'.$employeeId.'" border="0" onclick="$(this).ChangeTableDataStatus(\''.$employeeId.'\', \'employees\', \'employee_status\', \'employee_id\');" src="./img/portal_key.gif" />';
                        $fontColor = '#C0C0C0';
                    }
                    
                    $responseTableData .= '<tr><td><font color="'.$fontColor.'">'.$employeeCode.'</font></td><td><font color="'.$fontColor.'">'.$employeeNick.'</font></td><td><font color="'.$fontColor.'"><a href="./" style="color: '.$fontColor.';" onclick="$(this).ViewCurrentEmplDetails(\''.$employeeId.'\', \''.$employeeCode.'\', \''.$employeeFn.'\', \''.$employeeLn.'\', \''.$employeeMn.'\', \''.$employeeBirthDate.'\', \''.$employeePosition.'\', \''.$employeePassport.'\', \''.$employeeNick.'\', \''.$employeeEmail.'\', \''.$employeePhone.'\', \''.$employeeAddress.'\', \''.$employeeIm.'\', \''.$employeeSkype.'\', \''.$employeeSite.'\', \''.$employeeComments.'\', \''.$employeeCreationDate.' - '.$employeeCreationTime.'\', \''.$employeeEditDate.' - '.$employeeEditTime.'\', \''.$employeeStatus.'\'); return false;">'.$employeeLn.' '.$employeeFn.' '.$employeeMn.'</a></font></td><td><font color="'.$fontColor.'">'.$employeeBirthDate.'</font></td><td><font color="'.$fontColor.'">'.$employeePassport.'</font></td><td><font color="'.$fontColor.'">'.$employeePhone.'</font></td><td><font color="'.$fontColor.'">'.$employeePosition.'</font></td><td>'.$emplStatusImg.'</td></tr>';
				}
            }
            else
            {
                $responseTableData = '<tr><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td></tr>';
            }
        }
        else
        {
            $responseTableData = '<tr><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td></tr>';
        }
        
        return $responseTableData;
    }
    
    // Setting employee data
    function SetEmployeeData($emplId, $emplKey, $emplFn, $emplLn, $emplMn, $emplBd, $emplPosition, $emplPassport, $emplNick, $emplEmail, $emplPhone, $emplAddress, $emplIm, $emplSkype, $emplSite, $emplComments)
    {
		if($emplId == '')
		{
			$setEmployeeDataRequest = mysql_query("INSERT INTO employees VALUES (NULL, \"$emplFn\", \"$emplLn\", \"$emplMn\", STR_TO_DATE(\"$emplBd\", \"%d.%m.%Y\"), \"$emplKey\", \"$emplNick\", \"$emplEmail\", \"$emplPhone\", \"$emplAddress\", \"$emplIm\", \"$emplSkype\", \"$emplSite\", \"$emplComments\", \"$emplPassport\", \"$emplPosition\", CURDATE(), CURTIME(), CURDATE(), CURTIME(), \"active\")") or die(ErrorHandler('mysql', mysql_error()));
		}
		else
		{
			$setEmployeeDataRequest = mysql_query("UPDATE employees SET employees.employee_fn=\"$emplFn\", employees.employee_ln=\"$emplLn\", employees.employee_mn=\"$emplMn\", employees.employee_birth_date=STR_TO_DATE(\"$emplBd\", \"%d.%m.%Y\"), employees.employee_code=\"$emplKey\", employees.employee_nick=\"$emplNick\", employees.employee_email=\"$emplEmail\", employees.employee_phone=\"$emplPhone\", employees.employee_address=\"$emplAddress\", employees.employee_im=\"$emplIm\", employees.employee_skype=\"$emplSkype\", employees.employee_site=\"$emplSite\", employees.employee_comments=\"$emplComments\", employees.employee_passport=\"$emplPassport\", employees.employee_position=\"$emplPosition\", employees.employee_edit_date=CURDATE(), employees.employee_edit_time=CURTIME() WHERE employees.employee_id=\"$emplId\"") or die(ErrorHandler('mysql', mysql_error()));
		}
    }
    
    // Setting work data
    function SetWorkData($workId, $workKey, $workCategory, $workValue, $workPrice)
    {
		if($workId == '')
		{
			$setWorkDataRequest = mysql_query("INSERT INTO list_of_works VALUES (NULL, \"$workKey\", \"$workCategory\", \"$workValue\", \"$workPrice\", CURDATE(), CURTIME(), CURDATE(), CURTIME(), \"active\")") or die(ErrorHandler('mysql', mysql_error()));
		}
		else
		{
			$setWorkDataRequest = mysql_query("UPDATE list_of_works SET list_of_works.work_key=\"$workKey\", list_of_works.work_category=\"$workCategory\", list_of_works.work_value=\"$workValue\", list_of_works.work_price=\"$workPrice\", list_of_works.work_edit_date=CURDATE(), list_of_works.work_edit_time=CURTIME() WHERE list_of_works.work_id=\"$workId\"") or die(ErrorHandler('mysql', mysql_error()));
		}
    }
    
    // Change table data status
    function ChangeTableDataStatus($targetId, $targetTable, $targetStatusField, $targetIdField)
    {
        $getStatusValueRequest = mysql_query("SELECT $targetTable.$targetStatusField FROM $targetTable WHERE $targetTable.$targetIdField=\"$targetId\"") or die(ErrorHandler('mysql', mysql_error()));
        while ($statusValueRow = mysql_fetch_array($getStatusValueRequest, MYSQL_BOTH))
        {
            $dataStatus = $statusValueRow[$targetStatusField];
        }
        
        if($dataStatus == 'active')
        {
            $changeStatusRequest = mysql_query("UPDATE $targetTable SET $targetTable.$targetStatusField=\"blocked\" WHERE $targetTable.$targetIdField=\"$targetId\"") or die(ErrorHandler('mysql', mysql_error()));
        }
        else
        {
            $changeStatusRequest = mysql_query("UPDATE $targetTable SET $targetTable.$targetStatusField=\"active\" WHERE $targetTable.$targetIdField=\"$targetId\"") or die(ErrorHandler('mysql', mysql_error()));
        }
        
        if($targetTable == 'cars')
        {
            $totalDataCount = GetCountTotalTableData(ClearMySqlVariables('cars_customers_connections'), '');
        
            if($totalDataCount != '0')
            {
                $getCarCustomerConnectionDataQuery = mysql_query("SELECT COUNT(1) FROM cars_customers_connections WHERE car_id=\"$targetId\"") or die(ErrorHandler('mysql', mysql_error()));
                
                if($getCarCustomerConnectionDataQuery != null)
                {
                    $getConnectionStatusValueRequest = mysql_query("SELECT cars_customers_connections.connect_status FROM cars_customers_connections WHERE car_id=\"$targetId\"") or die(ErrorHandler('mysql', mysql_error()));
                    while ($statusValueRow = mysql_fetch_array($getConnectionStatusValueRequest, MYSQL_BOTH))
                    {
                        $dataStatus = $statusValueRow['connect_status'];
                    }
                    
                    if($dataStatus == 'active')
                    {
                        $changeConnectionStatusRequest = mysql_query("UPDATE cars_customers_connections SET cars_customers_connections.connect_status=\"blocked\" WHERE car_id=\"$targetId\"") or die(ErrorHandler('mysql', mysql_error()));
                    }
                    else
                    {
                        $changeConnectionStatusRequest = mysql_query("UPDATE cars_customers_connections SET cars_customers_connections.connect_status=\"active\" WHERE car_id=\"$targetId\"") or die(ErrorHandler('mysql', mysql_error()));
                    }
                }
            }
        }
        
        if($targetTable == 'customers')
        {
            $totalDataCount = GetCountTotalTableData(ClearMySqlVariables('cars_customers_connections'), '');
        
            if($totalDataCount != '0')
            {
                $getCarCustomerConnectionDataQuery = mysql_query("SELECT COUNT(1) FROM cars_customers_connections WHERE customer_id=\"$targetId\"") or die(ErrorHandler('mysql', mysql_error()));
                
                if($getCarCustomerConnectionDataQuery != null)
                {
                    $getConnectionStatusValueRequest = mysql_query("SELECT cars_customers_connections.connect_status FROM cars_customers_connections WHERE customer_id=\"$targetId\"") or die(ErrorHandler('mysql', mysql_error()));
                    while ($statusValueRow = mysql_fetch_array($getConnectionStatusValueRequest, MYSQL_BOTH))
                    {
                        $dataStatus = $statusValueRow['connect_status'];
                    }
                    
                    if($dataStatus == 'active')
                    {
                        $changeConnectionStatusRequest = mysql_query("UPDATE cars_customers_connections SET cars_customers_connections.connect_status=\"blocked\" WHERE customer_id=\"$targetId\"") or die(ErrorHandler('mysql', mysql_error()));
                    }
                    else
                    {
                        $changeConnectionStatusRequest = mysql_query("UPDATE cars_customers_connections SET cars_customers_connections.connect_status=\"active\" WHERE customer_id=\"$targetId\"") or die(ErrorHandler('mysql', mysql_error()));
                    }
                }
            }
        }
    }
    
    // Get system works list
    function GetSystemWorksList($searchData)
    {
        $responseTableData = '';
        
        if($searchData != '')
        {
            $searchParam = "WHERE (list_of_works.work_key LIKE '%$searchData%' OR list_of_works.work_category LIKE '%$searchData%' OR list_of_works.work_value LIKE '%$searchData%' OR list_of_works.work_price LIKE '%$searchData%')";
        }
        else
        {
            $searchParam = "";
        }
        
        $totalDataCount = GetCountTotalTableData(ClearMySqlVariables('list_of_works'), $searchParam);
        
        if($totalDataCount != '0')
        {
            $getSystemWorksDataQuery = mysql_query("SELECT * FROM list_of_works ".$searchParam." ORDER BY list_of_works.work_category, list_of_works.work_value") or die(ErrorHandler('mysql', mysql_error()));
            $getSystemWorksCount = mysql_num_rows($getSystemWorksDataQuery);
            
            if(($getSystemWorksDataQuery != null) && $getSystemWorksCount != '0')
            {
                while($responseData = mysql_fetch_array($getSystemWorksDataQuery, MYSQL_BOTH))
				{
                    $workId = $responseData['work_id'];
                    $workKey = $responseData['work_key'];
                    $workCategory = $responseData['work_category'];
                    $workValue = $responseData['work_value'];
                    $workPrice = $responseData['work_price'];
                    $workCreationDate = date('d.m.Y', strtotime($responseData['work_creation_date']));
                    $workCreationTime = $responseData['work_creation_time'];
                    $workEditDate = date('d.m.Y', strtotime($responseData['work_edit_date']));
                    $workEditTime = $responseData['work_edit_time'];
                    $workStatus = $responseData['work_status'];
                    
                    if($workStatus == 'active')
                    {
                        $workStatusImg = '<img align="middle" style="width: 16px; height: 16px; cursor: pointer;" alt="Change status" title="Заблокировать" id="blockMe'.$workId.'" name="blockMe'.$workId.'" border="0" onclick="$(this).ChangeTableDataStatus(\''.$workId.'\', \'list_of_works\', \'work_status\', \'work_id\');" src="./img/portal_deactivate.gif" />';
                        $fontColor = '#000000';
                    }
                    else
                    {
                        $workStatusImg = '<img align="middle" style="width: 13px; height: 13px; cursor: pointer;" alt="Change status" title="Активировать" id="activateMe'.$workId.'" name="activateMe'.$workId.'" border="0" onclick="$(this).ChangeTableDataStatus(\''.$workId.'\', \'list_of_works\', \'work_status\', \'work_id\');" src="./img/portal_key.gif" />';
                        $fontColor = '#C0C0C0';
                    }
                    
                    $responseTableData .= '<tr><td><font color="'.$fontColor.'">'.$workKey.'</font></td><td><font color="'.$fontColor.'">'.$workCategory.'</font></td><td><font color="'.$fontColor.'"><a href="./" style="color: '.$fontColor.';" onclick="$(this).ViewCurrentWorkDetails(\''.$workId.'\', \''.$workKey.'\', \''.$workCategory.'\', \''.$workValue.'\', \''.$workPrice.'\', \''.$workCreationDate.' - '.$workCreationTime.'\', \''.$workEditDate.' - '.$workEditTime.'\', \''.$workStatus.'\'); return false;">'.$workValue.'</a></font></td><td><font color="'.$fontColor.'">'.$workPrice.'</font></td><td>'.$workStatusImg.'</td></tr>';
				}
            }
            else
            {
                $responseTableData = '<tr><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td></tr>';
            }
        }
        else
        {
            $responseTableData = '<tr><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td></tr>';
        }
        
        return $responseTableData;
    }
    
    // Setting value setter
    function SetSettingValue($settingName, $settingKey, $settingValue)
    {
        $setSettingValueRequest = mysql_query("UPDATE common_settings SET common_settings.setting_value=\"$settingValue\" WHERE common_settings.setting_name=\"$settingName\" AND common_settings.setting_key=\"$settingKey\"") or die(ErrorHandler('mysql', mysql_error()));
    }
    
    // Setting value getter
    function GetSettingValue($settingName, $settingKey)
    {        
        $getSettingValueRequest = mysql_query("SELECT common_settings.setting_value FROM common_settings WHERE common_settings.setting_name=\"$settingName\" AND common_settings.setting_key=\"$settingKey\"") or die(ErrorHandler('mysql', mysql_error()));
        
        if($getSettingValueRequest != null)
		{
            while ($settingValueRow = mysql_fetch_array($getSettingValueRequest, MYSQL_BOTH))
            {
                $portalSettingValue = $settingValueRow['setting_value'];
            }
		}
		else
		{
			$portalSettingValue = '<!-- NULL -->';
		}
        
        return $portalSettingValue;
    }
    
    // Clear table data
    function ClearTableData($targetTable)
    {
        $clearTableDataQuery = mysql_query("TRUNCATE TABLE ".$targetTable) or die(ErrorHandler('mysql', mysql_error()));
    }
    
    // Get system logs list
    function GetSystemLogsList($searchData, $searchDateFrom, $searchDateTo)
    {
        $responseTableData = '';
        
        $searchParam = "";

        if(($searchData != '') && ($searchDateFrom == '' || $searchDateTo == ''))
        {
            $searchParam = "";
            
            $searchParamData = "system_logs.log_sub_system LIKE '%$searchData%' OR system_logs.log_value LIKE '%$searchData%' OR system_logs.log_user LIKE '%$searchData%'";
            $searchParam = "WHERE ".$searchParamData;
        }
        
        if(($searchData != '') && ($searchDateFrom != '') && ($searchDateTo != ''))
        {
            $searchParam = "";
            
            $searchParamData = "system_logs.log_sub_system LIKE '%$searchData%' OR system_logs.log_value LIKE '%$searchData%' OR system_logs.log_user LIKE '%$searchData%'";
            $searchParam = "WHERE (".$searchParamData.")";
            
            $searchParamDateFrom = "STR_TO_DATE(\"$searchDateFrom\", \"%d.%m.%Y\")";
            $searchParam .= " AND (system_logs.log_date BETWEEN ".$searchParamDateFrom;

            $searchParamDateTo = "STR_TO_DATE(\"$searchDateTo\", \"%d.%m.%Y\")";
            $searchParam .= " AND ".$searchParamDateTo.")";
        }
        
        if(($searchData == '') && ($searchDateFrom != '') && ($searchDateTo != ''))
        {
            $searchParam = "";
            
            $searchParamDateFrom = "STR_TO_DATE(\"$searchDateFrom\", \"%d.%m.%Y\")";
            $searchParam = "WHERE system_logs.log_date BETWEEN ".$searchParamDateFrom;

            $searchParamDateTo = "STR_TO_DATE(\"$searchDateTo\", \"%d.%m.%Y\")";
            $searchParam .= " AND ".$searchParamDateTo;
        }
        
        $totalEventsCount = GetCountTotalTableData(ClearMySqlVariables('system_logs'), $searchParam);
        
        if($totalEventsCount != '0')
        {
            $getSystemLogsDataQuery = mysql_query("SELECT * FROM system_logs ".$searchParam." ORDER BY system_logs.log_date DESC, system_logs.log_time DESC") or die(ErrorHandler('mysql', mysql_error()));
            $getSystemLogsCount = mysql_num_rows($getSystemLogsDataQuery);
            
            if(($getSystemLogsDataQuery != null) && $getSystemLogsCount != '0')
            {
                while($responseData = mysql_fetch_array($getSystemLogsDataQuery, MYSQL_BOTH))
				{
				    $eventDate = date('d.m.Y', strtotime($responseData['log_date']));
                    $eventTime = $responseData['log_time'];
                    $eventSubSystem = $responseData['log_sub_system'];
                    $eventValue = $responseData['log_value'];
                    $eventUser = $responseData['log_user'];
                    
                    $responseTableData .= '<tr><td>'.$eventDate.'</td><td>'.$eventTime.'</td><td>'.$eventSubSystem.'</td><td>'.$eventValue.'</td><td>'.$eventUser.'</td></tr>';
				}
            }
            else
            {
                $responseTableData = '<tr><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td></tr>';
            }
        }
        else
        {
            $responseTableData = '<tr><td>---</td><td>---</td><td>---</td><td>---</td><td>---</td></tr>';
        }
        
        return $responseTableData;
    }
    
    // Get chart plotting start date
    function GetChartPlottingStartDate($lastDaysPeriod)
    {
        $responseChartStartDate = '';
        
		if(($lastDaysPeriod == '') || ($lastDaysPeriod == null) || !is_numeric($lastDaysPeriod))
		{
			$responseChartStartDate = date('M d, Y', strtotime('-7 day'));
		}
		else
		{
			$lastDaysPeriod = $lastDaysPeriod + 1;
			$responseChartStartDate = date('M d, Y', strtotime('-'.$lastDaysPeriod.' day'));
		}
		
		return $responseChartStartDate;
	}
	
	// Get customers data for chart plotting
	function GetCustomersChartData($lastDaysPeriod)
	{
		if(($lastDaysPeriod == '') || ($lastDaysPeriod == null) || !is_numeric($lastDaysPeriod))
		{
			$responseCustomerChartData = '';
			
			for($previousDayCount = 0; $previousDayCount <= 6; $previousDayCount++)
			{
				$customersCount = '0';
				$dateBuffer = date('Y-m-d', strtotime('-'.$previousDayCount.' day'));
				
				$getCustomersCountQuery = mysql_query("SELECT COUNT(1) FROM customers WHERE customers.customer_creation_date='".$dateBuffer."'") or die(ErrorHandler('mysql', mysql_error()));
			
				if($getCustomersCountQuery != null)
				{
					while ($responseCountData = mysql_fetch_array($getCustomersCountQuery, MYSQL_BOTH))
					{
						$customersCount = $responseCountData[0];
					}
					
					$responseCustomerChartData .= '["'.$dateBuffer.'",'.$customersCount.'],';
				}
				else
				{
					$customersCount = '0';
					$responseCustomerChartData .= '["'.$dateBuffer.'",'.$customersCount.'],';
				}
			}
		}
		else
		{
			$responseCustomerChartData = '';
			
			for($previousDayCount = 0; $previousDayCount <= $lastDaysPeriod; $previousDayCount++)
			{
				$customersCount = '0';
				$dateBuffer = date('Y-m-d', strtotime('-'.$previousDayCount.' day'));
				
				$getCustomersCountQuery = mysql_query("SELECT COUNT(1) FROM customers WHERE customers.customer_creation_date='".$dateBuffer."'") or die(ErrorHandler('mysql', mysql_error()));
			
				if($getCustomersCountQuery != null)
				{
					while ($responseCountData = mysql_fetch_array($getCustomersCountQuery, MYSQL_BOTH))
					{
						$customersCount = $responseCountData[0];
					}
					
					$responseCustomerChartData .= '["'.$dateBuffer.'",'.$customersCount.'],';
				}
				else
				{
					$customersCount = '0';
					$responseCustomerChartData .= '["'.$dateBuffer.'",'.$customersCount.'],';
				}
			}
		}
		
		$responseCustomerChartData = substr($responseCustomerChartData, 0, strlen($responseCustomerChartData) - 1);
		
		return $responseCustomerChartData;
	}
	
	// Get orders data for chart plotting
	function GetOrdersChartData($lastDaysPeriod)
	{
		if(($lastDaysPeriod == '') || ($lastDaysPeriod == null) || !is_numeric($lastDaysPeriod))
		{
			$responseOrderChartData = '';
			
			for($previousDayCount = 0; $previousDayCount <= 6; $previousDayCount++)
			{
				$ordersCount = '0';
				$dateBuffer = date('Y-m-d', strtotime('-'.$previousDayCount.' day'));
				
				$getOrdersCountQuery = mysql_query("SELECT COUNT(1) FROM purchase_orders WHERE purchase_orders.order_creation_date='".$dateBuffer."'") or die(ErrorHandler('mysql', mysql_error()));
			
				if($getOrdersCountQuery != null)
				{
					while ($responseCountData = mysql_fetch_array($getOrdersCountQuery, MYSQL_BOTH))
					{
						$ordersCount = $responseCountData[0];
					}
					
					$responseOrderChartData .= '["'.$dateBuffer.'",'.$ordersCount.'],';
				}
				else
				{
					$ordersCount = '0';
					$responseOrderChartData .= '["'.$dateBuffer.'",'.$ordersCount.'],';
				}
			}
		}
		else
		{
			$responseOrderChartData = '';
			
			for($previousDayCount = 0; $previousDayCount <= $lastDaysPeriod; $previousDayCount++)
			{
				$ordersCount = '0';
				$dateBuffer = date('Y-m-d', strtotime('-'.$previousDayCount.' day'));
				
				$getOrdersCountQuery = mysql_query("SELECT COUNT(1) FROM purchase_orders WHERE purchase_orders.order_creation_date='".$dateBuffer."'") or die(ErrorHandler('mysql', mysql_error()));
			
				if($getOrdersCountQuery != null)
				{
					while ($responseCountData = mysql_fetch_array($getOrdersCountQuery, MYSQL_BOTH))
					{
						$ordersCount = $responseCountData[0];
					}
					
					$responseOrderChartData .= '["'.$dateBuffer.'",'.$ordersCount.'],';
				}
				else
				{
					$ordersCount = '0';
					$responseOrderChartData .= '["'.$dateBuffer.'",'.$ordersCount.'],';
				}
			}
		}
		
		$responseOrderChartData = substr($responseOrderChartData, 0, strlen($responseOrderChartData) - 1);
		
		return $responseOrderChartData;
	}
	
	// Get count active table data
    function GetCountActiveTableData($targetTable, $statusField, $targetCondition)
    {
        if (trim($targetCondition) == '')
        {
            $targetCondition = "WHERE (1)";
        }
        
        $getTableDataCountQuery = mysql_query("SELECT COUNT(1) FROM ".$targetTable." ".$targetCondition." AND ".$statusField."=\"active\"") or die(ErrorHandler('mysql', mysql_error()));
		
		if($getTableDataCountQuery != null)
		{
			while ($responseCountData = mysql_fetch_array($getTableDataCountQuery, MYSQL_BOTH))
			{
				$responseTableDataCount = $responseCountData[0];
			}
		}
		else
		{
			$responseTableDataCount = '0';
		}
		
		return $responseTableDataCount;
    }
    
    // Get count blocked table data
    function GetCountBlockedTableData($targetTable, $statusField, $targetCondition)
    {
        if (trim($targetCondition) == '')
        {
            $targetCondition = "WHERE (1)";
        }
        
        $getTableDataCountQuery = mysql_query("SELECT COUNT(1) FROM ".$targetTable." ".$targetCondition." AND ".$statusField."=\"blocked\" OR ".$statusField."=\"\"") or die(ErrorHandler('mysql', mysql_error()));
		
		if($getTableDataCountQuery != null)
		{
			while ($responseCountData = mysql_fetch_array($getTableDataCountQuery, MYSQL_BOTH))
			{
				$responseTableDataCount = $responseCountData[0];
			}
		}
		else
		{
			$responseTableDataCount = '0';
		}
		
		return $responseTableDataCount;
    }
    
    // Get table total data count
    function GetCountTotalTableData($targetTable, $targetCondition)
    {
        $getTableDataCountQuery = mysql_query("SELECT COUNT(1) FROM ".$targetTable." ".$targetCondition) or die(ErrorHandler('mysql', mysql_error()));
		
		if($getTableDataCountQuery != null)
		{
			while ($responseCountData = mysql_fetch_array($getTableDataCountQuery, MYSQL_BOTH))
			{
				$responseTableDataCount = $responseCountData[0];
			}
		}
		else
		{
			$responseTableDataCount = '0';
		}
		
		return $responseTableDataCount;
    }
	
    // Language switching
    function SwitchLanguage($userLanguage)
    {
        setcookie('userLanguage', '', time() - 60 * 60 * 24 * 500, '/');
        setcookie('userLanguage', $userLanguage, time() + 60 * 60 * 24 * 500, '/');   
    }
    
    // Event logger
    function EventLogger($eventDate, $eventTime, $eventSubSystem, $eventUser, $eventValue)
    {
        $eventValue = ClearMySqlVariables($eventValue);
        $eventDate = ClearMySqlVariables($eventDate);
        $eventTime = ClearMySqlVariables($eventTime);
        $eventSubSystem = ClearMySqlVariables($eventSubSystem);
        $eventUser = ClearMySqlVariables($eventUser);
        
        $logIp = GetUserIp();
        $logServerAddress = $_SERVER['SERVER_ADDR'];
        $logServerName = $_SERVER['SERVER_NAME'];
        $logServerSoft = $_SERVER['SERVER_SOFTWARE'];
        $logServerProtocol = $_SERVER['SERVER_PROTOCOL'];
        $logServerRequestMethod = $_SERVER['REQUEST_METHOD'];
        $logServerDocRoot = $_SERVER['DOCUMENT_ROOT'];
        $logHttpHost = $_SERVER['HTTP_HOST'];
        $logHttpReferer = $_SERVER['HTTP_REFERER'];
        $logHttpUserAgent = $_SERVER['HTTP_USER_AGENT'];        
        $logHttpAccept = $_SERVER['HTTP_ACCEPT'];
        $logHttpAcceptCharset = $_SERVER['HTTP_ACCEPT_CHARSET'];
        $logHttpAcceptEncoding = $_SERVER['HTTP_ACCEPT_ENCODING'];
        $logHttpAcceptLanguage = $_SERVER['HTTP_ACCEPT_LANGUAGE'];        
        $logRemoteHost = $_SERVER['REMOTE_HOST'];
        $logRemotePort = $_SERVER['REMOTE_PORT'];
        $logScriptFileName = $_SERVER['SCRIPT_FILENAME'];
        $logRequestUri = $_SERVER['REQUEST_URI'];
        
        $logValue = 'Request IP: '.$logIp
                    .'<br />Server Address: '.$logServerAddress
                    .'<br />Server Name: '.$logServerName
                    .'<br />Server Soft: '.$logServerSoft
                    .'<br />Server Protocol: '.$logServerProtocol
                    .'<br />Server Request Method: '.$logServerRequestMethod
                    .'<br />Server Document Root: '.$logServerDocRoot
                    .'<br />Http Host: '.$logHttpHost
                    .'<br />Http Referer: '.$logHttpReferer
                    .'<br />Http User Agent: '.$logHttpUserAgent
                    .'<br />Http Accept: '.$logHttpAccept
                    .'<br />Http Accept Charset: '.$logHttpAcceptCharset
                    .'<br />Http Accept Encoding: '.$logHttpAcceptEncoding
                    .'<br />Http Accept Language: '.$logHttpAcceptLanguage
                    .'<br />Remote Host: '.$logRemoteHost
                    .'<br />Remote Port: '.$logRemotePort
                    .'<br />Script File Name: '.$logScriptFileName
                    .'<br />Request Uri: '.$logRequestUri
                    .'<br />Log details: '.$eventValue
                    .'<br />';
        
        if($eventUser == '')
        {
            $eventUser = 'System';
        }
        
        if($eventDate == '')
        {
            $eventDate = "CURDATE()";
        }
        else
        {
            $eventDate = "\"$eventDate\"";
        }
        
        if($eventTime == '')
        {
            $eventTime = "CURTIME()";
        }
        else
        {
            $eventTime = "\"$eventTime\"";
        }
        
        $saveEventLogQuery = mysql_query("INSERT INTO system_logs VALUES (NULL, ".$eventDate.", ".$eventTime.", \"$eventSubSystem\", \"$logValue\", \"$eventUser\")") or die(ErrorHandler('mysql', mysql_error()));
    }
    
    // Getting user IP
    function GetUserIp()
    {
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"),"unknown"))
            $ip = getenv("HTTP_CLIENT_IP");
        elseif (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        elseif (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
            $ip = getenv("REMOTE_ADDR");
        elseif (!empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
            $ip = $_SERVER['REMOTE_ADDR'];  
        else
            $ip = "unknown";  
        
        return $ip;
    }
    
    // Clearing of the MySQL variables
    function ClearMySqlVariables($variableForMysql)
    {
        $variableForMysql = ClearCommonVariables($variableForMysql);
        $variableForMysql = mysql_real_escape_string($variableForMysql);
        
        return $variableForMysql;
    }
    
    // Clearing of the common variables
    function ClearCommonVariables($variable)
    {
        $variable = stripslashes($variable);
        $variable = htmlentities($variable, ENT_QUOTES, 'UTF-8');
        $variable = strip_tags($variable);
        $variable = trim($variable);
        
        return $variable;
    }
    
    // Error handling
    function ErrorHandler($errorCode, $errorValue)
    {
        print('<meta http-equiv="refresh" content="0; url=./error/?code='.trim($errorCode).'&value='.trim($errorValue).'" />');
    }
    
    // Get language from user browser locale
    function GetUserLocaleLanguage()
    {
        if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
        {
            $userLang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
            
            if(preg_match('/ru-RU/i', $userLang))
            {
                $userLang = 'ru';
            }
                    
            if(preg_match('/uk-UA/i', $userLang))
            {
                $userLang = 'ua';
            }
        }
        else
        {
            $userLang = 'ru';
        }
        
        return $userLang;
    }
 
    // IP to number
    function Ip2Int($ip)
    {
        $part = explode(".", $ip);
        $int = 0;
        if (count($part) == 4) {
            $int = $part[3] + 256 * ($part[2] + 256 * ($part[1] + 256 * $part[0]));
        }
        return $int;
    }
    
    // Number to IP
    function Int2Ip($int)
    {
        $w = $int / 16777216 % 256;
        $x = $int / 65536 % 256;
        $y = $int / 256 % 256;
        $z = $int % 256;
        $z = $z < 0 ? $z + 256 : $z;
        return "$w.$x.$y.$z";
    }
?>