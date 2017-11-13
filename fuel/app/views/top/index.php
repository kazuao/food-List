<div class="container">
  <?= '<div class="alert-error">'.Session::get_flash('error').'</div>'?>

  <div class="main-logo text-center">
    <?= Html::img('assets/img/logo.png'); ?>
  </div>

  <h2>世界にひとつだけ、自分だけのレストランリスト。</h2>

  <div class="main-singup btn btn-default center-block">
    <?= Html::anchor('top/signup', "無料でサインアップ") ?>
  </div>

  <div class="to-mypage btn btn-default center-block">
    <?= Html::anchor('user/', "マイページへ") ?>
  </div>

  <!-- 任意のID指定。クラスとデータ属性の指定。 -->
  <div id="carousel-example" class="carousel slide" data-ride="carousel">
    <!-- インジケーターの設置。下部の○●ボタン。 -->
    <ol class="carousel-indicators">
      <li data-target="#carousel-example" data-slide-to="0" class="active"></li>
      <li data-target="#carousel-example" data-slide-to="1"></li>
      <li data-target="#carousel-example" data-slide-to="2"></li>
    </ol>

    <!-- スライドの内容 -->
    <div class="carousel-inner">
      <div class="item active">
        <?= Html::img('assets/img/photo1.jpg', ['alt' => '写真１']); ?>
      </div>
      <div class="item">
        <?= Html::img('assets/img/photo2.jpg', ['alt' => '写真２']); ?>
      </div>
      <div class="item">
        <?= Html::img('assets/img/photo3.jpg', ['alt' => '写真３']); ?>
      </div>
    </div>

    <!-- 左右の移動ボタン -->
    <a class="left carousel-control" href="#carousel-example" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    </a>
    <a class="right carousel-control" href="#carousel-example" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    </a>
  </div>

  <div class="contents">
    <div class="content-title col-md-12 col-sm-12 col-xs-12 text-center">
      <h1>機能</h1>
    </div>
    <div class="content-item col-md-4 col-sm-4 col-xs-12 text-center">
      <?= Html::img('assets/img/wing.png'); ?>
      <p>登録するお店の情報はお店の名前か電話番号で簡単に取得</p>
    </div>

    <div class="content-item col-md-4 col-sm-4 col-xs-12 text-center">
      <?= Html::img('assets/img/money.png'); ?>
      <p>使った金額やお店の感想などを入れるだけの簡単まとめ</p>
    </div>

    <div class="content-item col-md-4 col-sm-4 col-xs-12 text-center">
      <?= Html::img('assets/img/text.png'); ?>
      <p>様々なソートやグループで、見やすく管理しやすく</p>
    </div>
  </div>

</div>
