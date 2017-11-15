<!DOCTYPE html>
<html>
<head>
  <meta lang="ja" charset="utf-8">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- All the files that are required -->
  <!-- bootstrap, css -->
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="<?= URI::base().'assets/css/top.css'; ?>" >
  <link rel="stylesheet" href="<?= URI::base().'assets/css/login.css'; ?>" >
  <link rel="stylesheet" href="<?= URI::base().'assets/css/user.css'; ?>" >
  <!-- JS, JQuery -->
  <script type="text/javascript" href="<?= URI::base().'assets/js/menu.js'; ?>"></script>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

  <link rel="icon" href="<?= URI::base().'assets/img/favicon.png' ?>">

  <title><?= $title; ?></title>

</head>
<body>

  <header><?= $header; ?></header>

  <?= $content; ?>

  <footer><?= $footer; ?></footer>

</body>
</html>
