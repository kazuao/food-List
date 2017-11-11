<div class="container">

  <div id="menu-box" class="row menumenu" style="margin: 30px auto;">
    <div id="toggle"><a href="#">menu</a></div>
    <ul id="menu">
      <li><a href="<?= Uri::base().'user/'; ?>">マイページ</a></li>
      <li><a href="<?= Uri::base().'user/search'; ?>">登録店舗検索</a></li>
      <li><a href="<?= Uri::base().'user/register'; ?>">店舗登録</a></li>
      <li><a href="<?= Uri::base().'user/config'; ?>">設定</a></li>
    </ul>
  </div>

  <p><?= $message; ?></p>

</div>
