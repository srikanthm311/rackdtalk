<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->

<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->

<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->

<!-- BEGIN HEAD -->

<head>

	<meta charset="utf-8" />

	<title>RockTheTalk - Administrator</title>

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta content="width=device-width, initial-scale=1.0" name="viewport" />

	<meta content="" name="description" />

	<meta content="" name="author" />

	<meta name="MobileOptimized" content="320">

	<!-- BEGIN GLOBAL MANDATORY STYLES -->          

	<link href="<?php echo base_url();?>css/admin/bootstrap.min.css" rel="stylesheet" type="text/css"/>	

	<link href="<?php echo base_url();?>css/admin/login.css" rel="stylesheet" type="text/css"/>

	

	<!-- END THEME STYLES -->

	<link rel="shortcut icon" href="favicon.ico" />

    	<script src="<?php echo base_url();?>assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>



</head>



<body class="login">

	<!-- BEGIN LOGO -->

    <!-- BEGIN LOGO -->

	<div class="logo">

		<?php /*?><img src="<?php echo base_url('');?>images/imed-logos-sm.png" alt="" /> <?php */?>

	</div>

	<!-- END LOGO -->

	<!-- BEGIN LOGIN -->

	<div class="content">

		<!-- BEGIN LOGIN FORM -->

        		<form class="login-form" action="<?php echo base_url('admin/index');?>" method="post">

			<h3 class="form-title">Login to your account</h3>

			<div class="alert alert-error hide">

				<button class="close" data-dismiss="alert"></button>

				<span>Enter any username and password.</span>

			</div>

			<div class="form-group">

				<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->

				<label class="control-label visible-ie8 visible-ie9">Username</label>

				<div class="input-icon">

					<i class="icon-user"></i>

					<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username"/>

				</div>

			</div>

			<div class="form-group">

				<label class="control-label visible-ie8 visible-ie9">Password</label>

				<div class="input-icon">

					<i class="icon-lock"></i>

					<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password"/>

				</div>

			</div>

			<div class="form-actions">				

				<button type="submit" class="btn green pull-right">

				Login <i class="m-icon-swapright m-icon-white"></i>

				</button>            

			</div>

			

			

		</form>

		<!-- END LOGIN FORM -->        

		

        	</div>

	<!-- END LOGIN -->

    <footer>	<!-- BEGIN COPYRIGHT -->

	<div class="copyright">

		2017 &copy; RockTheTalk. All Rights Reserved.

	</div>

    </footer>

	<!-- END COPYRIGHT -->

	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

	<!-- BEGIN CORE PLUGINS -->   

	<!--[if lt IE 9]>

	<script src="assets/plugins/respond.min.js"></script>

	<script src="assets/plugins/excanvas.min.js"></script> 

	<![endif]-->   

	<script src="<?php echo base_url('');?>assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>

	<script src="<?php echo base_url('');?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

	<script src="<?php echo base_url('');?>assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript" ></script>

	<script src="<?php echo base_url('');?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>

	<script src="<?php echo base_url('');?>assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>  

	<script src="<?php echo base_url('');?>assets/plugins/jquery.cookie.min.js" type="text/javascript"></script>

	<script src="<?php echo base_url('');?>assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>

	<!-- END CORE PLUGINS -->

	<!-- BEGIN PAGE LEVEL PLUGINS -->

	<script src="<?php echo base_url('');?>assets/plugins/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>	

	<script type="text/javascript" src="<?php echo base_url('');?>assets/plugins/select2/select2.min.js"></script>     

	<!-- END PAGE LEVEL PLUGINS -->

	<!-- BEGIN PAGE LEVEL SCRIPTS -->

	<script src="<?php echo base_url('');?>assets/scripts/app.js" type="text/javascript"></script>

	<script src="<?php echo base_url('');?>assets/scripts/login.js" type="text/javascript"></script> 

	<!-- END PAGE LEVEL SCRIPTS --> 

	<script>

		jQuery(document).ready(function() {     

		  App.init();

		  Login.init();

		});

	</script>

	<!-- END JAVASCRIPTS -->

</body>

<!-- END BODY -->

</html>