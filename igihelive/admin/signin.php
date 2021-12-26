<?php 
	$page = 'Sign In';
?>
<!doctype html>
<html lang="">
  <?php  require('head.php'); ?>
  <body>

    <div class="app-signin">
      <div class="container">
        <div class="session">
          <div class="session-content">
            <div class="card card-block form-layout">
              <form role="form" action="." id="validate">
                <div class="text-xs-center m-b-3 text-center">
                  <img src="images/logo2.png" height="80" alt="" class="m-b-1 img-responsive"/>
                  <h5>
                   <?php if(isset($_GET['l'])) {echo 'See you soon!';}else{echo 'Welcome back!';} ?>
                  </h5>
                  <p class="text-muted">
                    Live Sport System
                  </p>
                </div>
                <fieldset class="form-group">
                  <label for="username">
                    Enter your username
                  </label>
                  <input type="text" class="form-control form-control-lg" id="username" placeholder="username" required/>
                </fieldset>
                <fieldset class="form-group">
                  <label for="password">
                    Enter your password
                  </label>
                  <input type="password" class="form-control form-control-lg" id="password" placeholder="********" required/>
                </fieldset>
                <label class="c-input m-b-1">
                  <span class="err_msg"><?php if(isset($failed)){echo 'Login and Password Incorrect';}?></span>
                </label>
				
                <button class="btn btn-primary btn-block commit"  type="submit">
                  Login
                </button>
				 
                <div class="divider">
                  <span>
                    <a href="extra-forgot.php"> Forgot password? </a> 
                  </span>
                </div>
               
              </form>
            </div>
          </div> 
        </div>

      </div>
    </div>

    <?php  require('footer_js.php'); ?>
    
  </body>
</html>
