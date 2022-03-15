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

    $viewSystemOrdersTotalActive = GetCountActiveTableData(ClearMySqlVariables('purchase_orders'), ClearMySqlVariables('order_status'), $searchParam);
    $viewSystemOrdersTotalBlocked = GetCountBlockedTableData(ClearMySqlVariables('purchase_orders'), ClearMySqlVariables('order_status'), $searchParam);
    $viewSystemOrdersTotal = GetCountTotalTableData(ClearMySqlVariables('purchase_orders'), $searchParam);
    
    $viewSystemOrdersList = GetSystemOrdersList($searchData, $searchDateFrom, $searchDateTo);
    $viewSystemCustomersList = GetAvailableCustomersList();
    $viewSystemAvailableOperationsList = GetAvailableOperationsList();
    $viewSystemAvailableEmployeesList = GetAvailableEmployeesList();
?>

<div id="menu" class="clearfix">
    <div id="menu-right">
        <div id="menu-content">
            <ul id="top-menu" class="nav">
                <li id="menu-item-300" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-300"><a href="./"><?php print($melkovTranslation['homeLinkLabel']); ?></a></li>
                <li id="menu-item-301" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item current_page_item menu-item-301"><a href="./ordersList.php"><?php print($melkovTranslation['purchaseOrdersLinkLabel']); ?></a></li>
                <li id="menu-item-302" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-302"><a href="./customersList.php"><?php print($melkovTranslation['customersLinkLabel']); ?></a></li>
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
                <?php print($melkovTranslation['portalName']); ?> <span class="raquo">&raquo;</span> <?php print($melkovTranslation['purchaseOrdersLinkLabel']); ?>
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
                        <table id="viewSystemOrdersTable">
                            <thead>
                                <tr><th width="93"><?php print($melkovTranslation['ordersTableIdLabel']); ?></th><th width="107"><?php print($melkovTranslation['ordersTableDateLabel']); ?></th><th width="311"><?php print($melkovTranslation['ordersTableCustomerLabel']); ?></th><th width="311"><?php print($melkovTranslation['ordersTableCarLabel']); ?></th><th width="41"><?php print($melkovTranslation['ordersTableOperationLabel']); ?></th></tr>
                            </thead>
                            <tbody>        
                                <?php print($viewSystemOrdersList); ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="clearSystemOrdersTableButton"><?php print($melkovTranslation['ordersTableClearLabel']); ?></div>
                    <div id="addSystemOrdersTableButton"><?php print($melkovTranslation['ordersTableAddLabel']); ?></div>
                    <div id="systemOrdersTotal"><?php print($melkovTranslation['tableTotalLabel'].'<b>'.$viewSystemOrdersTotal.'</b>'); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="orderId" name="orderId" size="254" disabled="disabled" value="" />

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
            
            <div id="createOrderDialog" style="overflow: hidden; overflow-x: hidden; overflow-y: hidden;" title="<?php print($melkovTranslation['createOrdersDialogTitleLabel']); ?>">
                <table id="orderCustomerCarSelection" cellpadding="5" cellspacing="5" border="0">
                    <thead></thead>
                    <tbody>
                        <tr>
                            <td id="customerSelectionTd" style="width: 325px;">
                                <label for="customerSelection"><?php print($melkovTranslation['ordersDialogCustomerSelectionLabel']); ?></label><br />
                                <select style="width: 325px;" id="customerSelection" name="customerSelection" onchange="$(this).GetCustomerData($('#customerSelection').val());">
                                    <?php print($viewSystemCustomersList); ?>
                                </select>
                            </td>
                            <td id="carSelectionTd" style="width: 325px;">
                                <label for="carSelection"><?php print($melkovTranslation['ordersDialogCarSelectionLabel']); ?></label><br />
                                <select style="width: 325px;" id="carSelection" name="carSelection" disabled="disabled"  onchange="$(this).GetCarData($('#carSelection').val());">
                                    <option value="-1">---</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td id="customerDataTd" style="width: 325px;" valign="top">
                                <center id="custCenterData"><?php print($melkovTranslation['ordersDialogNoDataLabel']); ?></center>				                
                            </td>
                            <td id="carDataTd" style="width: 325px;" valign="top">
                                <center id="carCenterData"><?php print($melkovTranslation['ordersDialogNoDataLabel']); ?></center>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <hr />
                
                <div id="orderCreationTmpMessage">
                    <center id="worksCenterData"><?php print($melkovTranslation['ordersDialogNoDataLabel']); ?></center>
                </div>
                
                <div id="orderCreationWorksContainer" class="visibleVisibility">
                    <table id="orderDialogTableQ" cellpadding="1" cellspacing="1" border="0">
                        <thead></thead>
                        <tbody>
                        <tr>
                            <td style="width: 100%;">
                                <label for="workOperation"><?php print($melkovTranslation['ordersDialogOperationLabel']); ?></label><br />
                                <input type="text" id="workOperation" name="workOperation" value="" class="input" maxlength="254" onkeyup="if($.trim($('#workOperation').val()) != ''){$('#workOperation').css('background-color', '#FFFFFF');}else{$('#workOperation').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#workOperation').css('background-color', '#FFFFFF');}else{$('#workOperation').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#workOperation').css('background-color', '#FFFFFF');}" />
                            </td>
                            <td style="width: 100%;" align="left">
                                <label for="workComments"><?php print($melkovTranslation['ordersDialogCommentsLabel']); ?></label><br />
                                <input type="text" id="workComments" name="workComments" value="" class="input" maxlength="254" onkeyup="if($.trim($('#workComments').val()) != ''){$('#workComments').css('background-color', '#FFFFFF');}else{$('#workComments').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#workComments').css('background-color', '#FFFFFF');}else{$('#workComments').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#workComments').css('background-color', '#FFFFFF');}" />
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    
                    <table id="orderDialogTableX" cellpadding="1" cellspacing="1" border="0">
                        <thead></thead>
                        <tbody>
                        <tr>
                            <td style="width: 142px;">
                                <label for="workCode"><?php print($melkovTranslation['ordersDialogCodeLabel']); ?></label><br />
                                <input style="width: 142px;" type="text" id="workCode" name="workCode" value="" class="input" maxlength="254" onkeyup="if($.trim($('#workCode').val()) != ''){$('#workCode').css('background-color', '#FFFFFF');}else{$('#workCode').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#workCode').css('background-color', '#FFFFFF');}else{$('#workCode').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#workCode').css('background-color', '#FFFFFF');}" />
                            </td>
                            <td style="width: 141px;">
                                <label for="workPrice"><?php print($melkovTranslation['ordersDialogPriceLabel']); ?></label><br />
                                <input style="width: 141px;" type="text" id="workPrice" name="workPrice" value="" class="input" maxlength="254" onkeyup="if($.trim($('#workPrice').val()) != ''){$('#workPrice').css('background-color', '#FFFFFF');}else{$('#workPrice').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#workPrice').css('background-color', '#FFFFFF');}else{$('#workPrice').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#workPrice').css('background-color', '#FFFFFF');}" />
                            </td>
                            <td style="width: 300px; padding-left: 38px;">
                                <label for="workEmpl"><?php print($melkovTranslation['ordersDialogEmplLabel']); ?></label><br />
                                <input style="width: 300px;" type="text" id="workEmpl" name="workEmpl" value="" class="input" maxlength="254" onkeyup="if($.trim($('#workEmpl').val()) != ''){$('#workEmpl').css('background-color', '#FFFFFF');}else{$('#workEmpl').css('background-color', '#FFDBDB');}" onfocus="with(this){ if (value != ''){$('#workEmpl').css('background-color', '#FFFFFF');}else{$('#workEmpl').css('background-color', '#FFDBDB');}}" onblur="with(this){$('#workEmpl').css('background-color', '#FFFFFF');}" />
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <br />
                    <div id="clearOrderWorkConnectionButton"><?php print($melkovTranslation['ordersDialogClearWorkConnectionBtnLabel']); ?></div>
                    <div id="setOrderWorkConnectionButton"><?php print($melkovTranslation['ordersDialogWorkConnectionBtnLabel']); ?></div>
                    <div class="totalWorksAndPrice">&nbsp;<b id="orderTotalPriceLabel">0.00</b>;</div>
                    <div class="totalWorksAndPrice"><?php print($melkovTranslation['ordersDialogTotalPriceLabel']); ?></div>
                    <div class="totalWorksAndPrice">&nbsp;<b id="orderTotalWorksLabel">0</b>;&nbsp;</div>
                    <div class="totalWorksAndPrice"><?php print($melkovTranslation['ordersDialogTotalWorksLabel']); ?></div>                    
                    <hr />
                    <div id="worksTableContainer" style="height: 150px; overflow-y: scroll;">
                        <center><?php print($melkovTranslation['ordersDialogNoDataLabel']); ?></center>
                    </div>
                </div>                
            </div>
                        
            <div id="viewOrderDialog" style="overflow: hidden; overflow-x: hidden; overflow-y: hidden;" title="<?php print($melkovTranslation['viewOrdersDialogTitleLabel']); ?>">
                <table id="orderCustomerCarDataView" cellpadding="5" cellspacing="5" border="0">
                    <thead></thead>
                    <tbody>
                        <tr>
                            <td id="customerLabelTdView" style="width: 325px;">
                                <b><label><?php print($melkovTranslation['ordersDialogViewCustDataLabel']); ?></label></b><br />
                            </td>
                            <td id="carLabelTdView" style="width: 325px;">
                                <b><label><?php print($melkovTranslation['ordersDialogViewCarDataLabel']); ?></label></b><br />
                            </td>
                        </tr>
                        <tr>
                            <td id="customerDataTdView" style="width: 325px;" valign="top">				                
                            </td>
                            <td id="carDataTdView" style="width: 325px;" valign="top">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br />
                <hr />
                <div class="totalWorksAndPriceView">&nbsp;<b id="orderTotalPriceLabelView">0.00</b>;</div>
                <div class="totalWorksAndPriceView"><?php print($melkovTranslation['ordersDialogTotalPriceLabel']); ?></div>
                <div class="totalWorksAndPriceView">&nbsp;<b id="orderTotalWorksLabelView">0</b>;&nbsp;</div>
                <div class="totalWorksAndPriceView"><?php print($melkovTranslation['ordersDialogTotalWorksLabel']); ?></div>
                <br />
                <hr />
                
                <div id="worksTableContainerView" style="height: 180px; overflow-y: scroll;">
                </div>
            </div>
            
            <script type='text/javascript'>
                $(document).ready(function() {
                    var availableOperations = [<?php print($viewSystemAvailableOperationsList); ?>];
                    var availableEmployees = [<?php print($viewSystemAvailableEmployeesList); ?>];
                    
                    function split( val ) {
                        return val.split( /;\s*/ );
                    }
                            
                    function extractLast( term ) {
                        return split( term ).pop();
                    }
                    
                    $( "#workOperation" ).bind( "keydown", function( event ) {
                        if ( event.keyCode === $.ui.keyCode.TAB && $( this ).data( "autocomplete" ).menu.active ) {
                            event.preventDefault();
                        }
                    })
                    .autocomplete({
                        minLength: 0,
                        source: function( request, response ) {
                            response( $.ui.autocomplete.filter(
                                availableOperations, extractLast( request.term ) ) );
                        },
                        focus: function() {
                            return false;
                        },
                        select: function( event, ui ) {
                            $('#workOperation').val('');                            
                            var terms = split( this.value );
                            terms.pop();
                            terms.push( ui.item.value );
                            terms.push( "" );
                            this.value = terms.join( "; " );
                            if($.trim($('#workOperation').val()) != ''){$('#workOperation').css('background-color', '#FFFFFF');}else{$('#workOperation').css('background-color', '#FFDBDB');}
                            
                            var workOperation = $(this).JsStripTags($.trim($('#workOperation').val()));                            
                            $.ajax({
                                cache: false,
                                async: true,
                                type: "POST",
                                url: "./proc/get.operation.price.php",
                                data: "workOperation="+ workOperation,
                                success: function(getDataResponse){
                                    $('#workPrice').val(getDataResponse);
                                }
                            });
                            
                            return false;
                        }
                    });
                    
                    $( "#workOperation" ).click(function(){
                        $( "#workOperation" ).autocomplete( "search", "" );
                        $( "#workOperation" ).focus();
                    });
                    
                    
                    $( "#workEmpl" ).bind( "keydown", function( event ) {
                        if ( event.keyCode === $.ui.keyCode.TAB && $( this ).data( "autocomplete" ).menu.active ) {
                            event.preventDefault();
                        }
                    })
                    .autocomplete({
                        minLength: 0,
                        source: function( request, response ) {
                            response( $.ui.autocomplete.filter(
                                availableEmployees, extractLast( request.term ) ) );
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
                            if($.trim($('#workEmpl').val()) != ''){$('#workEmpl').css('background-color', '#FFFFFF');}else{$('#workEmpl').css('background-color', '#FFDBDB');}
                            return false;
                        }
                    });
                    
                    $( "#workEmpl" ).click(function(){
                        $( "#workEmpl" ).autocomplete( "search", "" );
                        $( "#workEmpl" ).focus();
                    });
                });
            </script>
            
            <div id="footer-bottom" class="clearfix">
                <div class="container">
                    <ul id="menu-new-menu" class="bottom-nav">
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-300"><a href="./"><?php print($melkovTranslation['homeLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item current_page_item menu-item-301"><a href="./ordersList.php"><?php print($melkovTranslation['purchaseOrdersLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-302"><a href="./customersList.php"><?php print($melkovTranslation['customersLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-303"><a href="./carsList.php"><?php print($melkovTranslation['carsLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-304"><a href="./employeesList.php"><?php print($melkovTranslation['employeesLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-305"><a href="./worksList.php"><?php print($melkovTranslation['listOfWorksLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-306"><a href="./logsList.php"><?php print($melkovTranslation['systemLogsLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-307"><a href="./commonSettings.php"><?php print($melkovTranslation['commonSettingsLinkLabel']); ?></a></li>
                    </ul>
<?php require_once('./_footer.php'); ?>
