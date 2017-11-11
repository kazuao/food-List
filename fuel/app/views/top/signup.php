<div class="container">
  <?php if(! empty($message)){echo $message;} ?>

<?php echo '<div class="alert-error">'.Session::get_flash('error').'</div>'?>

  <div class="omb_login">
  	<h3 class="omb_authTitle"><a href="<?= URI::base()."top/login"; ?>">Login or </a>Sign up</h3>
		<div class="row omb_row-sm-offset-3">
			<div class="col-xs-12 col-sm-6">
			  <form class="omb_loginForm" action="" method="POST">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-user"></i></span>
					<input type="text" class="form-control" name="username" placeholder="username">
				</div>
				<span class="help-block"></span>

					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
						<input type="text" class="form-control" name="email" placeholder="email address">
					</div>
					<span class="help-block"></span>

					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock"></i></span>
						<input  type="password" class="form-control" name="password" placeholder="Password">
					</div>

					<button class="btn btn-lg btn-success btn-block login-btn" type="submit">アカウントを作成する</button>

				</form>
			</div>
    </div>
	</div>

</div>
