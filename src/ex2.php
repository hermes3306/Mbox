<?php 
	$mbox_home	=	getenv('mbox_home',true) ? getenv('mbox_home', true) : '.';
	require 	$mbox_home . '/vendor/autoload.php';
	require 	$mbox_home . '/src/mbox.php';

	$mbox = new mbox($mbox_home . '/mbox.ini');

	$body = 	
'<!doctype html>
<!--[if IE 7 ]>    <html lang="en-gb" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en-gb" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en-gb" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="ko-KR"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>Waffle  </title>
	
	<meta name="description" content="">
	<meta name="author" content="">
    
    <!-- **CSS - stylesheets** -->
    <link id="default-css" href="https://waffle.at/wp-content/themes/waffle/style.css" rel="stylesheet" media="all" />
    <link id="shortcodes-css" href="https://waffle.at/wp-content/themes/waffle/shortcodes.css" rel="stylesheet" type="text/css" media="all" />  
    <link id="skin-css" href="https://waffle.at/wp-content/themes/waffle/skins/portfolio/style.css" rel="stylesheet" media="all" />
    <link id="responsive-css" href="https://waffle.at/wp-content/themes/waffle/responsive.css" rel="stylesheet" type="text/css" media="all" />    
    
    <!-- **Font Awesome** -->
    <!--[if IE 7]>
    <link rel="stylesheet" href="https://waffle.at/wp-content/themes/waffle/css/font-awesome-ie7.min.css">
    <![endif]-->
    
        <!-- **Favicon** -->
    <link href="https://waffle.at/wp-content/uploads/2013/08/favicon.ico" rel="shortcut icon" type="image/x-icon" />
</head>
<body>

</body>
</html>
';


	$mbox->setBody($body);
	$mbox->send();

?>
	

