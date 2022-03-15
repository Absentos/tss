/**
 * @author Sergey Shimkiv
 * @copyright 2011
 */
 
$(document).ready(function() {
    $.datepicker.setDefaults($.datepicker.regional['ru']);
    
    $("#langRu").wTooltip({
        content: "По-русски",
        offsetY: 15,
        offsetX: -15
    });
    
    $("#langUa").wTooltip({
        content: "Українською",
        offsetY: 15,
        offsetX: -15
    });
    
    $.fn.JsStripTags = function(stringToClear)
    {
        stringToClear = stringToClear.replace(/<\/?[^>]+>/gi, '')
        return stringToClear;
    }
    
    $('#langUa').click(function(){
        $.ajax({
            cache: false,
            async: true,
            type: "POST",
            url: "./proc/language.switching.php",
            data: "userLanguage=ua",
            success: function(getLanguageSwitchingResponse){
                window.location.href = getLanguageSwitchingResponse;
            }
        });
        
        return false;
    });
    
    $('#langRu').click(function(){
        $.ajax({
            cache: false,
            async: true,
            type: "POST",
            url: "./proc/language.switching.php",
            data: "userLanguage=ru",
            success: function(getLanguageSwitchingResponse){
                window.location.href = getLanguageSwitchingResponse;
            }
        });
        
        return false;
    });
    
    $.fn.GetUrlFileName = function()
    {
        var currentUrl = document.location.href
        currentUrl = currentUrl.substring(0, (currentUrl.indexOf("#") == -1) ? currentUrl.length : currentUrl.indexOf("#"));
        currentUrl = currentUrl.substring(0, (currentUrl.indexOf("?") == -1) ? currentUrl.length : currentUrl.indexOf("?"));
        currentUrl = currentUrl.substring(currentUrl.lastIndexOf("/") + 1, currentUrl.length);
        
        return currentUrl;
    }
    
    $.fn.ClearTableData = function(targetTable, responseMessage, dialogSize)
    {
        targetTable = $(this).JsStripTags($.trim(targetTable)); 
        responseMessage = $(this).JsStripTags($.trim(responseMessage));
        dialogSize = $(this).JsStripTags($.trim(dialogSize));
        
        $.ajax({
            cache: false,
            async: true,
            type: "POST",
            url: "./proc/clear.table.data.php",
            data: "targetTable="+ targetTable,
            success: function(getTableDataClearingResponse){
                $.jAlert('<font color="green">'+ responseMessage +'</font>', '', function(result)
                {
                    window.location.href = getTableDataClearingResponse;
                }, {show: 'drop', width: dialogSize +'px'});
            }
        });
        
        return false;
    }
    
    $.fn.ChangeTableDataStatus = function(targetId, targetTable, targetStatusField, targetIdField)
    {
        targetId = $(this).JsStripTags($.trim(targetId)); 
        targetTable = $(this).JsStripTags($.trim(targetTable));
        targetStatusField = $(this).JsStripTags($.trim(targetStatusField));
        targetIdField = $(this).JsStripTags($.trim(targetIdField));
        
        $.ajax({
            cache: false,
            async: true,
            type: "POST",
            url: "./proc/change.table.data.status.php",
            data: "targetId="+ targetId +"&targetTable="+ targetTable +"&targetStatusField="+ targetStatusField +"&targetIdField="+ targetIdField,
            success: function(getTableDataChangingStatusResponse){
                window.location.href = getTableDataChangingStatusResponse;
            }
        });
        
        return false;
    }
    
    $("#doSearch").click(function() {
        var searchData = $.trim($('#searchData').val());
        
        var currentFileName = $(this).GetUrlFileName();
        window.location.href = './'+ currentFileName +'?searchData='+ searchData;
                
        return false;    
    });
    
    $("#doSearchWithDate").click(function() {
        var searchData = $.trim($('#searchData').val());
        var searchDateFrom = $.trim($('#searchDateFrom').val());
        var searchDateTo = $.trim($('#searchDateTo').val());
        
        if(searchDateFrom != '' && searchDateTo == '')
        {
            $('#searchDateTo').val('');            
            $('#searchDateTo').css('background-color', '#FFDBDB');
            $('#searchDateTo').focus();
        }
        else if(searchDateFrom == '' && searchDateTo != '')
        {
            $('#searchDateFrom').val('');            
            $('#searchDateFrom').css('background-color', '#FFDBDB');
            $('#searchDateFrom').focus();
        }
        else
        {
            var currentFileName = $(this).GetUrlFileName();
            window.location.href = './'+ currentFileName +'?searchData='+ searchData +'&searchDateFrom='+ searchDateFrom +'&searchDateTo='+ searchDateTo;
        }
                
        return false;    
    });
    
    $('#dashBoardChartZoomResetButton').button();
    
    $('#portalDescription').click(function(){
        $('#portalDescriptionDiv').dialog('open');
        return false;
    });
    
    $('#portalLinks').click(function(){
        $('#portalLinksDiv').dialog('open');
        return false;
    });
    
    $('#portalInfo').click(function(){
        $('#portalInfoDiv').dialog('open');
        return false;
    });
    
    $('#clearSearch').click(function(){
        $('#searchData').val('');
        $('#searchData').css('background-color', '#FFDBDB');
        $('#searchData').focus();
        
        return false;
    });
    
    $('#clearSearchWithDate').click(function(){
        $('#searchData').val('');
        $('#searchDateFrom').val('');
        $('#searchDateTo').val('');
        $('#searchData').css('background-color', '#FFDBDB');
        $('#searchData').focus();
        
        return false;
    });
    
    $('#clearSystemLogsTableButton').button();
    $('#clearDataFromAllTablesButton').button();
    $('#saveOrderPrintFooterButtonLabel').button();
    $('#clearSystemWorksTableButton').button();
    $('#addSystemWorksTableButton').button();
    $('#clearSystemEmplTableButton').button();
    $('#addSystemEmplTableButton').button();
    $('#clearSystemCarsTableButton').button();
    $('#addSystemCarsTableButton').button();
    $('#clearSystemCustTableButton').button();
    $('#addSystemCustTableButton').button();
    $('#clearSystemOrdersTableButton').button();
    $('#addSystemOrdersTableButton').button();
    
    $('#setOrderWorkConnectionButton').button();
    $('#clearOrderWorkConnectionButton').button();
    $('#doSearch').button();
    $('#clearSearch').button();
    $('#doSearchWithDate').button();
    $('#clearSearchWithDate').button();
    
    $('#viewDashBoardStatisticsTable').flexigrid();    
    $('#viewSystemLogsTable').flexigrid({height: 300});    
    $('#viewSystemWorksTable').flexigrid({height: 300});
    $('#viewSystemEmplTable').flexigrid({height: 300});
    $('#viewSystemCarsTable').flexigrid({height: 300});
    $('#viewSystemCustTable').flexigrid({height: 300});
    $('#viewSystemOrdersTable').flexigrid({height: 300});
    
    $('#currentEmplBd').datepicker({
        changeMonth: true,
        changeYear: true,
        showWeek: true,
        firstDay: 1,
        minDate: new Date(1900, 1 - 1, 1),
        defaultDate: new Date(1950, 1 - 1, 1),
        showButtonPanel: true
    });
    
    $('#searchDateFrom').datepicker({
        changeMonth: true,
        changeYear: true,
        showWeek: true,
        firstDay: 1,
        minDate: new Date(1900, 1 - 1, 1),
        showButtonPanel: true
    });
    
    $('#searchDateTo').datepicker({
        changeMonth: true,
        changeYear: true,
        showWeek: true,
        firstDay: 1,
        minDate: new Date(1900, 1 - 1, 1),
        showButtonPanel: true
    });
    
    $.fn.GetCustomerCarsList = function(customerId)
    {
        customerId = $(this).JsStripTags($.trim(customerId));
        
        $.ajax({
            cache: false,
            async: true,
            type: "POST",
            url: "./proc/get.customer.cars.list.php",
            data: "customerId="+ customerId,
            success: function(getDataResponse){
                $('#carSelection').html(getDataResponse);
            }
        });
        
        $('#carSelection').removeAttr('disabled');
        $('#carSelection').focus();        
        $('#customerNextButtonContainer').html('');
                
        return false;
    }
    
    $.fn.SaveOrderData = function(customerId, customerDetails, carId, carDetails)
    {
        customerId = $(this).JsStripTags($.trim(customerId));
        customerDetails = $(this).JsStripTags($.trim(customerDetails));
        carId = $(this).JsStripTags($.trim(carId));
        carDetails = $(this).JsStripTags($.trim(carDetails));
        
        $.ajax({
            cache: false,
            async: true,
            type: "POST",
            url: "./proc/set.order.data.php",
            data: "customerId="+ customerId +"&customerDetails="+ customerDetails +"&carId="+ carId +"&carDetails="+ carDetails,
            success: function(getDataResponse){
                getDataResponse = $(this).JsStripTags($.trim(getDataResponse));
                $('#orderId').val(getDataResponse);
            }
        });
                
        return false;
    }
    
    $('#clearOrderWorkConnectionButton').click(function(){
        $('#workOperation').val('');
        $('#workComments').val('');
        $('#workCode').val('');
        $('#workPrice').val('');
        $('#workEmpl').val('');
        
        $('#workOperation').focus();
        
        return false;
    });
    
    $.fn.ChangeOrderConnectionStatus = function(targetId, targetTable, targetStatusField, targetIdField, orderId)
    {
        var targetId = $(this).JsStripTags($.trim(targetId)); 
        var targetTable = $(this).JsStripTags($.trim(targetTable));
        var targetStatusField = $(this).JsStripTags($.trim(targetStatusField));
        var targetIdField = $(this).JsStripTags($.trim(targetIdField));
        var orderId = $(this).JsStripTags($.trim(orderId));
        
        $('#worksTableContainer').html('<center><img align="middle" alt="ajax-loader" title="" id="ajax-loader" name="ajax-loader" border="0" src="./img/loader.gif" /></center>');
        $('#worksTableContainerView').html('<center><img align="middle" alt="ajax-loader" title="" id="ajax-loader" name="ajax-loader" border="0" src="./img/loader.gif" /></center>');
        
        $('#workOperation').val('');
        $('#workComments').val('');
        $('#workCode').val('');
        $('#workPrice').val('');
        $('#workEmpl').val('');
        
        $('#workOperation').focus();
        
        $.ajax({
            cache: false,
            async: true,
            type: "POST",
            url: "./proc/change.order.connection.status.php",
            data: "targetId="+ targetId +"&targetTable="+ targetTable +"&targetStatusField="+ targetStatusField +"&targetIdField="+ targetIdField +"&orderId="+ orderId,
            success: function(getDataResponse){
                $('#worksTableContainer').html(getDataResponse);
                $('#worksTableContainerView').html(getDataResponse);
                
                $.ajax({
                    cache: false,
                    async: true,
                    type: "POST",
                    url: "./proc/get.order.total.works.php",
                    data: "orderId="+ orderId,
                    success: function(getDataResponse){
                        $('#orderTotalWorksLabel').html(getDataResponse);
                        $('#orderTotalWorksLabelView').html(getDataResponse);
                    }
                });
                
                $.ajax({
                    cache: false,
                    async: true,
                    type: "POST",
                    url: "./proc/get.order.total.price.php",
                    data: "orderId="+ orderId,
                    success: function(getDataResponse){
                        $('#orderTotalPriceLabel').html(getDataResponse);
                        $('#orderTotalPriceLabelView').html(getDataResponse);
                    }
                });
            }
        });
        
        return false;
    }
    
    $.fn.ViewCurrentOrderDetails = function(orderId, orderCustDet, orderCarDet)
    {
        var orderId = $(this).JsStripTags($.trim(orderId)); 
        var orderCustDet = $(this).JsStripTags($.trim(orderCustDet));
        var orderCarDet = $(this).JsStripTags($.trim(orderCarDet));
        
        $('#worksTableContainerView').html('<center><img align="middle" alt="ajax-loader" title="" id="ajax-loader" name="ajax-loader" border="0" src="./img/loader.gif" /></center>');
        $('#customerDataTdView').html(orderCustDet);
        $('#carDataTdView').html(orderCarDet);
        
        $.ajax({
            cache: false,
            async: true,
            type: "POST",
            url: "./proc/get.order.work.connection.php",
            data: "orderId="+ orderId,
            success: function(getDataResponse){
                $('#worksTableContainerView').html(getDataResponse);
                
                $.ajax({
                    cache: false,
                    async: true,
                    type: "POST",
                    url: "./proc/get.order.total.works.php",
                    data: "orderId="+ orderId,
                    success: function(getDataResponse){
                        $('#orderTotalWorksLabelView').html(getDataResponse);                    
                    }
                });
                
                $.ajax({
                    cache: false,
                    async: true,
                    type: "POST",
                    url: "./proc/get.order.total.price.php",
                    data: "orderId="+ orderId,
                    success: function(getDataResponse){
                        $('#orderTotalPriceLabelView').html(getDataResponse);                    
                    }
                });
            }
        });
        
        $('#viewOrderDialog').dialog('open');
        
        return false;
    }
});