<div class="container">

  <?= '<div class="alert-error">'.Session::get_flash('success').'</div>'?>

  <div class="row omb_row-sm-offset-3 fogetpass">
    <div class="col-xs-12 col-sm-6">
      <h4>メールアドレスを入力してください。</h4>
      <span class="help-block"></span>
      <form class="fogetPassword" action="top/fogetPassword" method="POST">
        <div class="input-group">
          <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
          <input type="text" class="form-control" name="email" placeholder="email address">
        </div>
        <span class="help-block"></span>

        <button class="btn btn-lg btn-primary btn-block" type="submit" disabled="">パスワードを取得する</button>
      </form>
     </div>
  </div>

</div>
