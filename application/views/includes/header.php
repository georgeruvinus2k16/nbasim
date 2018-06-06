<?php
	if(!$this->session->userdata('my_error_msg')){
		$this->session->set_userdata('my_error_msg','');
	}
 ?>
<!DOCTYPE HTML>
<html lang="us">
<head>
	<meta charset="utf-8">
	<title>NBA SIMULATOR</title>
	<link href="<?php echo base_url(); ?>css/ui-lightness/jquery-ui-1.10.2.custom.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/ui-lightness/demos.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/style_print.css" type="text/css" media="print" title="no title" charset="utf-8"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" type="text/css" media="screen" title="no title" charset="utf-8"/>
    <script src="<?php echo base_url(); ?>scripts/jquery-1.10.2.js"></script>
	<script src="<?php echo base_url(); ?>scripts/jquery-ui-1.10.2.custom.min.js"></script>
	<script src="<?php echo base_url(); ?>scripts/myjslib.js"></script>
	<script src="<?php echo base_url(); ?>scripts/myscripts.js"></script>
	
<script>
		$(function(){
			$( "input[type=submit],input[type=button]" ).button().click(function( event ) {
				//event.preventDefault();
			});
		$( document ).tooltip();
	});
</script>