<?php
/*
 * Template header file
 * date 27-07-2015
 * @Author Joe
 * 
 */
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
		<meta name="viewport" content="initial-scale=1">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $CFG['metatag']['metatitle'];?></title>
		<meta name="description" content="<?php echo $CFG['metatag']['metadescription'];?>">
		<meta name="keywords" content="<?php echo $CFG['metatag']['metakeyword'];?>">
		<!--------------Bootstrap CSS And JS--------------->
		<link href="<?php echo $CFG['site']['css']['path'];?>bootstrap.css" type="text/css" rel="stylesheet">
		<!--------------Custom CSS--------------->
		<link href="<?php echo $CFG['site']['css']['path'];?>style.css" type="text/css" rel="stylesheet">		
		<!--------------Responsive CSS--------------->
		<link href="<?php echo $CFG['site']['css']['path'];?>responsive.css" type="text/css" rel="stylesheet">
		<link href="<?php echo $CFG['site']['css']['path'];?>fonts/font_family.css" type="text/css" rel="stylesheet">
		<link href="<?php echo $CFG['site']['css']['path'];?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<!--------------Fonts--------------->
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i" rel="stylesheet"> 
		<link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
		<!--[if IE]>
		  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<!--[if lte IE 7]>
		  <script src="js/IE8.js" type="text/javascript"></script><![endif]-->
		<!--[if lt IE 7]>
		<link rel="stylesheet" type="text/css" media="all" href="css/ie6.css"/><![endif]-->
	</head>
	<body>
	    
	    <?php /* Top referesh start from here*/?> 
<?php if(isMember()){?>
<div class="header">
	<div class="container1">
		<!-- <div class="logo text-center">			
			<span style="float:right"><a href="<?php echo getUrl('logout');?>">Logout</a></span>
		</div> -->
		<div class="menu-bar-sec col-md-12 col-sm-12 col-xs-12">
			<nav class="navbar">
				<ul class="dis-inline col-md-5 col-sm-5 col-xs-5" style="margin-top:18px;text-align:right;padding-right:0px;">
					 <?php $index->getRefresh();?>
				</ul>
				<span style="float:right"><a href="<?php echo getUrl('logout');?>">Logout</a></span>
			</nav>
		</div>
	</div>
</div>
<?php } ?>
	    