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
        $searchParam = "WHERE (employees.employee_fn LIKE '%$searchData%' OR employees.employee_ln LIKE '%$searchData%' OR employees.employee_mn LIKE '%$searchData%' OR employees.employee_birth_date LIKE '%$searchData%' OR employees.employee_code LIKE '%$searchData%' OR employees.employee_nick LIKE '%$searchData%' OR employees.employee_email LIKE '%$searchData%' OR employees.employee_phone LIKE '%$searchData%' OR employees.employee_address LIKE '%$searchData%' OR employees.employee_im LIKE '%$searchData%' OR employees.employee_skype LIKE '%$searchData%' OR employees.employee_site LIKE '%$searchData%' OR employees.employee_comments LIKE '%$searchData%' OR employees.employee_passport LIKE '%$searchData%' OR employees.employee_position LIKE '%$searchData%')";
    }
    else
    {
        $searchParam = "";
    }
    
    $viewSystemEmplTotalActive = GetCountActiveTableData(ClearMySqlVariables('employees'), ClearMySqlVariables('employee_status'), $searchParam);
    $viewSystemEmplTotalBlocked = GetCountBlockedTableData(ClearMySqlVariables('employees'), ClearMySqlVariables('employee_status'), $searchParam);
    $viewSystemEmplTotal = GetCountTotalTableData(ClearMySqlVariables('employees'), $searchParam);
    
    $viewSystemEmplList = GetSystemEmployeesList($searchData);
?>

<div id="menu" class="clearfix">
    <div id="menu-right">
        <div id="menu-content">
            <ul id="top-menu" class="nav">
                <li id="menu-item-300" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-300"><a href="./"><?php print($melkovTranslation['homeLinkLabel']); ?></a></li>
                <li id="menu-item-301" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-301"><a href="./ordersList.php"><?php print($melkovTranslation['purchaseOrdersLinkLabel']); ?></a></li>
                <li id="menu-item-302" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-302"><a href="./customersList.php"><?php print($melkovTranslation['customersLinkLabel']); ?></a></li>
                <li id="menu-item-303" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-303"><a href="./carsList.php"><?php print($melkovTranslation['carsLinkLabel']); ?></a></li>
                <li id="menu-item-304" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item current_page_item menu-item-304"><a href="./employeesList.php"><?php print($melkovTranslation['employeesLinkLabel']); ?></a></li>
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
                <?php print($melkovTranslation['portalName']); ?> <span class="raquo">&raquo;</span> <?php print($melkovTranslation['employeesLinkLabel']); ?>
            </div>
            <div id="content-area" class="clearfix">
                <div id="left-area">
                    <div class="entry post clearfix">
                        <label for="searchData" style="font-size: 16px;"><?php print($melkovTranslation['tableSearchLabel']); ?></label>&nbsp;&nbsp;&nbsp;<input style="width: 310px;" type="text" value="<?php print($searchData); ?>" id="searchData" name="searchData" value="" class="input" maxlength="254" onkeyup="if($.trim($('#searchData').val()) != ''){$('#searchData').css('background-color', '#FFFFFF');}else{$('#searchData').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#searchData').css('background-color', '#FFFFFF');}else{$('#searchData').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#searchData').css('background-color', '#FFFFFF');}" />&nbsp;&nbsp;&nbsp;
                        <div id="doSearch"><?php print($melkovTranslation['tableDoSearchLabel']); ?></div>&nbsp;
                        <div id="clearSearch"><?php print($melkovTranslation['tableClearSearchLabel']); ?></div>
                        <br /><br />
                        <table id="viewSystemEmplTable">
                            <thead>
                                <tr><th width="50"><?php print($melkovTranslation['emplTableKeyLabel']); ?></th><th width="100"><?php print($melkovTranslation['emplTableNickLabel']); ?></th><th width="200"><?php print($melkovTranslation['emplTableLFMLabel']); ?></th><th width="90"><?php print($melkovTranslation['emplTableBDLabel']); ?></th><th width="150"><?php print($melkovTranslation['emplTablePassportLabel']); ?></th><th width="100"><?php print($melkovTranslation['emplTablePhoneLabel']); ?></th><th width="100"><?php print($melkovTranslation['emplTablePositionLabel']); ?></th><th width="40"><?php print($melkovTranslation['emplTableStatusLabel']); ?></th></tr>
                            </thead>
                            <tbody>        
                                <?php print($viewSystemEmplList); ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="clearSystemEmplTableButton"><?php print($melkovTranslation['emplTableClearLabel']); ?></div>
                    <div id="addSystemEmplTableButton"><?php print($melkovTranslation['emplTableAddLabel']); ?></div>
                    <div id="systemEmplTotal"><?php print($melkovTranslation['tableTotalLabel'].'<b>'.$viewSystemEmplTotal.'</b>; '.$melkovTranslation['tableTotalActiveLabel'].'<b>'.$viewSystemEmplTotalActive.'</b>; '.$melkovTranslation['tableTotalBlockedLabel'].'<b>'.$viewSystemEmplTotalBlocked.'</b>'); ?></div>
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
            
            <div id="currentEmplDetailsDialog" title="<?php print($melkovTranslation['emplDialogTitleLabel']); ?>">
                <label><?php print($melkovTranslation['emplDialogIDLabel']); ?></label><label id="currentEmplId"></label>&nbsp;&nbsp;<label><?php print($melkovTranslation['emplDialogStatusLabel']); ?></label><label id="currentEmplStatus"></label><br />
                <label><?php print($melkovTranslation['emplDialogCreationDateLabel']); ?></label><label id="currentEmplCreationDate"></label><br />
                <label><?php print($melkovTranslation['emplDialogEditDateLabel']); ?></label><label id="currentEmplEditDate"></label>
                <hr />
                <table id="emplDialogTableNY" cellpadding="1" cellspacing="1" border="0">
                    <thead></thead>
                    <tbody>
                    <tr>
                    <td style="width: 150px;">
                        <label for="currentEmplKey"><?php print($melkovTranslation['emplDialogKeyLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentEmplKey" name="currentEmplKey" value="" class="input" maxlength="254" onkeyup="if($.trim($('#currentEmplKey').val()) != ''){$('#currentEmplKey').css('background-color', '#FFFFFF');}else{$('#currentEmplKey').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#currentEmplKey').css('background-color', '#FFFFFF');}else{$('#currentEmplKey').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#currentEmplKey').css('background-color', '#FFFFFF');}" />
                    </td>
                    <td style="width: 150px;">
                        <label for="currentEmplPosition"><?php print($melkovTranslation['emplDialogPositionLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentEmplPosition" name="currentEmplPosition" value="" class="input" maxlength="254" onkeyup="if($.trim($('#currentEmplPosition').val()) != ''){$('#currentEmplPosition').css('background-color', '#FFFFFF');}else{$('#currentEmplPosition').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#currentEmplPosition').css('background-color', '#FFFFFF');}else{$('#currentEmplPosition').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#currentEmplPosition').css('background-color', '#FFFFFF');}" />
                    </td>
                    <td style="width: 150px;">
                        <label for="currentEmplBd"><?php print($melkovTranslation['emplDialogBdLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentEmplBd" name="currentEmplBd" value="" class="input" maxlength="254" onkeyup="if($.trim($('#currentEmplBd').val()) != ''){$('#currentEmplBd').css('background-color', '#FFFFFF');}else{$('#currentEmplBd').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#currentEmplBd').css('background-color', '#FFFFFF');}else{$('#currentEmplBd').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#currentEmplBd').css('background-color', '#FFFFFF');}" />
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 150px;">
                        <label for="currentEmplLn"><?php print($melkovTranslation['emplDialogLnLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentEmplLn" name="currentEmplLn" value="" class="input" maxlength="254" onkeyup="if($.trim($('#currentEmplLn').val()) != ''){$('#currentEmplLn').css('background-color', '#FFFFFF');}else{$('#currentEmplLn').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#currentEmplLn').css('background-color', '#FFFFFF');}else{$('#currentEmplLn').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#currentEmplLn').css('background-color', '#FFFFFF');}" />
                    </td>
                    <td style="width: 150px;">
                        <label for="currentEmplFn"><?php print($melkovTranslation['emplDialogFnLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentEmplFn" name="currentEmplFn" value="" class="input" maxlength="254" onkeyup="if($.trim($('#currentEmplFn').val()) != ''){$('#currentEmplFn').css('background-color', '#FFFFFF');}else{$('#currentEmplFn').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#currentEmplFn').css('background-color', '#FFFFFF');}else{$('#currentEmplFn').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#currentEmplFn').css('background-color', '#FFFFFF');}" />
                    </td>
                    <td style="width: 150px;">
                        <label for="currentEmplMn"><?php print($melkovTranslation['emplDialogMnLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentEmplMn" name="currentEmplMn" value="" class="input" maxlength="254" onkeyup="if($.trim($('#currentEmplMn').val()) != ''){$('#currentEmplMn').css('background-color', '#FFFFFF');}else{$('#currentEmplMn').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#currentEmplMn').css('background-color', '#FFFFFF');}else{$('#currentEmplMn').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#currentEmplMn').css('background-color', '#FFFFFF');}" />
                    </td>
                    </tr>
                    </tbody>
                </table>
                <hr />
                <table id="emplDialogTableNN" cellpadding="1" cellspacing="1" border="0">
                    <thead></thead>
                    <tbody>
                    <tr>
                    <td style="width: 150px;">
                        <label for="currentEmplPassport"><?php print($melkovTranslation['emplDialogPassportLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentEmplPassport" name="currentEmplPassport" value="" class="input" maxlength="254" />
                    </td>
                    <td style="width: 150px;">
                        <label for="currentEmplNick"><?php print($melkovTranslation['emplDialogNickLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentEmplNick" name="currentEmplNick" value="" class="input" maxlength="254" />
                    </td>
                    <td style="width: 150px;">
                        <label for="currentEmplEmail"><?php print($melkovTranslation['emplDialogEmailLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentEmplEmail" name="currentEmplEmail" value="" class="input" maxlength="254" />
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 150px;">
                        <label for="currentEmplPhone"><?php print($melkovTranslation['emplDialogPhoneLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentEmplPhone" name="currentEmplPhone" value="" class="input" maxlength="254" />
                    </td>
                    <td style="width: 150px;">
                        <label for="currentEmplAddress"><?php print($melkovTranslation['emplDialogAddressLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentEmplAddress" name="currentEmplAddress" value="" class="input" maxlength="254" />
                    </td>
                    <td style="width: 150px;">
                        <label for="currentEmplIm"><?php print($melkovTranslation['emplDialogImLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentEmplIm" name="currentEmplIm" value="" class="input" maxlength="254" />
                    </td>
                    </tr>
                    </tbody>
                </table>
                <table id="emplDialogTableNZ" cellpadding="1" cellspacing="1" border="0">
                    <thead></thead>
                    <tbody>
                    <tr>
                    <td style="width: 233px;">
                        <label for="currentEmplSkype"><?php print($melkovTranslation['emplDialogSkypeLabel']); ?></label><br />
                        <input style="width: 233px;" type="text" id="currentEmplSkype" name="currentEmplSkype" value="" class="input" maxlength="254" />
                    </td>
                    <td style="width: 234px;">
                        <label for="currentEmplSite"><?php print($melkovTranslation['emplDialogSiteLabel']); ?></label><br />
                        <input style="width: 234px;" type="text" id="currentEmplSite" name="currentEmplSite" value="" class="input" maxlength="254" /><br />
                    </td>
                    </tr>
                    <tr>
                    <td colspan="2" style="width: 485px;">
                        <label for="currentEmplComments"><?php print($melkovTranslation['emplDialogCommentsLabel']); ?></label><br />
                        <input style="width: 485px;" type="text" id="currentEmplComments" name="currentEmplComments" value="" class="input" maxlength="254" />
                    </td>
                    </tr>                    
                    </tbody>
                </table>
            </div>
            
            <div id="footer-bottom" class="clearfix">
                <div class="container">
                    <ul id="menu-new-menu" class="bottom-nav">
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-300"><a href="./"><?php print($melkovTranslation['homeLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-301"><a href="./ordersList.php"><?php print($melkovTranslation['purchaseOrdersLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-302"><a href="./customersList.php"><?php print($melkovTranslation['customersLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-303"><a href="./carsList.php"><?php print($melkovTranslation['carsLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item current_page_item menu-item-304"><a href="./employeesList.php"><?php print($melkovTranslation['employeesLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-305"><a href="./worksList.php"><?php print($melkovTranslation['listOfWorksLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-306"><a href="./logsList.php"><?php print($melkovTranslation['systemLogsLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-307"><a href="./commonSettings.php"><?php print($melkovTranslation['commonSettingsLinkLabel']); ?></a></li>
                    </ul>
<?php require_once('./_footer.php'); ?>
