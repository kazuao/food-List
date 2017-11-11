<?= Asset::js('menu.js'); ?>
<?php
  $json = json_decode(file_get_contents('https://webservice.recruit.co.jp/hotpepper/gourmet/v1/?key=2138be60c330315f&keyword=%e5%9c%9f%e9%96%93%e5%9c%9f%e9%96%93&format=json'));
?>

<!-- ?php foreach($json->results->shop as $val): ? -->
<div class="container">

  <div class="row shop-page col-md-12">
    <div class="row s-l shop-img col-md-4 col-md-offset-2">
      <?php foreach($json->results->shop as $shop_img): ?>
        <?= Html::img($shop_img->photo->pc->l, ['class' => 'shop-img']); ?>
      <?php endforeach; ?>
    </div>
    <div class="row s-l shop-name col-md-4">
      <?php foreach($json->results->shop as $shop_name): ?>
        <p><?php echo $shop_name->name ?></p>
      <?php endforeach; ?>
    </div>
    <div class="row s-l shop_address col-md-4">
      <?php foreach($json->results->shop as $shop_address): ?>
        <p>住所：<?php echo $shop_address->address ?><p>
      <?php endforeach; ?>
    </div>
    <div class="row s-l shop_open col-md-4">
      <?php foreach($json->results->shop as $shop_open): ?>
        <p>営業時間：<?php echo $shop_open->open ?><p>
      <?php endforeach; ?>
    </div>
  </div>
  <hr>

</div>
<!-- ?php endforeach; ? -->
