<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title><?= $page_title ?></title>
  <? $path_to_web = 'app/web/' ?>
  
  
  <link rel="stylesheet" href="<?=$path_to_web?>bootstrap/css/bootstrap.min.css" type="text/css" media="screen" >
  
  <link rel="stylesheet" href="<?=$path_to_web?>css/main.css" type="text/css" />
  
  <script src="<?=$path_to_web?>bootstrap/js/bootstrap.min.js"></script>
  <script src="<?=$path_to_web?>js/jquery-1.8.2.min.js"></script>
  
  <link rel="shortcut icon" href="images/favocon.iso" type="image/x-icon"/>
  
</head>
<body>
  <?= $content ?>
</body>