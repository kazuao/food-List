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

  <div class="row shop-page col-md-12">
    <div class="row col-md-12">
      <div class="s-l shop-img col-md-4 col-md-offset-2">
        <?= Html::img($shop_info->photo->pc->l, ['class' => 'shop-img']); ?>
      </div>
      <div class="row col-md-8 shop-data">
        <div class="s-l shop_name">
          <p><?= $shop_info->name; ?></p>
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
    <?= Form::open(['action' => 'user/saveshop', 'method' => 'post']); ?>
      <div class="row shop-value col-md-8 col-md-offset-2">
        <h4>今回評価評価</h4>
        <select class="form-control" name="star">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3" selected="selected">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </div>

      <div class="row col-md-8 col-md-offset-2">
        <div class="shop-value">
          <h4>来店日</h4>
          <input type="date" name="visit_date">
        </div>
        <div class="shop-value">
          <h4>利用金額</h4>
          <input type="text" name="total_price">円<br>
        </div>
        <div class="shop-value">
          <h4>利用人数</h4>
          <input type="number" name="num_guests">人<br>
        </div>
        <div class="shop-value">
          <h4>コメント</h4>
          <textarea name="comment" cols="90" rows="6"></textarea><br><br>
        </div>
        <div class="shop-value">
          <input type="submit" value="登録する" class="btn btn-primary"><br><br>
        </div>
        <input type="hidden" name="shop_id" value="<?= $shop_info->id; ?>">
      </div>
      <?= Form::close(); ?>
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
            	alert("Geocode was not successful for the following reason: " + status);
            }
    	});
    </script>
    <div id="google_map" style="width:100%;height:500px"></div>

  </div>
