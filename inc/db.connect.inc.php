<?php
/**
 * @author Sergey Shimkiv
 * @copyright 2011
 */
 
    $dbHost = 'sql11.freemysqlhosting.net:3306';
    $dbUser = 'sql11479167';
    $dbPass = 'KNGqAR16jk';
    $dbName = 'sql11479167';

    $dbConnectionLink = mysql_connect($dbHost, $dbUser, $dbPass) or die(ErrorHandler('mysql', mysql_error()));
    mysql_set_charset('utf8', $dbConnectionLink);
    mysql_select_db($dbName);    
?>