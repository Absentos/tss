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
    
    if(isset($_GET['searchDateFrom']) && isset($_GET['searchDateTo']))
    {
        if((trim($_GET['searchDateFrom']) != '') && (trim($_GET['searchDateTo']) != ''))
        {
            $searchDateFrom = ClearMySqlVariables($_GET['searchDateFrom']);
            $searchDateTo = ClearMySqlVariables($_GET['searchDateTo']);
        }
        else
        {
            $searchDateFrom = ClearMySqlVariables('');
            $searchDateTo = ClearMySqlVariables('');
        }
    }
    else
    {
        $searchDateFrom = ClearMySqlVariables('');
        $searchDateTo = ClearMySqlVariables('');
    }
    
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

    $viewSystemLogsTotal = GetCountTotalTableData(ClearMySqlVariables('system_logs'), $searchParam);
    
    $viewSystemLogsList = GetSystemLogsList($searchData, $searchDateFrom, $searchDateTo);
?>

<div id="menu" class="clearfix">
    <div id="menu-right">
        <div id="menu-content">
            <ul id="top-menu" class="nav">
                <li id="menu-item-300" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-300"><a href="./"><?php print($melkovTranslation['homeLinkLabel']); ?></a></li>
                <li id="menu-item-301" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-301"><a href="./ordersList.php"><?php print($melkovTranslation['purchaseOrdersLinkLabel']); ?></a></li>
                <li id="menu-item-302" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-302"><a href="./customersList.php"><?php print($melkovTranslation['customersLinkLabel']); ?></a></li>
                <li id="menu-item-303" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-303"><a href="./carsList.php"><?php print($melkovTranslation['carsLinkLabel']); ?></a></li>
                <li id="menu-item-304" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-304"><a href="./employeesList.php"><?php print($melkovTranslation['employeesLinkLabel']); ?></a></li>
                <li id="menu-item-305" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-305"><a href="./worksList.php"><?php print($melkovTranslation['listOfWorksLinkLabel']); ?></a></li>
                <li id="menu-item-306" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item current_page_item menu-item-306"><a href="./logsList.php"><?php print($melkovTranslation['systemLogsLinkLabel']); ?></a></li>
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
                <?php print($melkovTranslation['portalName']); ?> <span class="raquo">&raquo;</span> <?php print($melkovTranslation['systemLogsLinkLabel']); ?>
            </div>
            <div id="content-area" class="clearfix">
                <div id="left-area">
                    <div class="entry post clearfix">
                        <label for="searchData" style="font-size: 16px;"><?php print($melkovTranslation['tableSearchLabel']); ?></label>&nbsp;&nbsp;&nbsp;<input style="width: 290px;" type="text" value="<?php print($searchData); ?>" id="searchData" name="searchData" value="" class="input" maxlength="254" onkeyup="if($.trim($('#searchData').val()) != ''){$('#searchData').css('background-color', '#FFFFFF');}else{$('#searchData').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#searchData').css('background-color', '#FFFFFF');}else{$('#searchData').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#searchData').css('background-color', '#FFFFFF');}" />&nbsp;&nbsp;&nbsp;
                        <label for="searchDateFrom" style="font-size: 16px;"><?php print($melkovTranslation['tableSearchFromLabel']); ?></label>&nbsp;&nbsp;&nbsp;<input style="width: 70px;" type="text" value="<?php print($searchDateFrom); ?>" id="searchDateFrom" name="searchDateFrom" value="" class="input" maxlength="254" onkeyup="if($.trim($('#searchDateFrom').val()) != ''){$('#searchDateFrom').css('background-color', '#FFFFFF');}else{$('#searchDateFrom').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#searchDateFrom').css('background-color', '#FFFFFF');}else{$('#searchDateFrom').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#searchDateFrom').css('background-color', '#FFFFFF');}" />&nbsp;&nbsp;&nbsp;
                        <label for="searchDateTo" style="font-size: 16px;"><?php print($melkovTranslation['tableSearchToLabel']); ?></label>&nbsp;&nbsp;&nbsp;<input style="width: 70px;" type="text" value="<?php print($searchDateTo); ?>" id="searchDateTo" name="searchDateTo" value="" class="input" maxlength="254" onkeyup="if($.trim($('#searchDateTo').val()) != ''){$('#searchDateTo').css('background-color', '#FFFFFF');}else{$('#searchDateTo').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#searchDateTo').css('background-color', '#FFFFFF');}else{$('#searchDateTo').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#searchDateTo').css('background-color', '#FFFFFF');}" />&nbsp;&nbsp;&nbsp;
                        <div id="doSearchWithDate"><?php print($melkovTranslation['tableDoSearchLabel']); ?></div>&nbsp;
                        <div id="clearSearchWithDate"><?php print($melkovTranslation['tableClearSearchLabel']); ?></div>
                        <br /><br />
                        <table id="viewSystemLogsTable">
                            <thead>
                                <tr><th width="100"><?php print($melkovTranslation['logsTableDateLabel']); ?></th><th width="100"><?php print($melkovTranslation['logsTableTimeLabel']); ?></th><th width="130"><?php print($melkovTranslation['logsTableSubSystemLabel']); ?></th><th width="402"><?php print($melkovTranslation['logsTableEventLabel']); ?></th><th width="130"><?php print($melkovTranslation['logsTableUserLabel']); ?></th></tr>
                            </thead>
                            <tbody>        
                                <?php print($viewSystemLogsList); ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="clearSystemLogsTableButton"><?php print($melkovTranslation['logsTableClearLabel']); ?></div>
                    <div id="systemLogsTotal"><?php print($melkovTranslation['tableTotalLabel'].'<b>'.$viewSystemLogsTotal.'</b>'); ?></div>
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
            <div id="footer-bottom" class="clearfix">
                <div class="container">
                    <ul id="menu-new-menu" class="bottom-nav">
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-300"><a href="./"><?php print($melkovTranslation['homeLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-301"><a href="./ordersList.php"><?php print($melkovTranslation['purchaseOrdersLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-302"><a href="./customersList.php"><?php print($melkovTranslation['customersLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-303"><a href="./carsList.php"><?php print($melkovTranslation['carsLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-304"><a href="./employeesList.php"><?php print($melkovTranslation['employeesLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-305"><a href="./worksList.php"><?php print($melkovTranslation['listOfWorksLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item current_page_item menu-item-306"><a href="./logsList.php"><?php print($melkovTranslation['systemLogsLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-307"><a href="./commonSettings.php"><?php print($melkovTranslation['commonSettingsLinkLabel']); ?></a></li>
                    </ul>
<?php require_once('./_footer.php'); ?>
