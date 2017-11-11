<!-- Where all the magic happens -->
<!-- LOGIN FORM -->
<div class="container">

<div class="text-center col-md-4 col-sm-12 col-xs-12" style="padding:50px 0">
	<div class="logo">ログイン</div>
	<div class="login-form-1">
		<form id="login-form" class="text-left" method="post">
			<div class="login-form-main-message"></div>
			<div class="main-login-form">
				<div class="login-group">
					<div class="form-group">
						<label for="username" class="sr-only">ユーザ名</label>
						<input type="text" class="form-control" id="username" name="username" placeholder="ユーザ名">
					</div>
					<div class="form-group">
						<label for="password" class="sr-only">パスワード</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="パスワード">
					</div>
					<div class="form-group login-group-checkbox">
						<input type="checkbox" id="lg_remember" name="lg_remember">
						<label for="lg_remember">保存する？</label>
					</div>
				</div>
				<button type="submit" class="login-button"><i class="fa fa-chevron-right"></i></button>
			</div>
		</form>
	</div>
</div>

<!-- REGISTRATION FORM -->
<div class="text-center col-md-4 col-sm-12 col-xs-12" style="padding:50px 0">
	<div class="logo">新規登録</div>
	<div class="login-form-1">
		<form id="register-form" class="text-left" method="post">
			<div class="login-form-main-message"></div>
			<div class="main-login-form">
				<div class="login-group">
					<div class="form-group">
						<label for="username" class="sr-only">Email address</label>
						<input type="text" class="form-control" id="username" name="username" placeholder="ユーザ名">
					</div>
					<div class="form-group">
						<label for="reg_email" class="sr-only">Email</label>
						<input type="text" class="form-control" id="reg_email" name="reg_email" placeholder="メールアドレス">
					</div>
					<div class="form-group">
						<label for="password" class="sr-only">Password</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="パスワード">
					</div>
				</div>
				<button type="submit" class="login-button"><i class="fa fa-chevron-right"></i></button>
			</div>
		</form>
	</div>
</div>

<!-- FORGOT PASSWORD FORM -->
<div class="text-center col-md-4 col-sm-12 col-xs-12" style="padding:50px 0">
	<div class="logo">パースワード忘れた?</div>
	<div class="login-form-1">
		<form id="forgot-password-form" class="text-left">
			<div class="etc-login-form">
				<p>登録したメールアドレスを入力してください。</p>
			</div>
			<div class="login-form-main-message"></div>
			<div class="main-login-form">
				<div class="login-group">
					<div class="form-group">
						<label for="fp_email" class="sr-only">Email address</label>
						<input type="text" class="form-control" id="fp_email" name="fp_email" placeholder="メールアドレス">
					</div>
				</div>
				<button type="submit" class="login-button"><i class="fa fa-chevron-right"></i></button>
			</div>
		</form>
	</div>
</div>

</div>
