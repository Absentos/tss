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
        $searchParam = "WHERE (list_of_works.work_key LIKE '%$searchData%' OR list_of_works.work_category LIKE '%$searchData%' OR list_of_works.work_value LIKE '%$searchData%' OR list_of_works.work_price LIKE '%$searchData%')";
    }
    else
    {
        $searchParam = "";
    }
    
    $viewSystemWorksTotalActive = GetCountActiveTableData(ClearMySqlVariables('list_of_works'), ClearMySqlVariables('work_status'), $searchParam);
    $viewSystemWorksTotalBlocked = GetCountBlockedTableData(ClearMySqlVariables('list_of_works'), ClearMySqlVariables('work_status'), $searchParam);
    $viewSystemWorksTotal = GetCountTotalTableData(ClearMySqlVariables('list_of_works'), $searchParam);
    
    $viewSystemWorksList = GetSystemWorksList($searchData);
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
                <li id="menu-item-305" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item current_page_item menu-item-305"><a href="./worksList.php"><?php print($melkovTranslation['listOfWorksLinkLabel']); ?></a></li>
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
                <?php print($melkovTranslation['portalName']); ?> <span class="raquo">&raquo;</span> <?php print($melkovTranslation['listOfWorksLinkLabel']); ?>
            </div>
            <div id="content-area" class="clearfix">
                <div id="left-area">
                    <div class="entry post clearfix">
                        <label for="searchData" style="font-size: 16px;"><?php print($melkovTranslation['tableSearchLabel']); ?></label>&nbsp;&nbsp;&nbsp;<input style="width: 334px;" type="text" value="<?php print($searchData); ?>" id="searchData" name="searchData" value="" class="input" maxlength="254" onkeyup="if($.trim($('#searchData').val()) != ''){$('#searchData').css('background-color', '#FFFFFF');}else{$('#searchData').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#searchData').css('background-color', '#FFFFFF');}else{$('#searchData').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#searchData').css('background-color', '#FFFFFF');}" />&nbsp;&nbsp;&nbsp;
                        <div id="doSearch"><?php print($melkovTranslation['tableDoSearchLabel']); ?></div>&nbsp;
                        <div id="clearSearch"><?php print($melkovTranslation['tableClearSearchLabel']); ?></div>
                        <br /><br />
                        <table id="viewSystemWorksTable">
                            <thead>
                                <tr><th width="50"><?php print($melkovTranslation['worksTableKeyLabel']); ?></th><th width="335"><?php print($melkovTranslation['worksTableCategoryLabel']); ?></th><th width="338"><?php print($melkovTranslation['worksTableValueLabel']); ?></th><th width="100"><?php print($melkovTranslation['worksTablePriceLabel']); ?></th><th width="40"><?php print($melkovTranslation['worksTableStatusLabel']); ?></th></tr>
                            </thead>
                            <tbody>        
                                <?php print($viewSystemWorksList); ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="clearSystemWorksTableButton"><?php print($melkovTranslation['worksTableClearLabel']); ?></div>
                    <div id="addSystemWorksTableButton"><?php print($melkovTranslation['worksTableAddLabel']); ?></div>
                    <div id="systemWorksTotal"><?php print($melkovTranslation['tableTotalLabel'].'<b>'.$viewSystemWorksTotal.'</b>; '.$melkovTranslation['tableTotalActiveLabel'].'<b>'.$viewSystemWorksTotalActive.'</b>; '.$melkovTranslation['tableTotalBlockedLabel'].'<b>'.$viewSystemWorksTotalBlocked.'</b>'); ?></div>
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
            
            <div id="currentWorkDetailsDialog" title="<?php print($melkovTranslation['worksDialogTitleLabel']); ?>">
                <label><?php print($melkovTranslation['worksDialogIDLabel']); ?></label><label id="currentWorkId"></label>&nbsp;&nbsp;<label><?php print($melkovTranslation['worksDialogStatusLabel']); ?></label><label id="currentWorkStatus"></label><br />
                <label><?php print($melkovTranslation['worksDialogCreationDateLabel']); ?></label><label id="currentWorkCreationDate"></label><br /><label><?php print($melkovTranslation['worksDialogEditDateLabel']); ?></label><label id="currentWorkEditDate"></label><hr />
                <label for="currentWorkKey"><?php print($melkovTranslation['worksDialogKeyLabel']); ?></label><br />
                <input type="text" id="currentWorkKey" name="currentWorkKey" value="" class="input" maxlength="254" onkeyup="if($.trim($('#currentWorkKey').val()) != ''){$('#currentWorkKey').css('background-color', '#FFFFFF');}else{$('#currentWorkKey').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#currentWorkKey').css('background-color', '#FFFFFF');}else{$('#currentWorkKey').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#currentWorkKey').css('background-color', '#FFFFFF');}" /><br />
                <label for="currentWorkCategory"><?php print($melkovTranslation['worksDialogCategoryLabel']); ?></label><br />
                <input type="text" id="currentWorkCategory" name="currentWorkCategory" value="" class="input" maxlength="254" onkeyup="if($.trim($('#currentWorkCategory').val()) != ''){$('#currentWorkCategory').css('background-color', '#FFFFFF');}else{$('#currentWorkCategory').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#currentWorkCategory').css('background-color', '#FFFFFF');}else{$('#currentWorkCategory').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#currentWorkCategory').css('background-color', '#FFFFFF');}" /><br />
                <label for="currentWorkValue"><?php print($melkovTranslation['worksDialogValueLabel']); ?></label><br />
                <input type="text" id="currentWorkValue" name="currentWorkValue" value="" class="input" maxlength="254" onkeyup="if($.trim($('#currentWorkValue').val()) != ''){$('#currentWorkValue').css('background-color', '#FFFFFF');}else{$('#currentWorkValue').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#currentWorkValue').css('background-color', '#FFFFFF');}else{$('#currentWorkValue').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#currentWorkValue').css('background-color', '#FFFFFF');}" /><br />
                <label for="currentWorkPrice"><?php print($melkovTranslation['worksDialogPriceLabel']); ?></label><br />
                <input type="text" id="currentWorkPrice" name="currentWorkPrice" value="" class="input" maxlength="254" onkeyup="if($.trim($('#currentWorkPrice').val()) != ''){$('#currentWorkPrice').css('background-color', '#FFFFFF');}else{$('#currentWorkPrice').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#currentWorkPrice').css('background-color', '#FFFFFF');}else{$('#currentWorkPrice').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#currentWorkPrice').css('background-color', '#FFFFFF');}" /><br />
            </div>
            
            <div id="footer-bottom" class="clearfix">
                <div class="container">
                    <ul id="menu-new-menu" class="bottom-nav">
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-300"><a href="./"><?php print($melkovTranslation['homeLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-301"><a href="./ordersList.php"><?php print($melkovTranslation['purchaseOrdersLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-302"><a href="./customersList.php"><?php print($melkovTranslation['customersLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-303"><a href="./carsList.php"><?php print($melkovTranslation['carsLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-304"><a href="./employeesList.php"><?php print($melkovTranslation['employeesLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item current_page_item menu-item-305"><a href="./worksList.php"><?php print($melkovTranslation['listOfWorksLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-306"><a href="./logsList.php"><?php print($melkovTranslation['systemLogsLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-307"><a href="./commonSettings.php"><?php print($melkovTranslation['commonSettingsLinkLabel']); ?></a></li>
                    </ul>
<?php require_once('./_footer.php'); ?>
