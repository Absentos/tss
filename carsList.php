<?php
/**
 * @author Sergey Shimkiv
 * @copyright 2011
 */
    
    require_once('./inc/melkov.core.php');
    require_once('./inc/db.connect.inc.php');
    require_once('./inc/recaptchalib.php');
    require_once('./_header.php');
    
    if(isset($_GET['searchData']))
    {
		$searchData = ClearMySqlVariables($_GET['searchData']);
    }
    else
    {
        $searchData = ClearMySqlVariables('');
    }
    
    if($searchData != '')
    {
        $searchParam = "WHERE (cars.car_model LIKE '%$searchData%' OR cars.car_year LIKE '%$searchData%' OR cars.car_vin LIKE '%$searchData%' OR cars.car_license_plates LIKE '%$searchData%' OR cars.car_mileage LIKE '%$searchData%' OR cars.car_code LIKE '%$searchData%' OR cars.car_nick LIKE '%$searchData%' OR cars.car_comments LIKE '%$searchData%' OR cars.car_ev LIKE '%$searchData%' OR cars.car_color LIKE '%$searchData%')";
    }
    else
    {
        $searchParam = "";
    }
    
    $viewSystemCarsTotalActive = GetCountActiveTableData(ClearMySqlVariables('cars'), ClearMySqlVariables('car_status'), $searchParam);
    $viewSystemCarsTotalBlocked = GetCountBlockedTableData(ClearMySqlVariables('cars'), ClearMySqlVariables('car_status'), $searchParam);
    $viewSystemCarsTotal = GetCountTotalTableData(ClearMySqlVariables('cars'), $searchParam);
    
    $viewSystemCarsList = GetSystemCarsList($searchData);
?>

<div id="menu" class="clearfix">
    <div id="menu-right">
        <div id="menu-content">
            <ul id="top-menu" class="nav">
                <li id="menu-item-300" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-300"><a href="./"><?php print($melkovTranslation['homeLinkLabel']); ?></a></li>
                <li id="menu-item-301" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-301"><a href="./ordersList.php"><?php print($melkovTranslation['purchaseOrdersLinkLabel']); ?></a></li>
                <li id="menu-item-302" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-302"><a href="./customersList.php"><?php print($melkovTranslation['customersLinkLabel']); ?></a></li>
                <li id="menu-item-303" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item current_page_item menu-item-303"><a href="./carsList.php"><?php print($melkovTranslation['carsLinkLabel']); ?></a></li>
                <li id="menu-item-304" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-304"><a href="./employeesList.php"><?php print($melkovTranslation['employeesLinkLabel']); ?></a></li>
                <li id="menu-item-305" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-305"><a href="./worksList.php"><?php print($melkovTranslation['listOfWorksLinkLabel']); ?></a></li>
                <li id="menu-item-306" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-306"><a href="./logsList.php"><?php print($melkovTranslation['systemLogsLinkLabel']); ?></a></li>
                <li id="menu-item-307" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-307"><a href="./commonSettings.php"><?php print($melkovTranslation['commonSettingsLinkLabel']); ?></a></li>
            </ul>
            <div id="social-icons">
                <a id="langUa" href="./"></a>
                <p style="float: right; padding-top: 10px; padding-right: 7px;"> | </p>
                <a id="langRu" href="./"></a>
            </div>
        </div>	
    </div>		
</div>
<div id="category-name">
    <h1 class="category-title"></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="content">
    <div id="content-shadow">
        <div class="container fullwidth">
            <div id="breadcrumbs">
                <?php print($melkovTranslation['portalName']); ?> <span class="raquo">&raquo;</span> <?php print($melkovTranslation['carsLinkLabel']); ?>
            </div>
            <div id="content-area" class="clearfix">
                <div id="left-area">
                    <div class="entry post clearfix">
                        <label for="searchData" style="font-size: 16px;"><?php print($melkovTranslation['tableSearchLabel']); ?></label>&nbsp;&nbsp;&nbsp;<input style="width: 310px;" type="text" value="<?php print($searchData); ?>" id="searchData" name="searchData" value="" class="input" maxlength="254" onkeyup="if($.trim($('#searchData').val()) != ''){$('#searchData').css('background-color', '#FFFFFF');}else{$('#searchData').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#searchData').css('background-color', '#FFFFFF');}else{$('#searchData').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#searchData').css('background-color', '#FFFFFF');}" />&nbsp;&nbsp;&nbsp;
                        <div id="doSearch"><?php print($melkovTranslation['tableDoSearchLabel']); ?></div>&nbsp;
                        <div id="clearSearch"><?php print($melkovTranslation['tableClearSearchLabel']); ?></div>
                        <br /><br />
                        <table id="viewSystemCarsTable">
                            <thead>
                                <tr><th width="50"><?php print($melkovTranslation['carsTableKeyLabel']); ?></th><th width="100"><?php print($melkovTranslation['carsTableNickLabel']); ?></th><th width="200"><?php print($melkovTranslation['carsTableVinLabel']); ?></th><th width="90"><?php print($melkovTranslation['carsTableYearLabel']); ?></th><th width="150"><?php print($melkovTranslation['carsTableModelLabel']); ?></th><th width="100"><?php print($melkovTranslation['carsTableColorLabel']); ?></th><th width="100"><?php print($melkovTranslation['carsTableLPLabel']); ?></th><th width="40"><?php print($melkovTranslation['carsTableStatusLabel']); ?></th></tr>
                            </thead>
                            <tbody id="viewSystemCarsTableBody">        
                                <?php print($viewSystemCarsList); ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="clearSystemCarsTableButton"><?php print($melkovTranslation['carsTableClearLabel']); ?></div>
                    <div id="addSystemCarsTableButton"><?php print($melkovTranslation['carsTableAddLabel']); ?></div>
                    <div id="systemCarsTotal"><?php print($melkovTranslation['tableTotalLabel'].'<b>'.$viewSystemCarsTotal.'</b>; '.$melkovTranslation['tableTotalActiveLabel'].'<b>'.$viewSystemCarsTotalActive.'</b>; '.$melkovTranslation['tableTotalBlockedLabel'].'<b>'.$viewSystemCarsTotalBlocked.'</b>'); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="footer">
    <div id="footer-top">
        <div id="footer-content">
            <div class="container">
                <div id="footer-widgets" class="clearfix">
                    <div id="footer_one" class="footer-widget widget_text">
                        <h4 class="newidgettitle"><?php print($melkovTranslation['footerOneTitleLabel']); ?></h4>
                        <ul>
                            <li>
                                <a href="./" id="portalDescription"><?php print($melkovTranslation['footerOneLinkLabel']); ?> &raquo;</a>
                            </li>
                        </ul>
                    </div>
                    <div id="footer_two" class="footer-widget widget_text">
                        <h4 class="newidgettitle"><?php print($melkovTranslation['footerTwoTitleLabel']); ?></h4>
                        <ul>
                            <li>
                                <a href="./" id="portalLinks"><?php print($melkovTranslation['footerTwoLinkLabel']); ?> &raquo;</a>
                            </li>
                        </ul>
                    </div>
                    <div id="footer_three" class="footer-widget widget_text">
                        <h4 class="newidgettitle"><?php print($melkovTranslation['footerThreeTitleLabel']); ?></h4>
                        <ul>
                            <li>
                                <a href="./" id="portalInfo"><?php print($melkovTranslation['footerThreeLinkLabel']); ?> &raquo;</a>
                            </li>
                        </ul>
                    </div>
                </div>	
            </div>
            
            <div id="currentCarsDetailsDialog" title="<?php print($melkovTranslation['carsDialogTitleLabel']); ?>">
                <label><?php print($melkovTranslation['carsDialogIDLabel']); ?></label><label id="currentCarsId"></label>&nbsp;&nbsp;<label><?php print($melkovTranslation['carsDialogStatusLabel']); ?></label><label id="currentCarsStatus"></label><br />
                <label><?php print($melkovTranslation['carsDialogCreationDateLabel']); ?></label><label id="currentCarsCreationDate"></label><br />
                <label><?php print($melkovTranslation['carsDialogEditDateLabel']); ?></label><label id="currentCarsEditDate"></label>
                <hr />
                <table id="carsDialogTableF" cellpadding="1" cellspacing="1" border="0">
                    <thead></thead>
                    <tbody>
                    <tr>
                    <td style="width: 150px;">
                        <label for="currentCarsVin"><?php print($melkovTranslation['carsDialogVinLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentCarsVin" name="currentCarsVin" value="" class="input" maxlength="254" onkeyup="if($.trim($('#currentCarsVin').val()) != ''){$('#currentCarsVin').css('background-color', '#FFFFFF');}else{$('#currentCarsVin').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#currentCarsVin').css('background-color', '#FFFFFF');}else{$('#currentCarsVin').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#currentCarsVin').css('background-color', '#FFFFFF');}" />
                    </td>
                    <td style="width: 150px;">
                        <label for="currentCarsLP"><?php print($melkovTranslation['carsDialogLPLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentCarsLP" name="currentCarsLP" value="" class="input" maxlength="254" onkeyup="if($.trim($('#currentCarsLP').val()) != ''){$('#currentCarsLP').css('background-color', '#FFFFFF');}else{$('#currentCarsLP').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#currentCarsLP').css('background-color', '#FFFFFF');}else{$('#currentCarsLP').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#currentCarsLP').css('background-color', '#FFFFFF');}" />
                    </td>
                    <td style="width: 150px;">
                        <label for="currentCarsModel"><?php print($melkovTranslation['carsDialogModelLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentCarsModel" name="currentCarsModel" value="" class="input" maxlength="254" onkeyup="if($.trim($('#currentCarsModel').val()) != ''){$('#currentCarsModel').css('background-color', '#FFFFFF');}else{$('#currentCarsModel').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#currentCarsModel').css('background-color', '#FFFFFF');}else{$('#currentCarsModel').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#currentCarsModel').css('background-color', '#FFFFFF');}" />
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 150px;">
                        <label for="currentCarsYear"><?php print($melkovTranslation['carsDialogYearLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentCarsYear" name="currentCarsYear" value="" class="input" maxlength="254" onkeyup="if($.trim($('#currentCarsYear').val()) != ''){$('#currentCarsYear').css('background-color', '#FFFFFF');}else{$('#currentCarsYear').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#currentCarsYear').css('background-color', '#FFFFFF');}else{$('#currentCarsYear').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#currentCarsYear').css('background-color', '#FFFFFF');}" />
                    </td>
                    <td style="width: 150px;">
                        <label for="currentCarsEv"><?php print($melkovTranslation['carsDialogEvLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentCarsEv" name="currentCarsEv" value="" class="input" maxlength="254" onkeyup="if($.trim($('#currentCarsEv').val()) != ''){$('#currentCarsEv').css('background-color', '#FFFFFF');}else{$('#currentCarsEv').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#currentCarsEv').css('background-color', '#FFFFFF');}else{$('#currentCarsEv').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#currentCarsEv').css('background-color', '#FFFFFF');}" />
                    </td>
                    <td style="width: 150px;">
                        <label for="currentCarsColor"><?php print($melkovTranslation['carsDialogColorLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentCarsColor" name="currentCarsColor" value="" class="input" maxlength="254" onkeyup="if($.trim($('#currentCarsColor').val()) != ''){$('#currentCarsColor').css('background-color', '#FFFFFF');}else{$('#currentCarsColor').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#currentCarsColor').css('background-color', '#FFFFFF');}else{$('#currentCarsColor').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#currentCarsColor').css('background-color', '#FFFFFF');}" />
                    </td>                    
                    </tr>
                    <tr>
                    <td style="width: 150px;">
                        <label for="currentCarsKey"><?php print($melkovTranslation['carsDialogKeyLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentCarsKey" name="currentCarsKey" value="" class="input" maxlength="254"  onkeyup="if($.trim($('#currentCarsKey').val()) != ''){$('#currentCarsKey').css('background-color', '#FFFFFF');}else{$('#currentCarsKey').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#currentCarsKey').css('background-color', '#FFFFFF');}else{$('#currentCarsKey').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#currentCarsKey').css('background-color', '#FFFFFF');}" />
                    </td>
                    <td style="width: 150px;">
                        <label for="currentCarsNick"><?php print($melkovTranslation['carsDialogNickLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentCarsNick" name="currentCarsNick" value="" class="input" maxlength="254" onkeyup="if($.trim($('#currentCarsNick').val()) != ''){$('#currentCarsNick').css('background-color', '#FFFFFF');}else{$('#currentCarsNick').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#currentCarsNick').css('background-color', '#FFFFFF');}else{$('#currentCarsNick').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#currentCarsNick').css('background-color', '#FFFFFF');}" />
                    </td>
                    <td style="width: 150px;">
                        <label for="currentCarsComments"><?php print($melkovTranslation['carsDialogCommentsLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentCarsComments" name="currentCarsComments" value="" class="input" maxlength="254" />
                    </td>
                    </tr> 
                    </tbody>
                </table>
                <hr />
                <div class="carOwnerData"><b id="currentCarsOwners"></b></div><div class="carOwnerData"><?php print($melkovTranslation['carsDialogOwnerLabel']); ?></div>
            </div>
            
            <div id="footer-bottom" class="clearfix">
                <div class="container">
                    <ul id="menu-new-menu" class="bottom-nav">
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-300"><a href="./"><?php print($melkovTranslation['homeLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-301"><a href="./ordersList.php"><?php print($melkovTranslation['purchaseOrdersLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-302"><a href="./customersList.php"><?php print($melkovTranslation['customersLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item current_page_item menu-item-303"><a href="./carsList.php"><?php print($melkovTranslation['carsLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-304"><a href="./employeesList.php"><?php print($melkovTranslation['employeesLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-305"><a href="./worksList.php"><?php print($melkovTranslation['listOfWorksLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-306"><a href="./logsList.php"><?php print($melkovTranslation['systemLogsLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-307"><a href="./commonSettings.php"><?php print($melkovTranslation['commonSettingsLinkLabel']); ?></a></li>
                    </ul>
<?php require_once('./_footer.php'); ?>
