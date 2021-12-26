<?php 
	$page = 'Sign In';
?>
<!doctype html>
<html lang="">
  <?php  require('head.php'); ?>
  <body>

    <div class="app no-padding no-footer layout-static">
      <div class="session-panel">
        <div class="session">
          <div class="session-content">
            <div class="card card-block form-layout">
              <form role="form" action="extra-signin.html" id="validate">
                <div class="text-xs-left m-b-3">
                  <img src="images/logo.jpg" height="80" alt="" class="m-b-1"/>
                  <h5>
                    Reset password
                  </h5>
                  <p class="text-muted">
                    Enter your email and we'll send you instructions on how to reset your password.
                  </p>
                </div>
                <fieldset class="form-group">
                  <label for="password">
                    Your email address
                  </label>
                  <input type="email" class="form-control form-control-lg" id="password" placeholder="email address" autofocus required/>
                </fieldset>
                <button class="btn btn-primary btn-block btn-lg" type="submit">
                  Reset password
                </button>
				 
                <div class="divider">
                  <span>
                    <a href="signin.php"> Log in </a> 
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
