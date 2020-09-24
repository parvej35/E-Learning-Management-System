<!DOCTYPE html>
<html>
<head>
    <title>E-Learning</title>

    <meta http-equiv="content-type"   content="text/html; charset=UTF-8">
    <meta name="viewport"             content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

    <link rel="icon" href="<?php echo base_url();?>asset/image/icon.png">

    <link rel="stylesheet" href="<?php echo base_url('asset/css/fonts.google.css');?>" />

    <link rel="stylesheet" href="<?php echo base_url('asset/css/bootstrap.min.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('asset/css/datatables.min.css');?>" />

    <link rel="stylesheet" href="<?php echo base_url('asset/css/font-awesome.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('asset/css/style.css');?>" />

</head>
<body>

<div class="section" style="padding-top: 70px; min-height: 500px;">
	<div class="container">
		<div class="row" id="logindiv">	
			<div class="col-md-12">
				<div class="col-md-4 col-sm-12 col-xs-12">
		            <img src="<?php echo base_url().'asset/image/login.jpg';?>" class="img-responsive">
		        </div>		
				<div class="col-md-5 col-sm-12 col-xs-12 shadow-border" style="margin-bottom:15px;">
					<form id="login_form" method="post" class="padding-top-10">	
						<div class="col-md-12">
							<div class="section-title">
								<h4 class="title">Login</h4>
							</div>
						</div>	
						<div class="col-md-12">
							<div class="form-group">
								<p>Email <span style="color: red;">*</span></p>
								<input class="input" type="email" id="loginemail" name="loginemail" value="" placeholder="" required>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<p>Password <span style="color: red;">*</span></p>
								<input class="input" type="password" id="loginpassword" name="loginpassword" value="" placeholder="" required>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<span id="loginmessage"></span>
							<i id="loginloader" style="display: none;" class="fa fa-refresh fa-spin" style="font-size:24px"></i>
						</div>

						<div class="col-md-12 col-sm-12 col-xs-12 padding-top-25">
							<div class="form-group">
								<button type="button" class="btn btn-success" id="login_btn" onclick="submitLoginForm();" style="width: 100%;"> Login </button>
							</div>
						</div>						
						
					</form>	
				</div>

				<div class="col-md-offset-4 col-md-5 col-sm-12 col-xs-12" style="border: 1px solid green; background-color: #C8E5A7;">
					<p class="padding-top-10" style="padding-bottom:5px;text-align: center; font-size: 16px;color: black;">Not registered yet? <i class="fa fa-frown-o" style="color:red;font-size:20px"></i> &nbsp;&nbsp;<a href="#" class="signup" style="color: blue;"> <u>Signup now</u> </a></p>
				</div>
			</div>
		</div>

		<div class="row" id="signupdiv" style="display: none;">
			<div class="col-md-12">
				<div class="col-md-3 col-sm-12 col-xs-12">
		            <img src="<?php echo base_url().'asset/image/signup.png';?>" class="img-responsive">
		        </div>				
				<div class="col-md-7 col-sm-12 col-xs-12 shadow-border" style="background: white;padding-bottom:10px;margin-bottom:15px;">
					<form id="signup_form" method="post">	
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="section-title">
								<h4 class="title">Signup</h4>
							</div>
						</div>	
						<div class="col-md-6 col-sm-12 col-xs-12">
							<div class="form-group">
								<p>Full name <span style="color: red;">*</span></p>
								<input class="input" type="text" id="fullname" name="fullname" value="" minlength="5" maxlength="200" required>
							</div>
						</div>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<div class="form-group">
								<p>Email <sup style="color: red;">*</sup></p>
								<input class="input" type="email" id="signupemail" name="signupemail" minlength="5" maxlength="100" value="" required>
							</div>
						</div>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<div class="form-group">
								<p>Password <sup style="color: red;">*</sup></p>
								<input class="input" type="password" id="signuppassword" name="signuppassword" value="" minlength="6" maxlength="20" required>
							</div>
						</div>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<div class="form-group">
								<p>Confirm password <sup style="color: red;">*</sup></p>
								<input class="input" type="password" id="resignuppassword" name="resignuppassword" minlength="6" maxlength="20" value="" required>
							</div>
						</div>
						
						<div class="col-md-12 col-sm-12 col-xs-12">
							<p id="signupmessage"></p>
							<i id="signuploader" style="display: none;" class="fa fa-refresh fa-spin"></i>
						</div>

						<div class="col-md-6 col-sm-12 col-xs-12 padding-top-10">
							<div class="form-group">
								<button type="button" class="btn btn-danger" id="btn_reset" style="width:100%;" onclick="resetSignupForm();"> Reset </button>
							</div>
						</div>
						<div class="col-md-6 col-sm-12 col-xs-12 padding-top-10">
							<div class="form-group">
								<button type="button" class="btn btn-success" id="btn_signup" style="width:100%;" onclick="submitSignupForm();">Complete registration</button>
							</div>
						</div>
						
					</form>
				</div>

				<div class="col-md-offset-3 col-md-7 col-sm-12 col-xs-12" style="border: 1px solid green; background-color: #C8E5A7;">
					<p class="padding-top-10" style="padding-bottom:5px;text-align: center; font-size: 16px;color: black;">Already has an account? <i class="fa fa-smile-o" style="color:green;font-size:20px"></i> &nbsp;&nbsp;<a href="#" class="login" style="color: blue;"> <u>Login here</u> </a></p>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /section -->

<script src="<?php echo base_url('asset/js/jquery.min.js');?>"></script>
<script src="<?php echo base_url('asset/js/menu-scrollbar.min.js');?>"></script>
<script src="<?php echo base_url('asset/js/application.js');?>"></script>

</body>

</html>

<script type="text/javascript">
	$(document).ready(function(){
	    $('.signup').click(function(){
		    $("#logindiv").slideUp(500);
		    $("#signupdiv").slideDown(500);

		    $("#loginmessage").text("");
		    $("#signupmessage").text("");

		    $("#login_btn").attr("disabled", "disabled");
	    });

	    $('.login').click(function(){
		    $("#signupdiv").slideUp(500);
		    $("#logindiv").slideDown(500);

		    $("#loginmessage").text("");
		    $("#signupmessage").text("");

		    $("#login_btn").removeAttr("disabled");
	    });

	    $('.reset').click(function(){
		    $("#logindiv").slideUp(500);
		    $("#signupdiv").slideUp(500);
		    
		    $("#loginmessage").text("");
		    $("#signupmessage").text("");

		    $("#login_btn").attr("disabled", "disabled");
	    });

	    $("#signupdiv").hide();
		
		$("#loginemail").val("parvej@mail.com");
		$("#loginpassword").val("123456");

	    $(document).keypress(function (e) {
            if (e.which == 13) {
                submitLoginForm();
            }
        });

	});	


	function validateLoginForm(){
        var loginemail = $("#loginemail").val().trim();
        if(loginemail == null || loginemail == '' || loginemail.length <= 0){
            $("#loginemail").focus();
            $("#loginmessage").text("Enter email address");
            return false;
        }

        if(!validateEmail(loginemail)){
        	$("#loginemail").focus();
            $("#loginmessage").text("Invalid email address");
            return false;
        }

        var loginpassword = $("#loginpassword").val().trim();
        if(loginpassword == null || loginpassword == '' || loginpassword.length <= 0){
            $("#loginpassword").focus();
            $("#loginmessage").text("Enter password");
            return false;
        }

        return true;
    }

    function submitLoginForm(){
        $("#loginmessage").text("");
        $("#loginmessage").removeClass("success").addClass("error");  

        if(!validateLoginForm()){
            return false;
        } 

        $("#loginloader").show();
        $("#login_btn").attr('disabled', true);
        
        $.ajax({
            url: "<?php echo base_url('authentication/check_autho')?>",
            type: 'POST',
            data: $('#login_form').serialize(),
            success: function(data) {
                $("#login_btn").removeAttr("disabled");

                var data = jQuery.parseJSON(data);
                if(data.is_error == "false"){
                	$("#page-loader").show();
                    $("#loginmessage").removeClass("error").addClass("success");
                    $("#loginmessage").text(data.message);

                    window.location.href = "<?php echo base_url();?>dashboard";

                } else if(data.is_error == "true"){
                	$("#loginloader").hide();
                    $("#loginmessage").text(data.message);
                }
            },
            error: function(jqXHR, error, errorThrown) {  
                $("#login_btn").removeAttr("disabled");
                $("#resetmessage").text(errorThrown); 
                
                $("#modal_message").html(jqXHR.responseText);
                $('#error_modal').modal('show');
            }
        });        
    }

    function resetSignupForm(){
    	clear_form_values("#signup_form");
    }

    function validateSignupForm(){
    	var fullname = $("#fullname").val().trim();
        if(fullname == null || fullname == '' || fullname.length <= 0){
            $("#fullname").focus();
            $("#signupmessage").text("Write full name");
            return false;
        }

        var email = $("#signupemail").val().trim();
        if(email == null || email == '' || email.length <= 0){
            $("#signupemail").focus();
            $("#signupmessage").text("Enter email address");
            return false;
        }

        if(!validateEmail(email)){
        	$("#signupemail").focus();
            $("#signupmessage").text("Invalid email address");
            return false;
        }

        var password = $("#signuppassword").val().trim();
        if(password == null || password == '' || password.length <= 0){
            $("#signuppassword").focus();
            $("#signupmessage").text("Enter password");
            return false;
        }

        if(password.length < 5){
        	$("#signuppassword").focus();
            $("#signupmessage").text("Password length should be al least 5");
            return false;
        }

        var repassword = $("#resignuppassword").val().trim();
        if(repassword == null || repassword == '' || repassword.length <= 0){
            $("#resignuppassword").focus();
            $("#signupmessage").text("Re-enter password");
            return false;
        }

        if(password != repassword){
        	$("#signuppassword").focus();
            $("#signupmessage").text("Password does not match");
            return false;
        }

        return true;
    }

    function submitSignupForm(){
        $("#signupmessage").text("");
        $("#signupmessage").removeClass("success").addClass("error");  

        if(!validateSignupForm()){
            return false;
        }

        $("#signuploader").show();
        $("#btn_signup").attr('disabled', true);
        
        $.ajax({
            url: "<?php echo base_url('app_user/save')?>",
            type: 'POST',
            data: $('#signup_form').serialize(),
            success: function(data) {
            	$("#signuploader").hide();
            	$("#btn_signup").removeAttr("disabled");

                var data = jQuery.parseJSON(data);
                if(data.is_error == "false"){
                	clear_form_values("#login_form");
                	clear_form_values("#signup_form");

                    $("#signupdiv").slideUp(500);
				    $("#logindiv").slideDown(500);

				    $("#loginmessage").text("");
				    $("#signupmessage").text("");

				    $("#login_btn").removeAttr("disabled");

				    $("#loginmessage").text(data.message);
                    $("#loginmessage").removeClass("error").addClass("success");
                } else if(data.is_error == "true"){
                    $("#signupmessage").text(data.message);                    
                }
            },
            error: function(jqXHR, error, errorThrown) {  
                $("#btn_signup").removeAttr("disabled");
                $("#resetmessage").text(errorThrown); 
                
                $("#modal_message").html(jqXHR.responseText);
                $('#error_modal').modal('show');
            }
        });
    }
    
</script>