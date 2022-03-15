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
        $searchParam = "WHERE (customers.customer_fn LIKE '%$searchData%' OR customers.customer_ln LIKE '%$searchData%' OR customers.customer_mn LIKE '%$searchData%' OR customers.customer_debt LIKE '%$searchData%' OR customers.customer_code LIKE '%$searchData%' OR customers.customer_nick LIKE '%$searchData%' OR customers.customer_email LIKE '%$searchData%' OR customers.customer_phone LIKE '%$searchData%' OR customers.customer_address LIKE '%$searchData%' OR customers.customer_im LIKE '%$searchData%' OR customers.customer_skype LIKE '%$searchData%' OR customers.customer_site LIKE '%$searchData%' OR customers.customer_comments LIKE '%$searchData%')";
    }
    else
    {
        $searchParam = "";
    }
    
    $viewSystemCustTotalActive = GetCountActiveTableData(ClearMySqlVariables('customers'), ClearMySqlVariables('customer_status'), $searchParam);
    $viewSystemCustTotalBlocked = GetCountBlockedTableData(ClearMySqlVariables('customers'), ClearMySqlVariables('customer_status'), $searchParam);
    $viewSystemCustTotal = GetCountTotalTableData(ClearMySqlVariables('customers'), $searchParam);
    
    $viewSystemCustList = GetSystemCustomersList($searchData);
    $viewSystemAvailableCarsList = GetAvailableCarsList();
?>

<div id="menu" class="clearfix">
    <div id="menu-right">
        <div id="menu-content">
            <ul id="top-menu" class="nav">
                <li id="menu-item-300" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-300"><a href="./"><?php print($melkovTranslation['homeLinkLabel']); ?></a></li>
                <li id="menu-item-301" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-301"><a href="./ordersList.php"><?php print($melkovTranslation['purchaseOrdersLinkLabel']); ?></a></li>
                <li id="menu-item-302" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item current_page_item menu-item-302"><a href="./customersList.php"><?php print($melkovTranslation['customersLinkLabel']); ?></a></li>
                <li id="menu-item-303" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-303"><a href="./carsList.php"><?php print($melkovTranslation['carsLinkLabel']); ?></a></li>
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
                <?php print($melkovTranslation['portalName']); ?> <span class="raquo">&raquo;</span> <?php print($melkovTranslation['customersLinkLabel']); ?>
            </div>
            <div id="content-area" class="clearfix">
                <div id="left-area">
                    <div class="entry post clearfix">
                        <label for="searchData" style="font-size: 16px;"><?php print($melkovTranslation['tableSearchLabel']); ?></label>&nbsp;&nbsp;&nbsp;<input style="width: 310px;" type="text" value="<?php print($searchData); ?>" id="searchData" name="searchData" value="" class="input" maxlength="254" onkeyup="if($.trim($('#searchData').val()) != ''){$('#searchData').css('background-color', '#FFFFFF');}else{$('#searchData').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#searchData').css('background-color', '#FFFFFF');}else{$('#searchData').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#searchData').css('background-color', '#FFFFFF');}" />&nbsp;&nbsp;&nbsp;
                        <div id="doSearch"><?php print($melkovTranslation['tableDoSearchLabel']); ?></div>&nbsp;
                        <div id="clearSearch"><?php print($melkovTranslation['tableClearSearchLabel']); ?></div>
                        <br /><br />
                        <table id="viewSystemCustTable">
                            <thead>
                                <tr><th width="50"><?php print($melkovTranslation['custTableKeyLabel']); ?></th><th width="100"><?php print($melkovTranslation['custTableNickLabel']); ?></th><th width="200"><?php print($melkovTranslation['custTableLFMLabel']); ?></th><th width="100"><?php print($melkovTranslation['custTableDebtLabel']); ?></th><th width="140"><?php print($melkovTranslation['custTablePhoneLabel']); ?></th><th width="100"><?php print($melkovTranslation['custTableEmailLabel']); ?></th><th width="100"><?php print($melkovTranslation['custTableImLabel']); ?></th><th width="40"><?php print($melkovTranslation['custTableStatusLabel']); ?></th></tr>
                            </thead>
                            <tbody>        
                                <?php print($viewSystemCustList); ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="clearSystemCustTableButton"><?php print($melkovTranslation['custTableClearLabel']); ?></div>
                    <div id="addSystemCustTableButton"><?php print($melkovTranslation['custTableAddLabel']); ?></div>
                    <div id="systemCustTotal"><?php print($melkovTranslation['tableTotalLabel'].'<b>'.$viewSystemCustTotal.'</b>; '.$melkovTranslation['tableTotalActiveLabel'].'<b>'.$viewSystemCustTotalActive.'</b>; '.$melkovTranslation['tableTotalBlockedLabel'].'<b>'.$viewSystemCustTotalBlocked.'</b>'); ?></div>
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
            
            <div id="currentCustDetailsDialog" title="<?php print($melkovTranslation['custDialogTitleLabel']); ?>">
                <label><?php print($melkovTranslation['custDialogIDLabel']); ?></label><label id="currentCustId"></label>&nbsp;&nbsp;<label><?php print($melkovTranslation['custDialogStatusLabel']); ?></label><label id="currentCustStatus"></label><br />
                <label><?php print($melkovTranslation['custDialogCreationDateLabel']); ?></label><label id="currentCustCreationDate"></label><br />
                <label><?php print($melkovTranslation['custDialogEditDateLabel']); ?></label><label id="currentCustEditDate"></label>
                <hr />
                <table id="custDialogTableNY" cellpadding="1" cellspacing="1" border="0">
                    <thead></thead>
                    <tbody>
                    <tr>
                    <td style="width: 150px;">
                        <label for="currentCustLn"><?php print($melkovTranslation['custDialogLnLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentCustLn" name="currentCustLn" value="" class="input" maxlength="254" onkeyup="if($.trim($('#currentCustLn').val()) != ''){$('#currentCustLn').css('background-color', '#FFFFFF');}else{$('#currentCustLn').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#currentCustLn').css('background-color', '#FFFFFF');}else{$('#currentCustLn').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#currentCustLn').css('background-color', '#FFFFFF');}" />
                    </td>
                    <td style="width: 150px;">
                        <label for="currentCustFn"><?php print($melkovTranslation['custDialogFnLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentCustFn" name="currentCustFn" value="" class="input" maxlength="254" onkeyup="if($.trim($('#currentCustFn').val()) != ''){$('#currentCustFn').css('background-color', '#FFFFFF');}else{$('#currentCustFn').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#currentCustFn').css('background-color', '#FFFFFF');}else{$('#currentCustFn').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#currentCustFn').css('background-color', '#FFFFFF');}" />
                    </td>
                    <td style="width: 150px;">
                        <label for="currentCustMn"><?php print($melkovTranslation['custDialogMnLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentCustMn" name="currentCustMn" value="" class="input" maxlength="254" onkeyup="if($.trim($('#currentCustMn').val()) != ''){$('#currentCustMn').css('background-color', '#FFFFFF');}else{$('#currentCustMn').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#currentCustMn').css('background-color', '#FFFFFF');}else{$('#currentCustMn').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#currentCustMn').css('background-color', '#FFFFFF');}" />
                    </td>
                    </tr>
                    </tbody>
                </table>
                <table id="custDialogTableNX" cellpadding="1" cellspacing="1" border="0">
                    <thead></thead>
                    <tbody>
                    <tr>
                    <td style="width: 485px;">
                        <label for="currentCustKey"><?php print($melkovTranslation['custDialogKeyLabel']); ?></label><br />
                        <input style="width: 485px;" type="text" id="currentCustKey" name="currentCustKey" value="" class="input" maxlength="254" onkeyup="if($.trim($('#currentCustKey').val()) != ''){$('#currentCustKey').css('background-color', '#FFFFFF');}else{$('#currentCustKey').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#currentCustKey').css('background-color', '#FFFFFF');}else{$('#currentCustKey').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#currentCustKey').css('background-color', '#FFFFFF');}" />
                    </td>
                    </tr>
                    </tbody>
                </table>                
                <hr />
                <table id="custDialogTableNN" cellpadding="1" cellspacing="1" border="0">
                    <thead></thead>
                    <tbody>
                    <tr>
                    <td style="width: 150px;">
                        <label for="currentCustDebt" id="currentCustDebtLabel"><?php print($melkovTranslation['custDialogDebtLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentCustDebt" name="currentCustDebt" value="" class="input" maxlength="254"  onkeyup="if($.trim($('#currentCustDebt').val()) != ''){$('#currentCustDebtLabel').css({'color':'#EE2F0D', 'font-weight':'bold'});}else{$('#currentCustDebtLabel').css({'color':'#000000', 'font-weight':'normal'});}" />
                    </td>
                    <td style="width: 150px;">
                        <label for="currentCustNick"><?php print($melkovTranslation['custDialogNickLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentCustNick" name="currentCustNick" value="" class="input" maxlength="254" />
                    </td>
                    <td style="width: 150px;">
                        <label for="currentCustEmail"><?php print($melkovTranslation['custDialogEmailLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentCustEmail" name="currentCustEmail" value="" class="input" maxlength="254" />
                    </td>
                    </tr>
                    <tr>
                    <td style="width: 150px;">
                        <label for="currentCustPhone"><?php print($melkovTranslation['custDialogPhoneLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentCustPhone" name="currentCustPhone" value="" class="input" maxlength="254" />
                    </td>
                    <td style="width: 150px;">
                        <label for="currentCustAddress"><?php print($melkovTranslation['custDialogAddressLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentCustAddress" name="currentCustAddress" value="" class="input" maxlength="254" />
                    </td>
                    <td style="width: 150px;">
                        <label for="currentCustIm"><?php print($melkovTranslation['custDialogImLabel']); ?></label><br />
                        <input style="width: 150px;" type="text" id="currentCustIm" name="currentCustIm" value="" class="input" maxlength="254" />
                    </td>
                    </tr>
                    </tbody>
                </table>
                <table id="custDialogTableNZ" cellpadding="1" cellspacing="1" border="0">
                    <thead></thead>
                    <tbody>
                    <tr>
                    <td style="width: 233px;">
                        <label for="currentCustSkype"><?php print($melkovTranslation['custDialogSkypeLabel']); ?></label><br />
                        <input style="width: 233px;" type="text" id="currentCustSkype" name="currentCustSkype" value="" class="input" maxlength="254" />
                    </td>
                    <td style="width: 234px;">
                        <label for="currentCustSite"><?php print($melkovTranslation['custDialogSiteLabel']); ?></label><br />
                        <input style="width: 234px;" type="text" id="currentCustSite" name="currentCustSite" value="" class="input" maxlength="254" /><br />
                    </td>
                    </tr>
                    <tr>
                    <td colspan="2" style="width: 485px;">
                        <label for="currentCustComments"><?php print($melkovTranslation['custDialogCommentsLabel']); ?></label><br />
                        <input style="width: 485px;" type="text" id="currentCustComments" name="currentCustComments" value="" class="input" maxlength="254" />
                    </td>
                    </tr>                    
                    </tbody>
                </table>
                <hr />
                <table id="custDialogTableNP" cellpadding="1" cellspacing="1" border="0">
                    <thead></thead>
                    <tbody>
                    <tr>
                    <td style="width: 485px;">
                        <label for="currentCustAuto"><?php print($melkovTranslation['custDialogAutoLabel']); ?></label><br />
                        <input style="width: 485px;" type="text" id="currentCustAuto" name="currentCustAuto" value="" class="input" maxlength="254"  onkeyup="if($.trim($('#currentCustAuto').val()) != ''){$('#currentCustAuto').css('background-color', '#FFFFFF');}else{$('#currentCustAuto').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#currentCustAuto').css('background-color', '#FFFFFF');}else{$('#currentCustAuto').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#currentCustAuto').css('background-color', '#FFFFFF');}" />
                    </td>
                    </tr>                    
                    </tbody>
                </table>
            </div>
            
            <script type='text/javascript'>
                $(document).ready(function() {
                    var availableCars = [<?php print($viewSystemAvailableCarsList); ?>];
                    
                    function split( val ) {
                        return val.split( /;\s*/ );
                    }
                            
                    function extractLast( term ) {
                        return split( term ).pop();
                    }
                    
                    $( "#currentCustAuto" ).bind( "keydown", function( event ) {
                        if ( event.keyCode === $.ui.keyCode.TAB && $( this ).data( "autocomplete" ).menu.active ) {
                            event.preventDefault();
                        }
                    })
                    .autocomplete({
                        minLength: 0,
                        source: function( request, response ) {
                            response( $.ui.autocomplete.filter(
                                availableCars, extractLast( request.term ) ) );
                        },
                        focus: function() {
                            return false;
                        },
                        select: function( event, ui ) {
                            var terms = split( this.value );
                            terms.pop();
                            terms.push( ui.item.value );
                            terms.push( "" );
                            this.value = terms.join( "; " );
                            if($.trim($('#currentCustAuto').val()) != ''){$('#currentCustAuto').css('background-color', '#FFFFFF');}else{$('#currentCustAuto').css('background-color', '#FFDBDB');}
                            return false;
                        }
                    });
                    
                    $( "#currentCustAuto" ).click(function(){
                        $( "#currentCustAuto" ).autocomplete( "search", "" );
                        $( "#currentCustAuto" ).focus();
                    });
                });
            </script>
            
            <div id="footer-bottom" class="clearfix">
                <div class="container">
                    <ul id="menu-new-menu" class="bottom-nav">
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-300"><a href="./"><?php print($melkovTranslation['homeLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-301"><a href="./ordersList.php"><?php print($melkovTranslation['purchaseOrdersLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item current_page_item menu-item-302"><a href="./customersList.php"><?php print($melkovTranslation['customersLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-303"><a href="./carsList.php"><?php print($melkovTranslation['carsLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-304"><a href="./employeesList.php"><?php print($melkovTranslation['employeesLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-305"><a href="./worksList.php"><?php print($melkovTranslation['listOfWorksLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-306"><a href="./logsList.php"><?php print($melkovTranslation['systemLogsLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-307"><a href="./commonSettings.php"><?php print($melkovTranslation['commonSettingsLinkLabel']); ?></a></li>
                    </ul>
<?php require_once('./_footer.php'); ?>
