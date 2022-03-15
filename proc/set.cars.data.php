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
    
    if((!isset($_POST['carsVin'])) || (!isset($_POST['carsLP'])) || (!isset($_POST['carsModel'])) || (!isset($_POST['carsYear'])) || (!isset($_POST['carsEv'])) || (!isset($_POST['carsNick'])) || (!isset($_POST['carsKey'])) || (!isset($_POST['carsColor']))){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    if((trim($_POST['carsVin']) == '') || (trim($_POST['carsLP']) == '') || (trim($_POST['carsModel']) == '') || (trim($_POST['carsYear']) == '') || (trim($_POST['carsEv']) == '') || (trim($_POST['carsNick']) == '') || (trim($_POST['carsKey']) == '') || (trim($_POST['carsColor']) == '')){
		print('./error/?code=common&value='.trim($melkovTranslation['scriptExecutionErrorLabel4001']));
		exit();
    }
    
    $carsId = ClearMySqlVariables($_POST['carsId']);
    $carsVin = ClearMySqlVariables($_POST['carsVin']);
    $carsLP = ClearMySqlVariables($_POST['carsLP']);
    $carsModel = ClearMySqlVariables($_POST['carsModel']);
    $carsYear = ClearMySqlVariables($_POST['carsYear']);
    $carsEv = ClearMySqlVariables($_POST['carsEv']);
    $carsColor = ClearMySqlVariables($_POST['carsColor']);
    $carsNick = ClearMySqlVariables($_POST['carsNick']);
    $carsKey = ClearMySqlVariables($_POST['carsKey']);
    $carsComments = ClearMySqlVariables($_POST['carsComments']);
    
    SetCarsData($carsId, $carsVin, $carsLP, $carsModel, $carsYear, $carsNick, $carsKey, $carsComments, $carsEv, $carsColor);
    
    EventLogger('', '', 'Cars data setting', '', 'carsId='.$carsId);
    
    $userHttpReferer = ClearCommonVariables($_SERVER['HTTP_REFERER']);
    
    print($userHttpReferer);
?>