<div class="navbar navbar-fixed-top">
  <div class="">
    <div class="container">
      <a class="brand" href="#">Ilfate</a>
      <ul class="nav">
        <li class="active"><a href="#!/">Start</a></li>
        <li><a href="#!/success">Success</a></li>
        <li><a href="#!/error">Error</a></li>
        <li><a href="#!/error"><?=$access_restricted ? 'RESRICTED' : ''?></a></li>
      </ul>
      <? if(Service_Auth::isAuth()) { ?>
        <a > Logged as <?= Service_Auth::getUser()->name ?> </a>
      <? } else { ?>
        <div class="btn-group pull-right">
          <a href="#ilfateModal" data-remote="<?= Helper::urlAjax(array('Auth', 'logInForm')) ?>" role="button" data-toggle="modal" class="btn btn-primary">Log in</a>
          <a href="#ilfateModal" data-remote="<?= Helper::urlAjax(array('Auth', 'signUpForm')) ?>" role="button" data-toggle="modal" class="btn btn-success">Sign up</a>
        </div>
     
        
      <? } ?>
    </div>
  </div>
</div>

