<!DOCTYPE html>



<html lang="en">

<head>

<meta charset="utf-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>RockTheTalk</title>

<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('');?>admin/images/favicon.ico">

<link href="<?php echo base_url('');?>css/admin/backend.css" rel="stylesheet">

<link href="<?php echo base_url('');?>css/admin/style-color-backend.css" rel="stylesheet">

<link href="<?php echo base_url('');?>css/admin/jquery-ui.css" rel="stylesheet">

<!-- Bootstrap -->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">



<link href="<?php echo base_url('');?>css/admin/bootstrap.css" rel="stylesheet">

<link href="<?php echo base_url('');?>css/admin/style-color.css" rel="stylesheet">

</head>



<body>

<script src="<?php echo base_url('');?>js/admin/jquery.min.js"></script> 

<script src="<?=base_url('js/admin/jquery-ui.js');?>"></script>

<script src="<?php echo base_url('');?>js/admin/bootstrap.min.js"></script> 

<script src="<?php echo base_url('');?>js/admin/common.js"></script> 

<script type="text/javascript">

$(document).ready(function(){

	$("input[type='text'], input[type='password']").each(function(){

		$(this).attr("autocapitalize", "off");

	});

});

</script>

<script type="text/javascript" >

$(document).ready(function()

{

$("#notificationLink").click(function()

{

$("#notificationContainer").fadeToggle(300);

$("#notification_count").fadeOut("slow");

return false;

});







//Popup on click

$("#notificationContainer").click(function()

{

return false;

});







$("body").click(function(e) {

    if ($(e.target).attr('id') == 'notificationContainer') {

        return;

    } else {

        $('#notificationContainer').fadeOut();

    }

});







});

</script>

<style>

label.error{

	background:none;

	padding:0px;

	border:none;

}

a#notificationLink {

    background-color: #047F8E;

    padding: 7px 12px;

    float: right;

    margin-top: 2px;

    border-radius: 7px;

    border: 1px solid #23b0a5;

    line-height: 17px;

}

i.fa.fa-bell {

    color: #f8f8f8;

}

a#notificationLink:hover {

    background-color: #fff;

    border: 1px solid #23b0a5;

}

a#notificationLink:hover i.fa {

     color: #23b0a5;

}

#nav{list-style:none;margin: 0px;padding: 0px;}

#nav li {

float: left;

margin-right: 20px;

font-size: 14px;

font-weight:bold;

}

#nav li a{color:#333333;text-decoration:none}

#nav li a:hover{color:#006699;text-decoration:none}

#notification_li

{

position:relative

}

.a-arrow-border {

    top: -8px;

    margin-left: -88px;

    border-top: 0;

    border-bottom-color: rgba(0,0,0,.2);

}

.a-arrow {

    top: 1px;

    right: -8px;

    border-top: 0;

    border-bottom-color: #fff;

}

#notificationContainer 

{

    background-color: #fff;

    border: 1px solid rgba(100, 100, 100, .4);

    -webkit-box-shadow: 0 3px 8px rgba(0, 0, 0, .25);

    overflow: visible;

    position: absolute;

    top: 40px;

    margin-left: -317px;

    width: 400px;

    z-index: -1;

    display: none;

    border-radius: 15px; // Enable this after jquery implementation 

}

// Popup Arrow

#notificationContainer:before {

content: '';

display: block;

position: absolute;

width: 0;

height: 0;

color: transparent;

border: 10px solid black;

border-color: transparent transparent white;

margin-top: -20px;

margin-left: 188px;

}

#notificationTitle

{

    font-weight: bold;

    padding: 5px 15px;

    font-size: 13px;

    /* background-color: #ffffff; */

    /* position: fixed; */

    z-index: 1000;

    width: 100%;

    /* border-bottom: 1px solid #dddddd; */

    color: #23B0A5;

    text-transform: uppercase;

}

#notificationsBody

{

padding: 0px 0px 0px 0px !important;

min-height:300px;

}

#notificationFooter

{

text-align: center;

    font-weight: bold;

    padding: 8px;

    font-size: 12px;

    border-top: 1px solid #dddddd;

}

#notification_count 

{

padding: 3px 7px 3px 7px;

background: #cc0000;

color: #ffffff;

font-weight: bold;

margin-left: 77px;

border-radius: 9px;

-moz-border-radius: 9px; 

-webkit-border-radius: 9px;

position: absolute;

margin-top: -11px;

font-size: 11px;

}



</style>


<section class="header-admin">
  <div class="container container-width">
      <div class="row">
          <div class="col-md-6">
        <div class="navbar-header"> <a class="navbar-brand logo-wps" href="<?php echo base_url('superadmin/dashboard');?>"><div class="logo"><img src="<?php echo base_url()?>css/img/logo2.png"></div></a> </div>
          </div>
          <div class="col-md-6">
              <div class="admin-welcome-msg"><p> Welcome! Super Admin</p>
             <div class="admin-logout"><a class="btn btn-warning" href="<?php echo base_url('superadmin/logout');?>">logout</a></div>
              </div>
         <div class="notifications" style="display:none">
             <ul id="nav">

<li id="notification_li" >

<?php /*?><span id="notification_count">3</span><?php */?>

<a href="#" id="notificationLink"><i class="fa fa-bell"></i></a>

<div id="notificationContainer" style="display:none">

<div class="a-arrow-border" style="left: 127.5px;">

      <div class="a-arrow"></div>

    </div>

<div id="notificationTitle">Notifications</div>

<div id="notificationsBody" class="notifications"><ul>

<?php



foreach($notify as $key=>$notes) foreach($notes as $note)

{

{?>

<li class="<?php echo str_replace(' ','-',strtolower($key))?>"><?php echo $note?></li>	

<?php }}

?>

</ul>

</div>

<div id="notificationFooter"><a href="<?php echo base_url('superadmin/notifications');?>">See All</a></div>

</div>

</li>

</ul></div>

         </div>

      </div>

  </div>
    </section>







<section class="dashboard-main">

<div class="container dashboard-full-con">











