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
    
    if(!isset($_POST['carId'])){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    if(trim($_POST['carId']) == ''){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    $responseData = '';
    
    $carId = ClearMySqlVariables($_POST['carId']); 
    
    $responseDataBuffer = '';
        
    $getSystemDataQuery = mysql_query("SELECT * FROM cars WHERE cars.car_status=\"active\" AND cars.car_id=\"$carId\" ORDER BY cars.car_vin") or die(ErrorHandler('mysql', mysql_error()));
    $getSystemCount = mysql_num_rows($getSystemDataQuery);
    
    if(($getSystemDataQuery != null) && $getSystemCount != '0')
    {
        while($responseData = mysql_fetch_array($getSystemDataQuery, MYSQL_BOTH))
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
            
            $nextButton = '<script type="text/javascript">$("#orderCreationCarNextStep").button(); $(\'#currentCarsKm\').removeAttr(\'disabled\');</script><div id="carNextButtonContainer"><br /><div style="float: left;"><label for="currentCarsKm" id="currentCarsKmLabel">'.$melkovTranslation['carsDialogKmLabel'].'</label><br /><input style="width: 200px;" type="text" id="currentCarsKm" name="currentCarsKm" value="'.$carMileage.'" class="input" maxlength="254"  onkeyup="if($.trim($(\'#currentCarsKm\').val()) != \'\'){$(\'#currentCarsKm\').css(\'background-color\', \'#FFFFFF\');}else{$(\'#currentCarsKm\').css(\'background-color\', \'#FFDBDB\');}" onfocus="with(this){ if (value != \'\'){$(\'#currentCarsKm\').css(\'background-color\', \'#FFFFFF\');}else{$(\'#currentCarsKm\').css(\'background-color\', \'#FFDBDB\');}}" onblur="with(this){$(\'#currentCarsKm\').css(\'background-color\', \'#FFFFFF\');}" /></div><br /><div id="orderCreationCarNextStep" style="float: right;" onclick="$(this).GetOrderWorksVisible();">'.$melkovTranslation['ordersDialogNextButtonLabel'].'</div></div>';
            
            $responseDataBuffer .= $melkovTranslation['carsDialogKeyLabel'].$carCode.'; '.$melkovTranslation['carsDialogVinLabel'].$carVin.'; '.$melkovTranslation['carsDialogModelLabel'].$carModel.'; '.$melkovTranslation['carsDialogYearLabel'].$carYear.'; '.$melkovTranslation['carsDialogEvLabel'].$carEv.'; '.$melkovTranslation['carsDialogColorLabel'].$carColor.'; '.$melkovTranslation['carsDialogNickLabel'].$carNick.'; '.$melkovTranslation['carsDialogCommentsLabel'].$carComments.'; '.$melkovTranslation['carsDialogCreationDateLabel'].$carCreationDate.' - '.$carCreationTime.'; '.$nextButton;
        }
    }
    
    print($responseDataBuffer);
?>