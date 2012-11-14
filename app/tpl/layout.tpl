<div class="navbar navbar-fixed-top">
  <div class="">
    <div class="container">
      <a class="brand" href="#">Title</a>
      <ul class="nav">
        <li class="active"><a href="#!/">Start</a></li>
        <li><a href="#!/success">Success</a></li>
        <li><a href="#!/error">Error</a></li>
      </ul>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="span9">
      <div class="main-content-well well well-small ">
      <?= $content ?>
      </div>
    </div>
    <div class="span3">
      <div class="main-content-well-side well well-small">
		<?= Helper::exe('Logger', 'index'); ?>
      </div>
    </div>
  </div>
</div>
