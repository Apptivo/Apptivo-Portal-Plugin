<?php
/*
 * Login page
 */
require_once('config.php');
function login_form_code() {    
	
  $my_case_url=esc_url( get_permalink( get_page_by_title( 'My '.OBJECT_NAME_PLURAL ) ) );
 $open_ticket_url=esc_url( get_permalink( get_page_by_title( 'Opened '.OBJECT_NAME_PLURAL ) ) );
   ?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
<link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet' type='text/css'>

<script type="text/javascript" language="javascript">
$ = jQuery;
$(document).ready(function () {
    $("#sign_in").validate(
    {
        rules: {
            login_email: {required: true,email: true},
            login_password: {required: true}
        },
        messages: {
            login_email: "Please enter your email address",
            login_password: "Please enter valid password"
        },
               
        submitHandler: function(form) { 
            var user_name=$('#login_email').val(); 
            var password=$('#login_password').val();
            $('#loadimage').show();
            $.ajax(
            {
                type: 'POST',
                url : '<?php echo admin_url('admin-ajax.php'); ?>',
                data: {'action':'cases_login',"user_name":user_name,"password":password},
                success: function(data)
                {                        
                    if(data == 100){
                        window.location.href = '<?php echo $my_case_url; ?>';
                    }
                    else{
                        $("#loginmessage").html("<span style='color:red'>Username/ password is invalid</span>");
                        $('#loadimage').hide();
                    }
                }
            });
        }
    });
});
</script>
   
   <style>
    body{background:#4b5058;  font-family: 'Nunito', sans-serif;}

.card-container.card {
  max-width: 240px;
  padding: 40px 40px;  
  margin: 0 auto;
  margin-top: 150px;
}
input, .btn, button, textarea, select{outline:none !improtant;  font-size: 14px;
  color: #333;}
.profile-name-card {
  font-size: 16px;
  font-weight: bold;
  text-align: center;
  margin: 10px 0 0;
  min-height: 1em;
}
.form-control:focus {
  border-color: #2fade7;
  outline: 0;
  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102,175,233,.6);
  box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102,175,233,.6);
}
.reauth-email {
  display: block;
  color: #404040;
  line-height: 2;
  margin-bottom: 10px;
  font-size: 14px !important;
  text-align: center;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}
.btn.btn-signin {
  background-color: #2fade7;
  padding: 0px;
  font-weight: 700;
  font-size: 14px;
  height: 36px;
  -moz-border-radius: 3px;
  -webkit-border-radius: 3px;
  border-radius: 3px;
  border: none;
  -o-transition: all 0.218s;
  -moz-transition: all 0.218s;
  -webkit-transition: all 0.218s;
  transition: all 0.218s;
  color:#fff;
}
.card {
  background-color: #F7F7F7;
  padding: 20px 25px 30px;
  margin: 0 auto 25px;
  margin-top: 150px;
  -moz-border-radius: 2px;
  -webkit-border-radius: 2px;
  border-radius: 2px;
  -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
  -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
  box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
}
.form-signin input[type=email], .form-signin input[type=password], .form-signin input[type=text], .form-signin button {
  width: 100%;
  display: block;
  margin-bottom: 10px;
  z-index: 1;
  position: relative;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}
.form-control {
  display: block;
  width: 100%;
  height: 34px;
  padding: 5px 10px;
  font-size: 14px;
  line-height: 1.42857143;
  color: #555;
  background-color: #fff;
  background-image: none;
  border: 1px solid #ccc;
  border-radius: 0px;
  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
  box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
  -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
  -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
}
a.btn-signin {
  line-height: 36px;
  cursor: pointer;
}
.btn.btn-signin:hover, .btn.btn-signin:active, .btn.btn-signin:focus {
  background-color: #2fade7;
}
.card-container a:hover {
  text-decoration: none !important;
}
.signin_frm input {width:100% !important}
label.error {font-size: 12px;font-weight: normal;color: red;}    
</style>



<div class="container">
        <div class="card card-container">
        <div class="text-center">
           <center><img id="profile-img" src="<?php echo SITEURL;?>/wp-content/themes/apptivoportal/images/apptivo-logo1.png" alt="logo"></center>
           </div>
            <p id="profile-name" class="profile-name-card"></p>
           <form id="sign_in" action="" method="post" name="sign_in" class="form-signin">
                                <div id="loginmain1">
                                    <div class="signin_frm">
                                        <div class="signin_input" id=""> 
                                            <span id="loginmessage" class="validationerror"> </span>
                                        </div>
                                        <input type="text" placeholder="Email address" name="login_email" title="Email" id="login_email" tabindex="2" class="form-control"/>
                                        <input type="password" placeholder="Password" name="login_password" title="Password" id="login_password" tabindex="3" class="form-control"/>
                                        <div class="logindiv">
                                            <p class="lead"><span style="display:none;" id="loadimage"><img src="https://apptivoapp.cachefly.net/site/v1.0.5/images/aloading.gif" style="padding:6px 10px 10px;"></span>
                                                <button type="submit" class="btn btn-primary btn-signin" id="login" name="login">Login</button></p>
                                        </div>
                                    </div>
                                </div>                                
                            </form>
           
        </div><!-- /card-container -->
    </div>

    
  
   
    
<?php 
    }
?>