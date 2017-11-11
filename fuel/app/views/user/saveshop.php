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

  <?= '<div class="alert-error btn btn-success">'.Session::get_flash('success').'</div>'?>



  <div class="row shop-page col-md-12">

    <div class="row shop-page col-md-12">
      <div class="row s-l shop-img col-md-4 col-md-offset-2">
        <?= Html::img($shop_info['shop_pic'], ['class' => 'shop-img']); ?>
      </div>
      <div class="row s-l shop_name col-md-4">
        <p><?= $shop_info['shop_name'] ?></p>
      </div>
      <div class="row s-l shop_url col-md-4">
        <a href="<?= $shop_info['shop_url'] ?>">ホットペッパーグルメへ</a>
      </div>
      <div class="row s-l shop_address col-md-4">
        <p>住所：<?= $shop_info['shop_address'] ?><p>
      </div>
      <div class="row s-l shop_open col-md-4">
        <p>営業時間：<?= $shop_info['shop_open'] ?><p>
      </div>
      <div class="row s-l shop_station col-md-4">
        <p>最寄駅：<?= $shop_info['shop_access'] ?><p>
      </div>
    </div>

      <div class="row shop-value col-md-8 col-md-offset-2">
        <h4>今回評価:  <?= $shop_info['star'] ?></h4>
      </div><br>
      <div class="row visit_date col-md-8 col-md-offset-2">
        <h4>来店日:  <?= $shop_info['visit_date'] ?></h4>
      </div>
      <div class="row shop-value col-md-8 col-md-offset-2">
        <h4>利用金額:  <?= $shop_info['payment'] ?>円</h4>
      </div>
      <div class="row shop-value col-md-8 col-md-offset-2">
        <h4>前回利用人数:  <?= $shop_info['num_guests'] ?>人</h4>
      </div>
      <div class="row shop-value col-md-8 col-md-offset-2">
        <h4>コメント</h4><?= htmlspecialchars_decode($shop_info['comment']) ?>
      </div>
  </div>

  <!-- google maps -->
  <script src="//maps.googleapis.com/maps/api/js?key=<?= $apiKey ?>" type="text/javascript"></script>
  <script type="text/javascript">
  	//COMTOPIA流Google MAP表示方法
  	var geocoder = new google.maps.Geocoder();//Geocode APIを使います。
  	var address = "<?= $shop_info['shop_address'] ?>";
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

  </div>
