<?php
/**
 * @author Sergey Shimkiv
 * @copyright 2011
 */
    
    @session_start();
    
    if(isset($_COOKIE['userLanguage']))
    {
        $_SESSION['userLanguage'] = ClearCommonVariables($_COOKIE['userLanguage']);
        $userLanguage = $_SESSION['userLanguage']; 
    }
    else
    {
        $userBrowserLanguage = GetUserLocaleLanguage();
        setcookie('userLanguage', ClearCommonVariables($userBrowserLanguage), time() + 60 * 60 * 24 * 500, '/');
        $_SESSION['userLanguage'] = ClearCommonVariables($_COOKIE['userLanguage']);
        $userLanguage = ClearCommonVariables($userBrowserLanguage); 
    }
    
    if($userLanguage == 'ru')
    {
        require_once('./inc/melkov.lang.ru.php');
    }
    
    if($userLanguage == 'ua')
    {
        require_once('./inc/melkov.lang.ua.php');
    }
        
    $recaptchaPublicKey         = '6LclrsISAAAAAI8EQJSQYwJw5KzW45_ChuBNQoEd';
    $recaptchaPrivateKey        = '6LclrsISAAAAANyrOb1YVPJWY0Tvi40oCEMjfIsY';
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='<?php print($userLanguage); ?>' lang='<?php print($userLanguage); ?>'>

<head>
    <meta http-equiv='content-type' content='text/html; charset=utf-8' />
    <meta name='description' content='<?php print($melkovTranslation['portalDescription']); ?>' />
    <meta name='keywords' content='<?php print($melkovTranslation['portalKeywords']); ?>' /> 
    <meta name='author' content='<?php print($melkovTranslation['portalAuthor']); ?>' />

    <title><?php print($melkovTranslation['portalTitle']); ?></title>
    
    <link rel='shortcut icon' href='./img/portal.icon.ico' />
    <link rel='stylesheet' href='./css/melkov.style.css' type='text/css' media='screen' />
    <link rel='stylesheet' type='text/css' href='./css/jquery.jqplot.css' />
    <link rel='stylesheet' type='text/css' href='./css/flexigrid.css' />
    
    <!--[if lt IE 8]>
        <script type="text/javascript">
            window.location.href = './error/?code=ie';
        </script>
    <![endif]-->
    
    <script type='text/javascript'>
        document.documentElement.className = 'js';
    </script>
    
    <link media='screen' type='text/css' href='./css/jsui/jquery.ui.all.css' rel='stylesheet' />
    <link media='screen' type='text/css' href='./css/jquery.fancybox.1.3.4.css' rel='stylesheet' />
    <link media='screen' type='text/css' href='./css/page.templates.css' rel='stylesheet' />
    <link rel='stylesheet' id='et-shortcodes-css-css' href='./css/shortcodes.css' type='text/css' media='all' />
    
    <!--[if lt IE 9]>
        <script type='text/javascript' src='./js/excanvas.js'></script>
    <![endif]-->
    
    <script type='text/javascript' src='./js/jquery.1.6.4.js'></script>
    <script type='text/javascript' src='./js/l10n.js'></script>
    <script type='text/javascript' src='./js/et.shortcodes.frontend.js'></script>
    <script type='text/javascript' src='./js/cufon.yui.js'></script>
    <script type='text/javascript' src='./js/jquery.jqplot.js'></script>
    <script type='text/javascript' src='./js/jqplot.canvasTextRenderer.js'></script>
    <script type='text/javascript' src='./js/jqplot.canvasAxisLabelRenderer.js'></script>
    <script type='text/javascript' src='./js/jqplot.dateAxisRenderer.js'></script>
    <script type='text/javascript' src='./js/jqplot.cursor.js'></script>
    <script type='text/javascript' src='./js/colaborate.thin.400.font.js'></script>
    <script type='text/javascript' src='./js/jquery.ui.js'></script>
    <script type='text/javascript' src='./js/jquery.ui.datepicker.<?php print($userLanguage); ?>.js'></script>
    <script type='text/javascript' src='./js/jquery.cycle.all.js'></script>
    <script type='text/javascript' src='./js/superfish.js'></script>
    <script type='text/javascript' src='./js/flexigrid.<?php print($userLanguage); ?>.js'></script>
    <script type='text/javascript' src='./js/jquery.easing.1.3.pack.js'></script>
    <script type='text/javascript' src='./js/jquery.fancybox.1.3.4.js'></script>
    <script type='text/javascript' src='./js/et.ptemplates.frontend.js'></script>
    <script type='text/javascript' src='./js/jquery.ui.jalert.<?php print($userLanguage); ?>.js'></script>
    <script type='text/javascript' src='./js/wtooltip.js'></script>
    <script type='text/javascript' src='./js/melkov.lang.<?php print($userLanguage); ?>.js'></script>
    <script type='text/javascript' src='./js/melkov.common.js'></script>
    <script type='text/javascript' src='./js/melkov.core.js'></script>
</head>

<body class="page page-id-325 page-template page-template-page-full-php">
    <div id="top">
        <div id="top-wrapper">
            <div id="top-content">
                <div id="bottom-light">
                    <div class="container">
                        <a href="./">
                            <img src="./img/portal.logo.png" alt="Logo" id="portaLogo" style="padding-top: 10px; padding-bottom: 10px;" />
                        </a>
                        