<?= Asset::js('menu.js'); ?>

<div class="container">

  <div id="menu-box" class="row" style="margin: 30px auto;">
    <div id="toggle"><a href="#">menu</a></div>
    <ul id="menu">
      <li><a href="<?= Uri::base().'user/'; ?>">マイページ</a></li>
      <li><a href="<?= Uri::base().'user/search'; ?>">登録店舗検索</a></li>
      <li><a href="<?= Uri::base().'user/register'; ?>">店舗登録</a></li>
      <li><a href="<?= Uri::base().'user/config'; ?>">設定</a></li>
    </ul>
  </div>

  <div class="row shop-page col-md-12">
    <div class="row shop-name col-md-12">
      <h2>店舗名</h2>
    </div>
    <div class="row shop-img col-md-4 col-md-offset-2">
      <?= Html::img('assets/img/stake.jpg', ['class' => 'shop-img']); ?>
    </div>
    <div class="row shop-data col-md-4">
      <div class="row shop-tel col-md-12">
        <h4>TEL</h4>
      </div>
      <div class="row col-md-12">
        <h4>住所</h4>
      </div>
      <div class="row col-md-12">
        <h4>営業時間</h4>
      </div>
    </div>
    <div class="row shop-value col-md-8 col-md-offset-2">
      <h4>前回来店日</h4><br>
      <h4>前回評価</h4><br>
      <h4>前回金額</h4><br>
      <h4>前回利用人数</h4><br>
      <h4>前回利用単価</h4><br>
      <h4>前回コメント</h4><br>
    </div>

    <div class="shop-map col-md-8 col-md-offset-2">
      <iframe width="600" height="450" frameborder="0" style="border:0"
      src="https://www.google.com/maps/embed/v1/place?q=place_id:ChIJy-LHFO-LGGARkXOtNNVUYG8&key=AIzaSyDpPv0oF9I4sUNG96By17JSENpWM_QgjOo"
      allowfullscreen></iframe>
    </div>
    <br>


    <div class="config-btn row col-md-8 col-md-offset-2 text-center">
      <div class="btn btn-primary" style="margin-right: 30px;">
        <a href="#">追加する</a>
      </div>
      <div class="btn btn-success" style="margin-right: 30px;">
        <a href="#">編集する</a>
      </div>
      <div class="btn btn-warning" style="margin-right: 30px;">
        <a href="#">駆除する</a>
      </div>
    </div>

    <div></div>

    <script type="text/javascript">
    $('div').raty({ score: 3 });
    </script>

  </div>
