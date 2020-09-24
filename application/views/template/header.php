<!DOCTYPE html>
<html>
<head>
    <?php 
        if(!isset($_SESSION)) { 
            session_start(); 
        } 

        $session_user_id = @$_SESSION["session_user_id"];
        $session_user_name = @$_SESSION["session_user_name"];   
        $session_user_is_admin = @$_SESSION["session_user_is_admin"];
    ?>
    <title>E-Learning</title>

    <meta http-equiv="content-type"   content="text/html; charset=UTF-8">
    <meta name="viewport"             content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

    <link rel="icon" href="<?php echo base_url();?>asset/image/icon.png">

    <link rel="stylesheet" href="<?php echo base_url('asset/css/fonts.google.css');?>" />

    <link rel="stylesheet" href="<?php echo base_url('asset/css/bootstrap.min.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('asset/css/datatables.min.css');?>" />

    <link rel="stylesheet" href="<?php echo base_url('asset/css/font-awesome.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('asset/css/style.css');?>" />

    <link rel="stylesheet" href="<?php echo base_url('asset/css/menu.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('asset/css/menu-scrollbar.min.css');?>" />

    <link rel="stylesheet" href="<?php echo base_url('asset/css/footer.css');?>" />
    
    <style>
      @font-face {
        font-family: 'SolaimanLipi';
        src: url('SolaimanLipi.eot');
        src: url('SolaimanLipi.woff') format('woff'),
             url('SolaimanLipi.ttf') format('truetype'),
             url('SolaimanLipi.svg#SolaimanLipiNormal') format('svg'),
             url('SolaimanLipi.eot?#iefix') format('embedded-opentype');
        font-weight: normal;
        font-style: normal;
      }
    </style>
</head>
<body>

<div class="overlay"></div>

<header>
  <div id="top-header">
    <div class="container">
      
      <div class="pull-left">
        <ul>
          <li>
            <a href="#" style="font-size: 20px;color: crimson;font-weight: bold;">E-Learning Management System</a>
          </li>
        </ul>
      </div>

      <?php  if(isset($session_user_id) && $session_user_id != '') { ?>
        
      <div class="pull-right">
        <ul class="header-top-links">
          <li class="temp">
            <a href="<?php echo base_url();?>dashboard">Home</a>
          </li>

          <li class="temp"> &nbsp;&nbsp;|&nbsp;&nbsp;</li>          

          <li class="temp">
            <a href="<?php echo base_url();?>study">Study </a>
          </li>

          <li class="temp"> &nbsp;&nbsp;|&nbsp;&nbsp;</li> 

          <li class="temp">
            <a href="<?php echo base_url();?>model_test">Model Test</a>
          </li>

          <li class="temp"> &nbsp;&nbsp;|&nbsp;&nbsp;</li>

          <li class="dropdown default-dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                <?php echo $session_user_name; ?>
                <i class="fa fa-caret-down"></i>
            </a>
            <ul class="custom-menu">
              <?php 
                if(isset($session_user_is_admin) && $session_user_is_admin == 1) { 
              ?>
              <li>
                <a href="<?php echo base_url();?>course">
                  <i class="fa fa-address-card-o"></i> Course
                </a>
              </li>            

              <li class="temp">
                <a href="<?php echo base_url();?>lesson">
                  <i class="fa fa-arrow-circle-o-right"></i> Lesson
                </a>
              </li>
              
              <li class="temp">
                <a href="<?php echo base_url();?>questionnaire">
                  <i class="fa fa-list"></i> Questionnaire
                </a>
              </li>

              <li class="temp">
                <a href="<?php echo base_url();?>app_user/list">
                  <i class="fa fa-group"></i> Show Users
                </a>
              </li>
              <?php } ?>

              <li>
                <a href="<?php echo base_url();?>authentication/logout">
                  <i class="fa fa-sign-out"></i> Logout
                </a>
              </li>
            </ul>
            
          </li>
        </ul>
      </div>

      <?php } ?>
      
    </div>
  </div>

  <div id="header">
    <div class="container">
      <div class="row">
        
      </div>
    </div>
  </div>
</header>