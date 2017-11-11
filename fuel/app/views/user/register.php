<div class="container">

  <div id="menu-box" class="row" style="margin: 30px auto;">
    <div id="toggle"><a href="#">menu</a></div>
    <ul id="menu">
      <li><a href="<?= Uri::base().'user/'; ?>">マイページ</a></li>
      <li><a href="<?= Uri::base().'user/search'; ?>">登録店舗検索</a></li>
      <li class="active"><a href="<?= Uri::base().'user/register'; ?>">店舗登録</a></li>
      <li><a href="<?= Uri::base().'user/config'; ?>">設定</a></li>
    </ul>
  </div>

  <div class="search-box col-md-12">
    <?= Form::open(['action' => 'user/shopsearch','method' => 'post']); ?>
      <div class="name-search text-center">
        <label>店舗名検索: </label>
        <input type="text" name="name-search" value="">
        <input type="submit" value="探す" name="submit_search" class="btn btn-primary">
      </div>
    <?= Form::close(); ?>
  </div>

  <?= '<div class="alert-error">'.Session::get_flash('error').'</div>'?>

  <?php if(isset($json)): ?>
    <?php foreach($json->results->shop as $shop_info): ?>
      <div class="row shop-page">
        <a href="<?= Uri::base().'user/shopregi?id='.$shop_info->id; ?>">
          <div class="s-l shop-img col-md-4 col-md-offset-2">
            <?= Html::img($shop_info->photo->pc->l, ['class' => 'shop-img']); ?>
          </div>
          <div class="col-md-6">
            <div class="s-l shop-name">
              <p><?= $shop_info->name ?></p>
            </div>
            <div class="s-l shop_address">
              <p>住所：<?= $shop_info->address ?><p>
            </div>
            <div class="s-l shop_open">
              <p>営業時間：<?= $shop_info->open ?><p>
            </div>
          </div>
        </a>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>

</div>
