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
    
    if(!isset($_POST['customerId'])){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    if(trim($_POST['customerId']) == ''){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    $responseData = '';
    
    $customerId = ClearMySqlVariables($_POST['customerId']); 
    
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
            
            $nextButton = '<script type="text/javascript">$("#orderCreationCustomerNextStep").button();</script><div id="customerNextButtonContainer"><br /><div id="orderCreationCustomerNextStep" style="float: right; vertical-align: top;" onclick="$(this).GetCustomerCarsList($(\'#customerSelection\').val());">'.$melkovTranslation['ordersDialogNextButtonLabel'].'</div></div>';
            
            $responseDataBuffer .= $melkovTranslation['custDialogKeyLabel'].$customerCode.'; '.$melkovTranslation['custDialogNickLabel'].$customerNick.'; '.$melkovTranslation['custDialogEmailLabel'].$customerEmail.'; '.$melkovTranslation['custDialogPhoneLabel'].$customerPhone.'; '.$melkovTranslation['custDialogAddressLabel'].$customerAddress.'; '.$melkovTranslation['custDialogImLabel'].$customerIm.'; '.$melkovTranslation['custDialogSkypeLabel'].$customerSkype.'; '.$melkovTranslation['custDialogSiteLabel'].$customerSite.'; '.$melkovTranslation['custDialogCommentsLabel'].$customerComments.'; '.$melkovTranslation['custDialogDebtLabel'].'<font color="red">'.$customerDebt.'</font>; '.$melkovTranslation['custDialogCreationDateLabel'].$customerCreationDate.' - '.$customerCreationTime.$nextButton;
        }
    }
    
    print($responseDataBuffer);
?>