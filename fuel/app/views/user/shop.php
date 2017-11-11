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


  <div class="shop-page">

    <div class="row col-md-12">
      <div class="s-l shop-img col-md-4 col-md-offset-2">
        <?= Html::img($shop_info->photo->pc->l, ['class' => 'shop-img']); ?>
      </div>
      <div class="row col-md-8 shop-data">
        <div class="s-l shop_name">
          <p><?= $shop_data['shop_name']; ?></p>
        </div>
        <div class="s-l shop_url">
          <a href="<?= $shop_info->urls->pc ?>">ホットペッパーグルメへ</a>
        </div>
        <div class="s-l shop_address">
          <p>住所：<?= $shop_info->address ?><p>
        </div>
        <div class="s-l shop_open">
          <p>営業時間：<?= $shop_info->open ?><p>
        </div>
        <div class="s-l shop_station">
          <p>最寄駅：<?= $shop_info->access ?><p>
        </div>
      </div>
    </div>

    <div class="row col-md-12">
      <div class="border">
        <div class="shop-value">
          <h4>来店日：  <?= $shop_data['visit_date'] ?></h4>
        </div>
        <div class="shop-value">
          <h4>前回評価：  <?= $shop_data['star'] ?></h4>
        </div>
        <div class="shop-value">
          <h4>利用金額：  ￥<?= $shop_data['payment'] ?>-</h4>
        </div>
        <div class="shop-value">
          <h4>前回利用人数：  <?= $shop_data['num_guests'] ?>名</h4>
        </div>
        <div class="shop-value">
          <h4>前回コメント</h4>
          <p><?= htmlspecialchars_decode($shop_data['comment']) ?></p>
        </div>
      </div>
    </div>

  </div>

  <!-- google maps -->
  <script src="//maps.googleapis.com/maps/api/js?key=<?= $apiKey ?>" type="text/javascript"></script>
  <script type="text/javascript">
  	//COMTOPIA流Google MAP表示方法
  	var geocoder = new google.maps.Geocoder();//Geocode APIを使います。
  	var address = "<?= $shop_info->address ?>";
  	geocoder.geocode({'address': address,'language':'ja'},function(results, status){
  		if (status == google.maps.GeocoderStatus.OK){
  			var latlng=results[0].geometry.location;//緯度と経度を取得
  			var mapOpt = {
            		center: latlng,//取得した緯度経度を地図の真ん中に設定
            		zoom: 15,//地図倍率1～20
            		mapTypeId: google.maps.MapTypeId.ROADMAP//普通の道路マップ
          	};
  			var map = new google.maps.Map(document.getElementById('google_map'),mapOpt);
  			var marker = new google.maps.Marker({//住所のポイントにマーカーを立てる
  				position: map.getCenter(),
  				map: map
  			});
  		}else{
          	alert("地図を取得できませんでした:" + status);
          }
  	});
  </script>
  <div id="google_map" style="width:100%;height:500px"></div>

  <div class="row config-btn">
    <div class="btn btn-primary" style="margin-right: 30px;" disabled="">
      <a href="#" disables="">追加する</a>
    </div>
    <div class="btn btn-success" style="margin-right: 30px;" disabled="">
      <a href="#" disables="">編集する</a>
    </div>
    <div class="btn btn-danger" style="margin-right: 30px;">
      <a href="<?= Uri::base().'user/shopdelete?id='.$shop_data['shop_id']; ?>">削除する</a>
    </div>
  </div>

</div>
