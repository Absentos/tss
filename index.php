<?php
/**
 * @author Sergey Shimkiv
 * @copyright 2011
 */
    
    require_once('./inc/melkov.core.php');
    require_once('./inc/db.connect.inc.php');
    require_once('./inc/recaptchalib.php');
    require_once('./_header.php');
    
    $chartPlottingStartDate = GetChartPlottingStartDate(ClearMySqlVariables(''));
    
    $dashBoardChartDataOrders = GetOrdersChartData(ClearMySqlVariables(''));
    $dashBoardChartDataCustomers = GetCustomersChartData(ClearMySqlVariables(''));
?>

<div id="menu" class="clearfix">
    <div id="menu-right">
        <div id="menu-content">
            <ul id="top-menu" class="nav">
                <li id="menu-item-300" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item current_page_item menu-item-300"><a href="./"><?php print($melkovTranslation['homeLinkLabel']); ?></a></li>
                <li id="menu-item-301" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-301"><a href="./ordersList.php"><?php print($melkovTranslation['purchaseOrdersLinkLabel']); ?></a></li>
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
                <?php print($melkovTranslation['portalName']); ?> <span class="raquo">&raquo;</span> <?php print($melkovTranslation['homeLinkLabel']); ?>
            </div>
            <div id="content-area" class="clearfix">
                <div id="left-area">
                    <div class="entry post clearfix">
                        <div id="dashBoardStatistics">
                            <span style="font-size: 14px;"><?php print($melkovTranslation['statisticsTableTitleLabel']); ?></span>
                            <table id="viewDashBoardStatisticsTable">
                                <thead>
                                    <tr><th width="130"><?php print($melkovTranslation['statisticsTableTitleTLabel']); ?></th><th width="130"><?php print($melkovTranslation['statisticsTableTitleQLabel']); ?></th></tr>
                                </thead>
                                <tbody>
                                    <tr><td><?php print($melkovTranslation['statisticsTableTitleOLabel']); ?></td><td><?php print(GetCountTotalTableData(ClearMySqlVariables('purchase_orders'), '')); ?></td></tr>
                                    <tr><td><?php print($melkovTranslation['statisticsTableTitleCLabel']); ?></td><td><?php print(GetCountTotalTableData(ClearMySqlVariables('customers'), '')); ?></td></tr>
                                    <tr><td><?php print($melkovTranslation['statisticsTableTitleRLabel']); ?></td><td><?php print(GetCountTotalTableData(ClearMySqlVariables('cars'), '')); ?></td></tr>
                                    <tr><td><?php print($melkovTranslation['statisticsTableTitleELabel']); ?></td><td><?php print(GetCountTotalTableData(ClearMySqlVariables('employees'), '')); ?></td></tr>
                                    <tr><td><?php print($melkovTranslation['statisticsTableTitleWLabel']); ?></td><td><?php print(GetCountTotalTableData(ClearMySqlVariables('list_of_works'), '')); ?></td></tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="dashBoardChart"></div><br />
                    </div>
                    <div id="dashBoardChartZoomResetButton"><?php print($melkovTranslation['dashBoardChartZoomResetButtonLabel']); ?></div>
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
            
            <script type='text/javascript'>
                $(document).ready(function() {
                    var dashBoardChartDataOrders = [<?php print($dashBoardChartDataOrders); ?>];
                    var dashBoardChartDataCustomers = [<?php print($dashBoardChartDataCustomers); ?>];
                    
                    var dashBoardChartPlotter = $.jqplot('dashBoardChart', [dashBoardChartDataOrders, dashBoardChartDataCustomers], {
                        title: '<?php print($melkovTranslation['dashBoardChartTitleLabel']); ?>', 
                        gridPadding: {right: 10},
                        axesDefaults: {
                            labelRenderer: $.jqplot.CanvasAxisLabelRenderer
                        },
                        axes:{
                            xaxis:{
                                renderer: $.jqplot.DateAxisRenderer, 
                                tickOptions: {formatString:'%#d %b %y'},
                                min: '<?php print($chartPlottingStartDate); ?>', 
                                tickInterval: '1 day',
                                label: "<?php print($melkovTranslation['dashBoardChartOXTitleLabel']); ?>"
                            },
                            yaxis: {
                                label: "<?php print($melkovTranslation['dashBoardChartOYTitleLabel']); ?>"
                            }
                        },
                        legend: {
                            show: true,
                            location: 'nw',
                            xoffset: 12,
                            yoffset: 12,
                        },
                        cursor: {
                            style: 'crosshair',
                            show: true,
                            showTooltip: true,
                            zoom: true,
                            followMouse: true,
                            tooltipLocation: 'se',
                            tooltipOffset: 5,
                        },
                        series:[{lineWidth: 1, markerOptions: {style: 'circle'}, label: '<?php print($melkovTranslation['dashBoardChartLFTitleLabel']); ?>'}, {lineWidth: 1, markerOptions: {style: 'square'}, label: '<?php print($melkovTranslation['dashBoardChartLSTitleLabel']); ?>'}]
                    });
                    
                    $('#dashBoardChartZoomResetButton').click(function(){
                        dashBoardChartPlotter.resetZoom();
                        return false;
                    });
                });
            </script>
            
            <div id="footer-bottom" class="clearfix">
                <div class="container">
                    <ul id="menu-new-menu" class="bottom-nav">
                        <li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item current_page_item menu-item-300"><a href="./"><?php print($melkovTranslation['homeLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-301"><a href="./ordersList.php"><?php print($melkovTranslation['purchaseOrdersLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-302"><a href="./customersList.php"><?php print($melkovTranslation['customersLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-303"><a href="./carsList.php"><?php print($melkovTranslation['carsLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-304"><a href="./employeesList.php"><?php print($melkovTranslation['employeesLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-305"><a href="./worksList.php"><?php print($melkovTranslation['listOfWorksLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-306"><a href="./logsList.php"><?php print($melkovTranslation['systemLogsLinkLabel']); ?></a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-307"><a href="./commonSettings.php"><?php print($melkovTranslation['commonSettingsLinkLabel']); ?></a></li>
                    </ul>
<?php require_once('./_footer.php'); ?>
        