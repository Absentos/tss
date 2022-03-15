/**
 * @author Sergey Shimkiv
 * @copyright 2011
 */
 
$(document).ready(function() {    
    $("#portaLogo").wTooltip({
        content: "СТО | ЧП &laquo;Мелков&raquo; &copy; 2011-2012",
        offsetY: 15,
        offsetX: -15
    });
    
    $('#portalDescriptionDiv').dialog({
        autoOpen: false,
        height: 440,
        width: 750,
        modal: true,
        show: 'drop',
        minHeight: 300,
        minWidth: 350,
        resizable: true,
        buttons: {
            'Ок' : function(){
                $(this).dialog('close');
            }
        }
    });
    
    $('#portalLinksDiv').dialog({
        autoOpen: false,
        height: 440,
        width: 750,
        modal: true,
        show: 'drop',
        minHeight: 300,
        minWidth: 350,
        resizable: true,
        buttons: {
            'Ок' : function(){
                $(this).dialog('close');
            }
        }
    });
    
    $('#portalInfoDiv').dialog({
        autoOpen: false,
        height: 440,
        width: 750,
        modal: true,
        show: 'drop',
        minHeight: 300,
        minWidth: 350,
        resizable: true,
        buttons: {
            'Ок' : function(){
                $(this).dialog('close');
            }
        }
    });
    
    $('#clearSystemLogsTableButton').click(function(){
        $.jConfirm('<font color="green">&nbsp;&nbsp;Вы уверены, что хотите удалить данные ?</font>', '', function(result)
        {
            if(result == true)
                $(this).ClearTableData('system_logs', '&nbsp;&nbsp;&nbsp;&nbsp;Журнал событий успешно очищен', '305');
        }, {show: 'drop', width: '325px'});
        
        return false;
    });
    
    $('#clearDataFromAllTablesButton').click(function(){
        $.jConfirm('<font color="green">&nbsp;&nbsp;Вы уверены, что хотите удалить данные ?</font>', '', function(result)
        {
            if(result == true)
                $(this).ClearTableData('all', '&nbsp;&nbsp;&nbsp;&nbsp;Все системные данные успешно удалены', '350');
        }, {show: 'drop', width: '325px'});
        
        return false;
    });
    
    $("#saveOrderPrintFooterButtonLabel").click(function() {
        var orderPrintFooterData = $.trim($('#orderPrintFooterData').val());
        
        if(orderPrintFooterData == '')
        {
            $('#orderPrintFooterData').val('');
            $('#orderPrintFooterData').css('background-color', '#FFDBDB');
            $('#orderPrintFooterData').focus();
        }
        else
        {
            $.ajax({
                cache: false,
                async: true,
                type: "POST",
                url: "./proc/set.setting.value.php",
                data: "settingName=orderPrintSettingsRu&settingKey=orderPrintFooterRu&settingValue="+ orderPrintFooterData,
                success: function(getSettingOrdersPrintFooterDataResponse){
                    $.jAlert('<font color="green">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Данные успешно сохранены</font>', '', function(result)
                    {
                        window.location.href = getSettingOrdersPrintFooterDataResponse;
                    }, {show: 'drop'});
                }
            });
        }
        
        return false;    
    });
    
    $('#clearSystemWorksTableButton').click(function(){
        $.jConfirm('<font color="green">&nbsp;&nbsp;Вы уверены, что хотите удалить данные ?</font>', '', function(result)
        {
            if(result == true)
                $(this).ClearTableData('list_of_works', '&nbsp;&nbsp;&nbsp;&nbsp;Справочник работ успешно очищен', '305');
        }, {show: 'drop', width: '325px'});
        
        return false;
    });
    
    $('#currentWorkDetailsDialog').dialog({
        autoOpen: false,
        height: 'auto',
        width: 350,
        modal: true,
        show: 'drop',
        minHeight: 410,
        minWidth: 350,
        resizable: false,
        buttons: {
            'Очистить' : function(){
                $('#currentWorkKey').val('');
                $('#currentWorkCategory').val('');
                $('#currentWorkValue').val('');
                $('#currentWorkPrice').val('');
                $('#currentWorkKey').focus();
            },
            'Отмена' : function(){
                $(this).dialog('close');
            },
            'Сохранить' : function(){
                var setValidationFocus = '';
                
				var workId = $(this).JsStripTags($.trim($('#currentWorkId').html()));
				if(workId == '---')
				{
					workId = '';
				}
				
                var workKey = $(this).JsStripTags($.trim($('#currentWorkKey').val()));
                var workCategory = $(this).JsStripTags($.trim($('#currentWorkCategory').val()));
                var workValue = $(this).JsStripTags($.trim($('#currentWorkValue').val()));
                var workPrice = $(this).JsStripTags($.trim($('#currentWorkPrice').val()));
                
                if((workKey == '') || (workCategory == '') || (workValue == '') || (workPrice == ''))
                {
                    if(workKey == '')
                    {
                        $('#currentWorkKey').val('');
                        if(setValidationFocus == '')
                            setValidationFocus = 'currentWorkKey';
                    }
                    
                    if(workCategory == '')
                    {
                        $('#currentWorkCategory').val('');
                        if(setValidationFocus == '')
                            setValidationFocus = 'currentWorkCategory';
                    }
                    
                    if(workValue == '')
                    {
                        $('#currentWorkValue').val('');
                        if(setValidationFocus == '')
                            setValidationFocus = 'currentWorkValue';
                    }
                    
                    if(workPrice == '')
                    {
                        $('#currentWorkPrice').val('');
                        if(setValidationFocus == '')
                            setValidationFocus = 'currentWorkPrice';
                    }
                    
                    $('#' + setValidationFocus).focus();
                }
                else
                {                
                    $.ajax({
                        cache: false,
                        async: true,
                        type: "POST",
                        url: "./proc/set.work.data.php",
                        data: "workId="+ workId +"&workKey="+ workKey +"&workCategory="+ workCategory +"&workValue="+ workValue +"&workPrice="+ workPrice,
                        success: function(getSettingWorkDataResponse){
                            $.jAlert('<font color="green">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Данные успешно сохранены</font>', '', function(result)
                            {
                                window.location.href = getSettingWorkDataResponse;
                            }, {show: 'slide'});
                        }
                    });
                }
            }
        }
    });
    
    $.fn.ViewCurrentWorkDetails = function(workId, workKey, workCategory, workValue, workPrice, workCreationDate, workEditDate, workStatus)
    {
        workId = $(this).JsStripTags($.trim(workId)); 
        workKey = $(this).JsStripTags($.trim(workKey));
        workCategory = $(this).JsStripTags($.trim(workCategory));
        workValue = $(this).JsStripTags($.trim(workValue));
        workPrice = $(this).JsStripTags($.trim(workPrice));
        workCreationDate = $(this).JsStripTags($.trim(workCreationDate));
        workEditDate = $(this).JsStripTags($.trim(workEditDate));
        workStatus = $(this).JsStripTags($.trim(workStatus));
        
        if(workStatus == 'active')
        {
            workStatus = '<font color="green">Активная</font>';
        }
        else
        {
            workStatus = '<font color="#C0C0C0">Заблокированная</font>';
        }
        
        $('#currentWorkId').html('<b><i>'+ workId +'</i></b>');
        $('#currentWorkStatus').html('<b><i>'+ workStatus +'</i></b>');
        $('#currentWorkCreationDate').html('<b><i>'+ workCreationDate +'</i></b>');
        $('#currentWorkEditDate').html('<b><i>'+ workEditDate +'</i></b>');
        $('#currentWorkKey').val(workKey);
        $('#currentWorkCategory').val(workCategory);
        $('#currentWorkValue').val(workValue);
        $('#currentWorkPrice').val(workPrice);
        
        $('#currentWorkKey').focus();
        $('#currentWorkDetailsDialog').dialog('open');
        
        return false;
    }
    
    $('#addSystemWorksTableButton').click(function(){
        $('#currentWorkId').html('<b><i>---</i></b>');
        $('#currentWorkStatus').html('<b><i>---</i></b>');
        $('#currentWorkCreationDate').html('<b><i>---</i></b>');
        $('#currentWorkEditDate').html('<b><i>---</i></b>');
        $('#currentWorkKey').val('');
        $('#currentWorkCategory').val('');
        $('#currentWorkValue').val('');
        $('#currentWorkPrice').val('');
        
        $('#currentWorkKey').focus();
        $('#currentWorkDetailsDialog').dialog('open');
        
        return false;
    });
    
    $('#clearSystemEmplTableButton').click(function(){
        $.jConfirm('<font color="green">&nbsp;&nbsp;Вы уверены, что хотите удалить данные ?</font>', '', function(result)
        {
            if(result == true)
                $(this).ClearTableData('employees', '&nbsp;&nbsp;&nbsp;&nbsp;Справочник сотрудников успешно очищен', '365');
        }, {show: 'drop', width: '325px'});
        
        return false;
    });
    
    $('#currentEmplDetailsDialog').dialog({
        autoOpen: false,
        height: 'auto',
        width: 531,
        modal: true,
        show: 'drop',
        minHeight: 545,
        minWidth: 531,
        resizable: false,
        buttons: {
            'Очистить' : function(){
                $('#currentEmplKey').val('');
                $('#currentEmplFn').val('');
                $('#currentEmplLn').val('');
                $('#currentEmplMn').val('');
                $('#currentEmplBd').val('');
                $('#currentEmplPosition').val('');
                
                $('#currentEmplPassport').val('');
                $('#currentEmplNick').val('');
                $('#currentEmplEmail').val('');
                $('#currentEmplPhone').val('');
                $('#currentEmplAddress').val('');
                $('#currentEmplIm').val('');
                $('#currentEmplSkype').val('');
                $('#currentEmplSite').val('');
                $('#currentEmplComments').val('');
                
                $('#currentEmplKey').focus();
            },
            'Отмена' : function(){
                $(this).dialog('close');
            },
            'Сохранить' : function(){
                var setValidationFocus = '';
                var emailValidationRegExp = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                
				var emplId = $(this).JsStripTags($.trim($('#currentEmplId').html()));
				if(emplId == '---')
				{
					emplId = '';
				}
				
                var emplKey = $(this).JsStripTags($.trim($('#currentEmplKey').val()));
                var emplFn = $(this).JsStripTags($.trim($('#currentEmplFn').val()));
                var emplLn = $(this).JsStripTags($.trim($('#currentEmplLn').val()));
                var emplMn = $(this).JsStripTags($.trim($('#currentEmplMn').val()));
                var emplBd = $(this).JsStripTags($.trim($('#currentEmplBd').val()));
                var emplPosition = $(this).JsStripTags($.trim($('#currentEmplPosition').val()));
                
                var emplPassport = $(this).JsStripTags($.trim($('#currentEmplPassport').val()));
                var emplNick = $(this).JsStripTags($.trim($('#currentEmplNick').val()));
                var emplEmail = $(this).JsStripTags($.trim($('#currentEmplEmail').val()));
                var emplPhone = $(this).JsStripTags($.trim($('#currentEmplPhone').val()));
                var emplAddress = $(this).JsStripTags($.trim($('#currentEmplAddress').val()));
                var emplIm = $(this).JsStripTags($.trim($('#currentEmplIm').val()));
                var emplSkype = $(this).JsStripTags($.trim($('#currentEmplSkype').val()));
                var emplSite = $(this).JsStripTags($.trim($('#currentEmplSite').val()));
                var emplComments = $(this).JsStripTags($.trim($('#currentEmplComments').val()));
                
                if((emplKey == '') || (emplFn == '') || (emplLn == '') || (emplMn == '') || (emplBd == '') || (emplPosition == ''))
                {
                    if(emplKey == '')
                    {
                        $('#currentEmplKey').val('');
                        if(setValidationFocus == '')
                            setValidationFocus = 'currentEmplKey';
                    }
                    
                    if(emplPosition == '')
                    {
                        $('#currentEmplPosition').val('');
                        if(setValidationFocus == '')
                            setValidationFocus = 'currentEmplPosition';
                    }
                    
                    if(emplBd == '')
                    {
                        $('#currentEmplBd').val('');
                        if(setValidationFocus == '')
                            setValidationFocus = 'currentEmplBd';
                    }
                    
                    if(emplLn == '')
                    {
                        $('#currentEmplLn').val('');
                        if(setValidationFocus == '')
                            setValidationFocus = 'currentEmplLn';
                    }
                    
                    if(emplFn == '')
                    {
                        $('#currentEmplFn').val('');
                        if(setValidationFocus == '')
                            setValidationFocus = 'currentEmplFn';
                    }
                    
                    if(emplMn == '')
                    {
                        $('#currentEmplMn').val('');
                        if(setValidationFocus == '')
                            setValidationFocus = 'currentEmplMn';
                    }
                    
                    $('#' + setValidationFocus).focus();
                }
                else if ((!emplEmail.match(emailValidationRegExp)) && (emplEmail != '')) 
                {
                    $('#currentEmplEmail').val('');
                    $('#currentEmplEmail').focus();
                }
                else
                {                
                    $.ajax({
                        cache: false,
                        async: true,
                        type: "POST",
                        url: "./proc/set.employee.data.php",
                        data: "emplId="+ emplId +"&emplKey="+ emplKey +"&emplFn="+ emplFn +"&emplLn="+ emplLn +"&emplMn="+ emplMn +"&emplBd="+ emplBd +"&emplPosition="+ emplPosition +"&emplPassport="+ emplPassport +"&emplNick="+ emplNick +"&emplEmail="+ emplEmail +"&emplPhone="+ emplPhone +"&emplAddress="+ emplAddress +"&emplIm="+ emplIm +"&emplSkype="+ emplSkype +"&emplSite="+ emplSite +"&emplComments="+ emplComments,
                        success: function(getSettingEmplDataResponse){
                            $.jAlert('<font color="green">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Данные успешно сохранены</font>', '', function(result)
                            {
                                window.location.href = getSettingEmplDataResponse;
                            }, {show: 'slide'});
                        }
                    });
                }
            }
        }
    });
    
    $.fn.ViewCurrentEmplDetails = function(emplId, emplKey, emplFn, emplLn, emplMn, emplBd, emplPosition, emplPassport, emplNick, emplEmail, emplPhone, emplAddress, emplIm, emplSkype, emplSite, emplComments, emplCreationDate, emplEditDate, emplStatus)
    {
        emplId = $(this).JsStripTags($.trim(emplId));
        emplKey = $(this).JsStripTags($.trim(emplKey));
        emplFn = $(this).JsStripTags($.trim(emplFn));
        emplLn = $(this).JsStripTags($.trim(emplLn));
        emplMn = $(this).JsStripTags($.trim(emplMn));
        emplBd = $(this).JsStripTags($.trim(emplBd));
        emplPosition = $(this).JsStripTags($.trim(emplPosition));
        emplPassport = $(this).JsStripTags($.trim(emplPassport));
        emplNick = $(this).JsStripTags($.trim(emplNick));
        emplEmail = $(this).JsStripTags($.trim(emplEmail));
        emplPhone = $(this).JsStripTags($.trim(emplPhone));
        emplAddress = $(this).JsStripTags($.trim(emplAddress));
        emplIm = $(this).JsStripTags($.trim(emplIm));
        emplSkype = $(this).JsStripTags($.trim(emplSkype));
        emplSite = $(this).JsStripTags($.trim(emplSite));
        emplComments = $(this).JsStripTags($.trim(emplComments));
        emplCreationDate = $(this).JsStripTags($.trim(emplCreationDate));
        emplEditDate = $(this).JsStripTags($.trim(emplEditDate));
        emplStatus = $(this).JsStripTags($.trim(emplStatus));
        
        if(emplStatus == 'active')
        {
            emplStatus = '<font color="green">Активный</font>';
        }
        else
        {
            emplStatus = '<font color="#C0C0C0">Заблокированный</font>';
        }
        
        $('#currentEmplId').html('<b><i>'+ emplId +'</i></b>');
        $('#currentEmplStatus').html('<b><i>'+ emplStatus +'</i></b>');
        $('#currentEmplCreationDate').html('<b><i>'+ emplCreationDate +'</i></b>');
        $('#currentEmplEditDate').html('<b><i>'+ emplEditDate +'</i></b>');        
        $('#currentEmplKey').val(emplKey);
        $('#currentEmplFn').val(emplFn);
        $('#currentEmplLn').val(emplLn);
        $('#currentEmplMn').val(emplMn);
        $('#currentEmplBd').val(emplBd);
        $('#currentEmplPosition').val(emplPosition);
        $('#currentEmplPassport').val(emplPassport);
        $('#currentEmplNick').val(emplNick);
        $('#currentEmplEmail').val(emplEmail);
        $('#currentEmplPhone').val(emplPhone);
        $('#currentEmplAddress').val(emplAddress);
        $('#currentEmplIm').val(emplIm);
        $('#currentEmplSkype').val(emplSkype);
        $('#currentEmplSite').val(emplSite);
        $('#currentEmplComments').val(emplComments);
        
        $('#currentEmplKey').focus();
        $('#currentEmplDetailsDialog').dialog('open');
        
        return false;
    }
    
    $('#addSystemEmplTableButton').click(function(){
        $('#currentEmplId').html('<b><i>---</i></b>');
        $('#currentEmplStatus').html('<b><i>---</i></b>');
        $('#currentEmplCreationDate').html('<b><i>---</i></b>');
        $('#currentEmplEditDate').html('<b><i>---</i></b>');        
        $('#currentEmplKey').val('');
        $('#currentEmplFn').val('');
        $('#currentEmplLn').val('');
        $('#currentEmplMn').val('');
        $('#currentEmplBd').val('');
        $('#currentEmplPosition').val('');
        $('#currentEmplPassport').val('');
        $('#currentEmplNick').val('');
        $('#currentEmplEmail').val('');
        $('#currentEmplPhone').val('');
        $('#currentEmplAddress').val('');
        $('#currentEmplIm').val('');
        $('#currentEmplSkype').val('');
        $('#currentEmplSite').val('');
        $('#currentEmplComments').val('');
        
        $('#currentEmplKey').focus();
        $('#currentEmplDetailsDialog').dialog('open');
        
        return false;
    });
    
    $('#currentCarsDetailsDialog').dialog({
        autoOpen: false,
        height: 'auto',
        width: 531,
        modal: true,
        show: 'drop',
        minHeight: 385,
        minWidth: 531,
        resizable: false,
        buttons: {
            'Очистить' : function(){
                $('#currentCarsVin').val('');
                $('#currentCarsLP').val('');
                $('#currentCarsModel').val('');
                $('#currentCarsYear').val('');
                $('#currentCarsEv').val('');
                $('#currentCarsColor').val('');
                $('#currentCarsNick').val('');                
                $('#currentCarsKey').val('');
                $('#currentCarsComments').val('');
                                
                $('#currentCarsVin').focus();
            },
            'Отмена' : function(){
                $(this).dialog('close');
            },
            'Сохранить' : function(){
                var setValidationFocus = '';
                
				var carsId = $(this).JsStripTags($.trim($('#currentCarsId').html()));
				if(carsId == '---')
				{
					carsId = '';
				}
				
                var carsVin = $(this).JsStripTags($.trim($('#currentCarsVin').val()));
                var carsLP = $(this).JsStripTags($.trim($('#currentCarsLP').val()));
                var carsModel = $(this).JsStripTags($.trim($('#currentCarsModel').val()));
                var carsYear = $(this).JsStripTags($.trim($('#currentCarsYear').val()));
                var carsEv = $(this).JsStripTags($.trim($('#currentCarsEv').val()));
                var carsColor = $(this).JsStripTags($.trim($('#currentCarsColor').val()));
                var carsNick = $(this).JsStripTags($.trim($('#currentCarsNick').val()));
                var carsKey = $(this).JsStripTags($.trim($('#currentCarsKey').val()));
                var carsComments = $(this).JsStripTags($.trim($('#currentCarsComments').val()));
                
                if((carsVin == '') || (carsLP == '') || (carsModel == '') || (carsYear == '') || (carsEv == '') || (carsNick == '') || (carsKey == '') || (carsColor == ''))
                {
                    if(carsVin == '')
                    {
                        $('#currentCarsVin').val('');
                        if(setValidationFocus == '')
                            setValidationFocus = 'currentCarsVin';
                    }
                    
                    if(carsLP == '')
                    {
                        $('#currentCarsLP').val('');
                        if(setValidationFocus == '')
                            setValidationFocus = 'currentCarsLP';
                    }
                    
                    if(carsModel == '')
                    {
                        $('#currentCarsModel').val('');
                        if(setValidationFocus == '')
                            setValidationFocus = 'currentCarsModel';
                    }
                    
                    if(carsYear == '')
                    {
                        $('#currentCarsYear').val('');
                        if(setValidationFocus == '')
                            setValidationFocus = 'currentCarsYear';
                    }
                    
                    if(carsEv == '')
                    {
                        $('#currentCarsEv').val('');
                        if(setValidationFocus == '')
                            setValidationFocus = 'currentCarsEv';
                    }
                    
                    if(carsColor == '')
                    {
                        $('#currentCarsColor').val('');
                        if(setValidationFocus == '')
                            setValidationFocus = 'currentCarsColor';
                    }
                    
                    if(carsKey == '')
                    {
                        $('#currentCarsKey').val('');
                        if(setValidationFocus == '')
                            setValidationFocus = 'currentCarsKey';
                    }
                    
                    if(carsNick == '')
                    {
                        $('#currentCarsNick').val('');
                        if(setValidationFocus == '')
                            setValidationFocus = 'currentCarsNick';
                    }
                    
                    $('#' + setValidationFocus).focus();
                }
                else
                {                
                    $.ajax({
                        cache: false,
                        async: true,
                        type: "POST",
                        url: "./proc/set.cars.data.php",
                        data: "carsId="+ carsId +"&carsVin="+ carsVin +"&carsLP="+ carsLP +"&carsModel="+ carsModel +"&carsYear="+ carsYear +"&carsNick="+ carsNick +"&carsKey="+ carsKey +"&carsComments="+ carsComments +"&carsEv="+ carsEv +"&carsColor="+ carsColor,
                        success: function(getSettingCarsDataResponse){
                            $.jAlert('<font color="green">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Данные успешно сохранены</font>', '', function(result)
                            {
                                window.location.href = getSettingCarsDataResponse;
                            }, {show: 'slide'});
                        }
                    });
                }
            }
        }
    });
    
    $.fn.ViewCurrentCarsDetails = function(carsId, carModel, carYear, carVin, carLicensePlates, carCode, carNick, carComments, carCreationDate, carEditDate, carStatus, carsEv, carsColor, carOwner)
    {
        carsId = $(this).JsStripTags($.trim(carsId));
        carModel = $(this).JsStripTags($.trim(carModel));
        carYear = $(this).JsStripTags($.trim(carYear));
        carVin = $(this).JsStripTags($.trim(carVin));
        carLicensePlates = $(this).JsStripTags($.trim(carLicensePlates));
        carCode = $(this).JsStripTags($.trim(carCode));
        carNick = $(this).JsStripTags($.trim(carNick));
        carComments = $(this).JsStripTags($.trim(carComments));
        carCreationDate = $(this).JsStripTags($.trim(carCreationDate));
        carEditDate = $(this).JsStripTags($.trim(carEditDate));
        carStatus = $(this).JsStripTags($.trim(carStatus));
        carsEv = $(this).JsStripTags($.trim(carsEv));
        carsColor = $(this).JsStripTags($.trim(carsColor));
        carOwner = $(this).JsStripTags($.trim(carOwner));
        
        if(carStatus == 'active')
        {
            carStatus = '<font color="green">Активный</font>';
        }
        else
        {
            carStatus = '<font color="#C0C0C0">Заблокированный</font>';
        }
        
        $('#currentCarsId').html('<b><i>'+ carsId +'</i></b>');
        $('#currentCarsStatus').html('<b><i>'+ carStatus +'</i></b>');
        $('#currentCarsCreationDate').html('<b><i>'+ carCreationDate +'</i></b>');
        $('#currentCarsEditDate').html('<b><i>'+ carEditDate +'</i></b>');
        $('#currentCarsVin').val(carVin);
        $('#currentCarsLP').val(carLicensePlates);
        $('#currentCarsModel').val(carModel);
        $('#currentCarsYear').val(carYear);
        $('#currentCarsNick').val(carNick);                
        $('#currentCarsKey').val(carCode);
        $('#currentCarsComments').val(carComments);
        $('#currentCarsEv').val(carsEv);
        $('#currentCarsColor').val(carsColor);
        $('#currentCarsOwners').html(carOwner);
        
        $('#currentCarsVin').focus();
        $('#currentCarsDetailsDialog').dialog('open');
        
        return false;
    }
    
    $('#addSystemCarsTableButton').click(function(){
        $('#currentCarsId').html('<b><i>---</i></b>');
        $('#currentCarsStatus').html('<b><i>---</i></b>');
        $('#currentCarsCreationDate').html('<b><i>---</i></b>');
        $('#currentCarsEditDate').html('<b><i>---</i></b>');
        $('#currentCarsVin').val('');
        $('#currentCarsLP').val('');
        $('#currentCarsModel').val('');
        $('#currentCarsYear').val('');
        $('#currentCarsEv').val('');
        $('#currentCarsColor').val('');
        $('#currentCarsNick').val('');                
        $('#currentCarsKey').val('');
        $('#currentCarsComments').val('');
        
        $('#currentCarsVin').focus();
        $('#currentCarsDetailsDialog').dialog('open');
        
        return false;
    });
    
    $('#clearSystemCarsTableButton').click(function(){
        $.jConfirm('<font color="green">&nbsp;&nbsp;Вы уверены, что хотите удалить данные ?</font>', '', function(result)
        {
            if(result == true)
                $(this).ClearTableData('cars', '&nbsp;&nbsp;&nbsp;&nbsp;Справочник автомобилей успешно очищен', '365');
        }, {show: 'drop', width: '325px'});
        
        return false;
    });
    
    $('#clearSystemCustTableButton').click(function(){
        $.jConfirm('<font color="green">&nbsp;&nbsp;Вы уверены, что хотите удалить данные ?</font>', '', function(result)
        {
            if(result == true)
                $(this).ClearTableData('customers', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Справочник клиентов успешно очищен', '365');
        }, {show: 'drop', width: '325px'});
        
        return false;
    });
    
    $('#currentCustDetailsDialog').dialog({
        autoOpen: false,
        height: 'auto',
        width: 531,
        modal: true,
        show: 'drop',
        minHeight: 590,
        minWidth: 531,
        resizable: false,
        buttons: {
            'Очистить' : function(){
                $('#currentCustLn').val('');
                $('#currentCustFn').val('');
                $('#currentCustMn').val('');
                $('#currentCustKey').val('');
                                
                $('#currentCustDebt').val('');
                $('#currentCustDebtLabel').css({'color':'#000000', 'font-weight':'normal'});
                $('#currentCustNick').val('');
                $('#currentCustEmail').val('');
                $('#currentCustPhone').val('');
                $('#currentCustAddress').val('');
                $('#currentCustIm').val('');
                $('#currentCustSkype').val('');
                $('#currentCustSite').val('');
                $('#currentCustComments').val('');
                $('#currentCustAuto').val('');
                
                $('#currentCustLn').focus();
            },
            'Отмена' : function(){
                $(this).dialog('close');
            },
            'Сохранить' : function(){
                var setValidationFocus = '';
                var emailValidationRegExp = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                
				var custId = $(this).JsStripTags($.trim($('#currentCustId').html()));
				if(custId == '---')
				{
					custId = '';
				}
				
                var custLn = $(this).JsStripTags($.trim($('#currentCustLn').val()));
                var custFn = $(this).JsStripTags($.trim($('#currentCustFn').val()));
                var custMn = $(this).JsStripTags($.trim($('#currentCustMn').val()));
                var custKey = $(this).JsStripTags($.trim($('#currentCustKey').val()));
                
                var custDebt = $(this).JsStripTags($.trim($('#currentCustDebt').val()));
                var custNick = $(this).JsStripTags($.trim($('#currentCustNick').val()));
                var custEmail = $(this).JsStripTags($.trim($('#currentCustEmail').val()));
                var custPhone = $(this).JsStripTags($.trim($('#currentCustPhone').val()));
                var custAddress = $(this).JsStripTags($.trim($('#currentCustAddress').val()));
                var custIm = $(this).JsStripTags($.trim($('#currentCustIm').val()));
                var custSkype = $(this).JsStripTags($.trim($('#currentCustSkype').val()));
                var custSite = $(this).JsStripTags($.trim($('#currentCustSite').val()));
                var custComments = $(this).JsStripTags($.trim($('#currentCustComments').val()));
                var custAuto = $(this).JsStripTags($.trim($('#currentCustAuto').val()));
                
                if((custKey == '') || (custFn == '') || (custLn == '') || (custMn == '') || (custAuto == ''))
                {                    
                    if(custLn == '')
                    {
                        $('#currentCustLn').val('');
                        if(setValidationFocus == '')
                            setValidationFocus = 'currentCustLn';
                    }
                    
                    if(custFn == '')
                    {
                        $('#currentCustFn').val('');
                        if(setValidationFocus == '')
                            setValidationFocus = 'currentCustFn';
                    }
                    
                    if(custMn == '')
                    {
                        $('#currentCustMn').val('');
                        if(setValidationFocus == '')
                            setValidationFocus = 'currentCustMn';
                    }
                    
                    if(custKey == '')
                    {
                        $('#currentCustKey').val('');
                        if(setValidationFocus == '')
                            setValidationFocus = 'currentCustKey';
                    }
                    
                    if(custAuto == '')
                    {
                        $('#currentCustAuto').val('');
                        if(setValidationFocus == '')
                            setValidationFocus = 'currentCustAuto';
                    }
                    
                    $('#' + setValidationFocus).focus();
                }
                else if((isNaN(custDebt)) && (custDebt != '')) 
                {
                    $('#currentCustDebt').val('');
                    $('#currentCustDebtLabel').css({'color':'#000000', 'font-weight':'normal'});
                    $('#currentCustDebt').focus();
                }
                else if ((!custEmail.match(emailValidationRegExp)) && (custEmail != '')) 
                {
                    $('#currentCustEmail').val('');
                    $('#currentCustEmail').focus();
                }
                else
                {                
                    $.ajax({
                        cache: false,
                        async: true,
                        type: "POST",
                        url: "./proc/set.customer.data.php",
                        data: "custId="+ custId +"&custKey="+ custKey +"&custFn="+ custFn +"&custLn="+ custLn +"&custMn="+ custMn +"&custDebt="+ custDebt +"&custNick="+ custNick +"&custEmail="+ custEmail +"&custPhone="+ custPhone +"&custAddress="+ custAddress +"&custIm="+ custIm +"&custSkype="+ custSkype +"&custSite="+ custSite +"&custComments="+ custComments +"&custAuto="+ custAuto,
                        success: function(getSettingCustDataResponse){
                            $.jAlert('<font color="green">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Данные успешно сохранены</font>', '', function(result)
                            {
                                window.location.href = getSettingCustDataResponse;
                            }, {show: 'slide'});
                        }
                    });
                }
            }
        }
    });
    
    $.fn.ViewCurrentCustDetails = function(custId, custKey, custFn, custLn, custMn, custDebt, custNick, custEmail, custPhone, custAddress, custIm, custSkype, custSite, custComments, custCreationDate, custEditDate, custStatus, custAuto)
    {
        custId = $(this).JsStripTags($.trim(custId));
        custKey = $(this).JsStripTags($.trim(custKey));
        custFn = $(this).JsStripTags($.trim(custFn));
        custLn = $(this).JsStripTags($.trim(custLn));
        custMn = $(this).JsStripTags($.trim(custMn));
        custDebt = $(this).JsStripTags($.trim(custDebt));
        custNick = $(this).JsStripTags($.trim(custNick));
        custEmail = $(this).JsStripTags($.trim(custEmail));
        custPhone = $(this).JsStripTags($.trim(custPhone));
        custAddress = $(this).JsStripTags($.trim(custAddress));
        custIm = $(this).JsStripTags($.trim(custIm));
        custSkype = $(this).JsStripTags($.trim(custSkype));
        custSite = $(this).JsStripTags($.trim(custSite));
        custComments = $(this).JsStripTags($.trim(custComments));
        custCreationDate = $(this).JsStripTags($.trim(custCreationDate));
        custEditDate = $(this).JsStripTags($.trim(custEditDate));
        custStatus = $(this).JsStripTags($.trim(custStatus));
        custAuto = $(this).JsStripTags($.trim(custAuto));
        
        if(custStatus == 'active')
        {
            custStatus = '<font color="green">Активный</font>';
            $('#currentCustAuto').removeAttr('disabled');
        }
        else
        {
            custStatus = '<font color="#C0C0C0">Заблокированный</font>';
            $('#currentCustAuto').attr('disabled', 'disabled');
        }
        
        $('#currentCustId').html('<b><i>'+ custId +'</i></b>');
        $('#currentCustStatus').html('<b><i>'+ custStatus +'</i></b>');
        $('#currentCustCreationDate').html('<b><i>'+ custCreationDate +'</i></b>');
        $('#currentCustEditDate').html('<b><i>'+ custEditDate +'</i></b>');        
        $('#currentCustLn').val(custLn);
        $('#currentCustFn').val(custFn);
        $('#currentCustMn').val(custMn);
        $('#currentCustKey').val(custKey);
        
        if(custDebt != '')
        {
            $('#currentCustDebtLabel').css({'color':'#EE2F0D', 'font-weight':'bold'});
        }
        else
        {
            $('#currentCustDebtLabel').css({'color':'#000000', 'font-weight':'normal'});
        }
        $('#currentCustDebt').val(custDebt);
        
        $('#currentCustNick').val(custNick);
        $('#currentCustEmail').val(custEmail);
        $('#currentCustPhone').val(custPhone);
        $('#currentCustAddress').val(custAddress);
        $('#currentCustIm').val(custIm);
        $('#currentCustSkype').val(custSkype);
        $('#currentCustSite').val(custSite);
        $('#currentCustComments').val(custComments);
        $('#currentCustAuto').val(custAuto);
        
        $('#currentCustLn').focus();
        $('#currentCustDetailsDialog').dialog('open');
        
        return false;
    }
    
    $('#addSystemCustTableButton').click(function(){
        $('#currentCustId').html('<b><i>---</i></b>');
        $('#currentCustStatus').html('<b><i>---</i></b>');
        $('#currentCustCreationDate').html('<b><i>---</i></b>');
        $('#currentCustEditDate').html('<b><i>---</i></b>');        
        $('#currentCustLn').val('');
        $('#currentCustFn').val('');
        $('#currentCustMn').val('');
        $('#currentCustKey').val('');
        $('#currentCustDebt').val('');
        $('#currentCustNick').val('');
        $('#currentCustEmail').val('');
        $('#currentCustPhone').val('');
        $('#currentCustAddress').val('');
        $('#currentCustIm').val('');
        $('#currentCustSkype').val('');
        $('#currentCustSite').val('');
        $('#currentCustComments').val('');
        $('#currentCustAuto').val('');
        $('#currentCustAuto').removeAttr('disabled');
        
        $('#currentCustLn').focus();
        $('#currentCustDetailsDialog').dialog('open');
        
        return false;
    });
    
    $('#clearSystemOrdersTableButton').click(function(){
        $.jConfirm('<font color="green">&nbsp;&nbsp;Вы уверены, что хотите удалить данные ?</font>', '', function(result)
        {
            if(result == true)
                $(this).ClearTableData('purchase_orders', '&nbsp;&nbsp;&nbsp;Справочник заказ-нарядов успешно очищен', '365');
        }, {show: 'drop', width: '325px'});
        
        return false;
    });
    
    $('#addSystemOrdersTableButton').click(function(){
        $('#customerDataTd').html('<center id="custCenterData">- НЕТ ДАННЫХ -</center>');
        $('#carSelection').html('<option value="-1">---</option>');
        $('#carSelection').attr('disabled', 'disabled');
        $('#carDataTd').html('<center id="carCenterData">- НЕТ ДАННЫХ -</center>');
        
        $('#orderCreationTmpMessage').html('<center id="worksCenterData">- НЕТ ДАННЫХ -</center>');
        $('#orderCreationTmpMessage').addClass('visibleVisibility');
        $('#orderCreationTmpMessage').removeClass('hiddenVisibility');
        $('#orderCreationWorksContainer').removeClass('visibleVisibility');
        $('#orderCreationWorksContainer').addClass('hiddenVisibility');
        
        $('#defaultCustomer').attr('selected', 'selected');
        $('#customerSelection').focus();
        
        $('#createOrderDialog').dialog('open');
        
        return false;
    });
    
    $('#createOrderDialog').dialog({
        autoOpen: false,
        width: 700,
        height: 'auto',
        modal: true,
        show: 'drop',
        minWidth: 700,
        minHeight: 700,
        resizable: false,
        buttons: {
            'Очистить' : function(){
                $('#customerDataTd').html('<center id="custCenterData">- НЕТ ДАННЫХ -</center>');
                $('#carSelection').html('<option value="-1">---</option>');
                $('#carSelection').attr('disabled', 'disabled');
                $('#carDataTd').html('<center id="carCenterData">- НЕТ ДАННЫХ -</center>');
                            
                $('#orderCreationTmpMessage').html('<center id="worksCenterData">- НЕТ ДАННЫХ -</center>');
                $('#orderCreationTmpMessage').addClass('visibleVisibility');
                $('#orderCreationTmpMessage').removeClass('hiddenVisibility');
                $('#orderCreationWorksContainer').removeClass('visibleVisibility');
                $('#orderCreationWorksContainer').addClass('hiddenVisibility');
                
                $('#worksTableContainer').html('<center>- НЕТ ДАННЫХ -</center>');
                $('#workOperation').val('');
                $('#workComments').val('');
                $('#workCode').val('');
                $('#workPrice').val('');
                $('#workEmpl').val('');
                
                $('#orderTotalPriceLabel').html('0.00');
                $('#orderTotalWorksLabel').html('0');
                
                $('#defaultCustomer').attr('selected', 'selected');
                $('#customerSelection').focus();
            },
            'Закрыть и обновить' : function(){
                $(this).dialog('close');
                window.location.href = './ordersList.php';
            }
        }
    });
    
    $.fn.GetCustomerData = function(customerId)
    {
        customerId = $(this).JsStripTags($.trim(customerId)); 
        
        if(customerId != '-1')
        {
            $('#custCenterData').html('<img align="middle" alt="ajax-loader" title="" id="ajax-loader" name="ajax-loader" border="0" src="./img/loader.gif" />');
            $('#customerDataTd').html('<center id="custCenterData">- НЕТ ДАННЫХ -</center>');
            $('#carSelection').html('<option value="-1">---</option>');
            $('#carSelection').attr('disabled', 'disabled');
            $('#carDataTd').html('<center id="carCenterData">- НЕТ ДАННЫХ -</center>');
            
            $('#worksTableContainer').html('<center>- НЕТ ДАННЫХ -</center>');
            $('#workOperation').val('');
            $('#workComments').val('');
            $('#workCode').val('');
            $('#workPrice').val('');
            $('#workEmpl').val('');
            
            $('#orderTotalPriceLabel').html('0.00');
            $('#orderTotalWorksLabel').html('0');
            
            $('#orderCreationTmpMessage').html('<center id="worksCenterData">- НЕТ ДАННЫХ -</center>');
            $('#orderCreationTmpMessage').addClass('visibleVisibility');
            $('#orderCreationTmpMessage').removeClass('hiddenVisibility');
            $('#orderCreationWorksContainer').removeClass('visibleVisibility');
            $('#orderCreationWorksContainer').addClass('hiddenVisibility');
            
            $.ajax({
                cache: false,
                async: true,
                type: "POST",
                url: "./proc/get.customer.data.php",
                data: "customerId="+ customerId,
                success: function(getDataResponse){
                    $('#customerDataTd').html(getDataResponse);
                }
            });
        }     
        else
        {
            $('#customerDataTd').html('<center id="custCenterData">- НЕТ ДАННЫХ -</center>');
            $('#carSelection').html('<option value="-1">---</option>');
            $('#carSelection').attr('disabled', 'disabled');
            $('#carDataTd').html('<center id="carCenterData">- НЕТ ДАННЫХ -</center>');
            
            $('#worksTableContainer').html('<center>- НЕТ ДАННЫХ -</center>');
            $('#workOperation').val('');
            $('#workComments').val('');
            $('#workCode').val('');
            $('#workPrice').val('');
            $('#workEmpl').val('');
            
            $('#orderTotalPriceLabel').html('0.00');
            $('#orderTotalWorksLabel').html('0');
            
            $('#orderCreationTmpMessage').html('<center id="worksCenterData">- НЕТ ДАННЫХ -</center>');
            $('#orderCreationTmpMessage').addClass('visibleVisibility');
            $('#orderCreationTmpMessage').removeClass('hiddenVisibility');
            $('#orderCreationWorksContainer').removeClass('visibleVisibility');
            $('#orderCreationWorksContainer').addClass('hiddenVisibility');
        }
        
        return false;
    }
    
    $.fn.GetCarData = function(carId)
    {
        carId = $(this).JsStripTags($.trim(carId)); 
        
        if(carId != '-1')
        {
            $('#carCenterData').html('<img align="middle" alt="ajax-loader" title="" id="ajax-loader" name="ajax-loader" border="0" src="./img/loader.gif" />');
            $('#orderCreationTmpMessage').html('<center id="worksCenterData">- НЕТ ДАННЫХ -</center>');
            
            $('#worksTableContainer').html('<center>- НЕТ ДАННЫХ -</center>');
            $('#workOperation').val('');
            $('#workComments').val('');
            $('#workCode').val('');
            $('#workPrice').val('');
            $('#workEmpl').val('');
            
            $('#orderTotalPriceLabel').html('0.00');
            $('#orderTotalWorksLabel').html('0');
            
            $('#orderCreationTmpMessage').addClass('visibleVisibility');
            $('#orderCreationTmpMessage').removeClass('hiddenVisibility');
            $('#orderCreationWorksContainer').removeClass('visibleVisibility');
            $('#orderCreationWorksContainer').addClass('hiddenVisibility');
            
            $.ajax({
                cache: false,
                async: true,
                type: "POST",
                url: "./proc/get.car.data.php",
                data: "carId="+ carId,
                success: function(getDataResponse){
                    $('#carDataTd').html(getDataResponse);
                    $('#currentCarsKm').focus();
                }
            });
        }     
        else
        {
            $('#carDataTd').html('<center id="carCenterData">- НЕТ ДАННЫХ -</center>');
            $('#orderCreationTmpMessage').html('<center id="worksCenterData">- НЕТ ДАННЫХ -</center>');
            
            $('#worksTableContainer').html('<center>- НЕТ ДАННЫХ -</center>');
            $('#workOperation').val('');
            $('#workComments').val('');
            $('#workCode').val('');
            $('#workPrice').val('');
            $('#workEmpl').val('');
            
            $('#orderTotalPriceLabel').html('0.00');
            $('#orderTotalWorksLabel').html('0');
            
            $('#orderCreationTmpMessage').addClass('visibleVisibility');
            $('#orderCreationTmpMessage').removeClass('hiddenVisibility');
            $('#orderCreationWorksContainer').removeClass('visibleVisibility');
            $('#orderCreationWorksContainer').addClass('hiddenVisibility');
        }
        
        return false;
    }
    
    $.fn.GetOrderWorksVisible = function()
    {
        var currentCarsKm = $(this).JsStripTags($.trim($('#currentCarsKm').val()));
        
        if(currentCarsKm == '')
        {
            $('#currentCarsKm').val('');
            $('#currentCarsKm').focus();
        }
        else if((isNaN(currentCarsKm)) && (currentCarsKm != '')) 
        {
            $('#currentCarsKm').val('');
            $('#currentCarsKm').focus();
        }
        else
        {        
            var carDataBuffer = $('#carDataTd').html();
            $('#carDataTd').html(carDataBuffer + $('#currentCarsKmLabel').html() + currentCarsKm);
            
            $('#carNextButtonContainer').html('');
            $('#orderCreationTmpMessage').html('');
            $('#orderCreationTmpMessage').removeClass('visibleVisibility');
            $('#orderCreationTmpMessage').addClass('hiddenVisibility');
            $('#orderCreationWorksContainer').removeClass('hiddenVisibility');
            $('#orderCreationWorksContainer').addClass('visibleVisibility');
            
            var customerId = $('#customerSelection').val();
            var customerDetails = 'Ф.И.О.: ' + $('#customerSelection option:selected').html() + '; ' + $('#customerDataTd').html();
            var carId = $('#carSelection').val();
            var carDetails = 'Номерные знаки: ' + $('#carSelection option:selected').html() + '; ' + $('#carDataTd').html();
                    
            $('#currentCarsKm').attr('disabled', 'disabled');
                                
            $('#workOperation').focus();
                    
            $(this).SaveOrderData(customerId, customerDetails, carId, carDetails);
            
            $.ajax({
                cache: false,
                async: true,
                type: "POST",
                url: "./proc/set.car.mileage.data.php",
                data: "carId="+ carId +"&carKm="+ currentCarsKm
            });
        }
        
        return false;
    }
    
    $('#setOrderWorkConnectionButton').click(function(){
        var setValidationFocus = '';
        var workOperation = $(this).JsStripTags($.trim($('#workOperation').val()));
        var workComments = $(this).JsStripTags($.trim($('#workComments').val()));
        var workCode = $(this).JsStripTags($.trim($('#workCode').val()));
        var workPrice = $(this).JsStripTags($.trim($('#workPrice').val()));
        var workEmpl = $(this).JsStripTags($.trim($('#workEmpl').val()));
        var orderId = $(this).JsStripTags($.trim($('#orderId').val()));
        
        if((workOperation == '') || (workComments == '') || (workCode == '') || (workPrice == '') || (workEmpl == ''))
        {                    
            if(workOperation == '')
            {
                $('#workOperation').val('');
                if(setValidationFocus == '')
                    setValidationFocus = 'workOperation';
            }
            
            if(workComments == '')
            {
                $('#workComments').val('');
                if(setValidationFocus == '')
                    setValidationFocus = 'workComments';
            }
            
            if(workCode == '')
            {
                $('#workCode').val('');
                if(setValidationFocus == '')
                    setValidationFocus = 'workCode';
            }                    
            
            if(workPrice == '')
            {
                $('#workPrice').val('');
                if(setValidationFocus == '')
                    setValidationFocus = 'workPrice';
            }
            
            if(workEmpl == '')
            {
                $('#workEmpl').val('');
                if(setValidationFocus == '')
                    setValidationFocus = 'workEmpl';
            }
            
            $('#' + setValidationFocus).focus();
        }
        else if((isNaN(workPrice)) && (workPrice != '')) 
        {
            $('#workPrice').val('');
            $('#workPrice').focus();
        }
        else if(orderId == '')
        {
            $.jAlert('Ошибка выполнения сценария: <br />"orderId" is Null', 'error', function(result){}, {show: 'slide'});
        }
        else
        {
            $('#worksTableContainer').html('<center><img align="middle" alt="ajax-loader" title="" id="ajax-loader" name="ajax-loader" border="0" src="./img/loader.gif" /></center>');
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
                url: "./proc/set.order.work.connection.php",
                data: "workOperation="+ workOperation +"&workComments="+ workComments +"&workCode="+ workCode +"&workPrice="+ workPrice +"&workEmpl="+ workEmpl +"&orderId="+ orderId,
                success: function(getDataResponse){
                    $('#worksTableContainer').html(getDataResponse);
                    
                    $.ajax({
                        cache: false,
                        async: true,
                        type: "POST",
                        url: "./proc/get.order.total.works.php",
                        data: "orderId="+ orderId,
                        success: function(getDataResponse){
                            $('#orderTotalWorksLabel').html(getDataResponse);                    
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
                        }
                    });
                }
            });
        }
        
        return false;
    });
    
    $('#viewOrderDialog').dialog({
        autoOpen: false,
        width: 700,
        height: 'auto',
        modal: true,
        show: 'drop',
        minWidth: 700,
        minHeight: 600,
        resizable: false,
        buttons: {
            'Закрыть' : function(){
                $(this).dialog('close');
            }
        }
    });
});