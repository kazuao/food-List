<div class="container">

  <div id="menu-box" class="row" style="margin: 30px auto;">
    <div id="toggle"><a href="#">menu</a></div>
    <ul id="menu">
      <li><a href="<?= Uri::base().'user/'; ?>">マイページ</a></li>
      <li class="active"><a href="<?= Uri::base().'user/search'; ?>">登録店舗検索</a></li>
      <li><a href="<?= Uri::base().'user/register'; ?>">店舗登録</a></li>
      <li><a href="<?= Uri::base().'user/config'; ?>">設定</a></li>
    </ul>
  </div>

  <div class="row selected-search col-md-12">

    <div class="city-search col-md-2 col-md-offset-4">
      <div class="dropdown">
        <?= Form::open(['action' => 'user/pulltown','method' => 'post']) ?>
          <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
            市区町村検索
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <?php foreach ($town_data as $value): ?>
              <li>
                <a href="<?= Uri::base().'user/pulltown?town_name='.$value; ?>"><?= $value ?></a>
              </li>
            <?php endforeach; ?>
          </ul>
        <?= Form::close(); ?>
      </div>
    </div>

    <div class="genre-search col-md-2">
      <div class="dropdown">
        <?= Form::open(['action' => 'user/pullgenre','method' => 'post']) ?>
          <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-expanded="true">
            ジャンル検索
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
            <?php foreach ($genre_data as $value): ?>
              <li>
                <a href="<?= Uri::base().'user/pullgenre?genre='.$value; ?>"><?= $value ?></a>
              </li>
            <?php endforeach; ?>
          </ul>
        <?= Form::close(); ?>
      </div>
    </div>

  </div>

  <?php echo '<div class="alert-error">'.Session::get_flash('error').'</div>'?>

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

</div>
