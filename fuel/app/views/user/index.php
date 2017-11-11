<div class="container">

  <div id="menu-box" class="row" style="margin: 30px auto;">
    <div id="toggle"><a href="#">menu</a></div>
    <ul id="menu">
      <li class="active"><a href="<?= Uri::base().'user/'; ?>">マイページ</a></li>
      <li><a href="<?= Uri::base().'user/search'; ?>">登録店舗検索</a></li>
      <li><a href="<?= Uri::base().'user/register'; ?>">店舗登録</a></li>
      <li><a href="<?= Uri::base().'user/config'; ?>">設定</a></li>
    </ul>
  </div>

  <?php if( ! empty($json)): ?>
    <?php foreach($json as $value): ?>
      <?php foreach($value->results->shop as $shop_info): ?>
        <div class="row shop-page">
          <a href="<?= Uri::base().'user/shop?id='.$shop_info->id; ?>">
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
    <?php endforeach; ?>
  <?php endif; ?>

  <!-- pagenation　まだ未実装 -->
  <div class="row col-md-12">
    <nav>
    	<ul class="pager">
    		<li><a href="#" disabled="">前へ</a></li>
    		<li><a href="#" disabled="">次へ</a></li>
    	</ul>
    </nav>
  </div>

</div>
