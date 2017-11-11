<div class="header">

  <div class="header-logo">
    <a href="<?= URI::base().""; ?>"><?= Html::img('public/assets/img/logo.png'); ?></a>
  </div>

  <div class="btn btn-link header-right">
    <?php if(!Auth::check()): ?>
      <?= Html::anchor('top/login', "Login") ?>
    <?php else: ?>
      <?= Html::anchor('user/logout', "Logout") ?>
    <?php endif; ?>
  </div>

</div>
