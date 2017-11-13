<div class="container">

  <?= '<div class="alert-error">'.Session::get_flash('success').'</div>'?>
  <?= '<div class="alert-error">'.Session::get_flash('error').'</div>'?>

  <div class="omb_login" disabled="">
  	<h3 class="omb_authTitle">Login<a href="<?= Uri::base()."top/signup" ?>"> or Sign up</a></h3>
	  <div class="row omb_row-sm-offset-3 omb_socialButtons">

      <div class="col-xs-4 col-sm-2">
        <a href="#" class="btn btn-lg btn-block omb_btn-facebook" disabled="">
	        <i class="fa fa-facebook visible-xs visible-sm"></i>
	        <span class="hidden-xs hidden-sm">Facebook</span>
        </a>
      </div>

    	<div class="col-xs-4 col-sm-2">
        <a href="#" class="btn btn-lg btn-block omb_btn-twitter" disabled="">
	        <i class="fa fa-twitter visible-xs visible-sm"></i>
	        <span class="hidden-xs hidden-sm">Twitter</span>
        </a>
      </div>

    	<div class="col-xs-4 col-sm-2">
        <a href="auth/oauth/google" class="btn btn-lg btn-block omb_btn-google" disabled="">
	        <i class="fa fa-google-plus visible-xs visible-sm"></i>
          <span class="hidden-xs hidden-sm">Google+</span>
        </a>
      </div>

	  </div>

  	<div class="row omb_row-sm-offset-3 omb_loginOr">
  		<div class="col-xs-12 col-sm-6">
  			<hr class="omb_hrOr">
  			<span class="omb_spanOr">or</span>
  		</div>
  	</div>

  	<div class="row omb_row-sm-offset-3">
  		<div class="col-xs-12 col-sm-6">
  		  <form class="omb_loginForm" action="" method="POST">
    			<div class="input-group">
    				<span class="input-group-addon"><i class="fa fa-user"></i></span>
    				<input type="text" class="form-control" name="username" placeholder="email adress">
    			</div>
    			<span class="help-block"></span>

  				<div class="input-group">
    				<span class="input-group-addon"><i class="fa fa-lock"></i></span>
    				<input  type="password" class="form-control" name="password" placeholder="Password">
    			</div>

    			<button class="btn btn-lg btn-primary btn-block login-btn" type="submit">Login</button>
  			</form>

  		</div>
  	</div>
  	<div class="row omb_row-sm-offset-3 col-xs-12">
  		<div class="col-xs-12 col-sm-3">
  			<label class="checkbox sm-os-class">
  				<input type="checkbox" value="remember">Remember Me
  			</label>
  		</div>
  		<div class="col-xs-12 col-sm-3">
  			<p class="omb_forgotPwd">
  				<a href="<?= Uri::base().'top/fogetPassword'; ?>">Forgot password?</a>
  			</p>
  		</div>
  	</div>
	</div>
</div>
