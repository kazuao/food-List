<div class="container">

  <div id="menu-box" class="row" style="margin: 30px auto;">
    <div id="toggle"><a href="#">menu</a></div>
    <ul id="menu">
      <li><a href="<?= Uri::base().'user/'; ?>">マイページ</a></li>
      <li><a href="<?= Uri::base().'user/search'; ?>">登録店舗検索</a></li>
      <li><a href="<?= Uri::base().'user/register'; ?>">店舗登録</a></li>
      <li class="active"><a href="<?= Uri::base().'user/config'; ?>">設定</a></li>
    </ul>
  </div>

  <div class="row col-md-12">
    <?php if( ! empty($id_message)){echo $id_message;} ?>
    <div class="config-title col-md-3 col-md-offset-3">
      <label>ユーザ名変更</label>
    </div>
    <div class="config-body col-md-4">
      <p>/* <?= $username['username']; ?> */</p>
      <p>↓</p>
      <?= Form::open(['action' => 'user/changeUsername', 'method' => 'post']); ?>
        <input type="text" name="change_username">
        <input type="submit" value="変更" name="change-username" class="btn btn-primary">
      <?= Form::close(); ?>
    </div>
  </div>

  <hr class="row col-md-12">

  <div class="row col-md-12">
    <div class="config-title col-md-3 col-md-offset-3">
      <?php if( ! empty($pass_message)){echo $pass_message;} ?>
      <label>パスワード変更</label>
    </div>
    <div class="config-body col-md-4">
      <?= Form::open(['action' => 'user/changePass', 'method' => 'post']) ?>
        <p>現在のパスワード</p><input type="password" name="change_pass1">
        <p>新しいパスワード</p><input type="password" name="change_pass2">
        <p>もう一度入力してください</p><input type="password" name="change_pass3">
        <input type="submit" value="変更" name="change-pass" class="btn btn-primary">
      <?= Form::close() ?>
    </div>
  </div>

  <hr class="row col-md-12">

    <div class="row col-md-12">
      <div class="config-title col-md-3 col-md-offset-3">
        <?php if( ! empty($unsub_message)){echo $unsub_message;} ?>
        <label>退会</label>
      </div>
      <div class="config-body col-md-4">
        <?= Form::open(['action' => 'user/deleteUser', 'method' => 'post']) ?>
          <p>ユーザネームを入力してください</p><input type="text" name="unsub_username">
          <input type="submit" value="退会" name="unsub" class="btn btn-default">
        <?= Form::close(); ?>
      </div>
    </div>

</div>
