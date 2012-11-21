<div class="navbar navbar-fixed-top">
  <div class="">
    <div class="container">
      <a class="brand" href="/">Ilfate</a>
      <ul class="nav">
        <? foreach ($ilfate_menu as $menu_el) { ?> 
          <?= $this::inc('interface/top_menu_el.tpl', array('element' => $menu_el))?>
        <? } ?>
        <li><a href="#!/error"><?=$access_restricted ? 'RESRICTED' : ''?></a></li>
      </ul>
      <? if(Service_Auth::isAuth()) { ?>
        <div class="btn-group pull-right">
        <button class="btn dropdown-toggle" data-toggle="dropdown">
          <?=Service_Auth::getUser()->name?>
          <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
            <li><a>Profile</a></li>
            <li><a class="ajax" href="?Auth=logOut">Log out</a></li>
          </ul>
        </div>
      <? } else { ?>
        <div class="btn-group pull-right">
          <a href="#ilfateModal" data-remote="<?= Helper::urlAjax(array('Auth', 'logInForm')) ?>" role="button" data-toggle="modal" class="btn btn-primary">Log in</a>
          <a href="#ilfateModal" data-remote="<?= Helper::urlAjax(array('Auth', 'signUpForm')) ?>" role="button" data-toggle="modal" class="btn btn-success">Sign up</a>
        </div>
     
        
      <? } ?>
    </div>
  </div>
</div>

