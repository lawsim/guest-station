<!DOCTYPE html> 
<html> 
	<head> 
	<title>Test Card Scan</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>themes/style.css" />
	<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
    <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
    <script src="<?php echo base_url();?>assets/jquery.ba-throttle-debounce.js"></script>
    <script src="<?php echo base_url();?>assets/jquery-ui-1.12.0.custom/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/jquery-ui-1.12.0.custom/jquery-ui.css" />
	
</head> 
<body> 

<div data-role="page">

	<div data-role="header">
		<h1><?php echo (isset($title) ? $title : "Archeage"); ?></h1>
		<div data-role="controlgroup" data-type="horizontal" class="ui-mini ui-btn-left">
			<a href="<?php echo site_url('guest_station'); ?>" class="ui-btn ui-btn-icon-right ui-icon-home" data-ajax="false">Home</a>
		</div>
	</div><!-- /header -->

	<div data-role="content" data-theme="a">