
<? /*
<?= Helper::exe('Main', 'Menu', array('awd')); ?>
<?= Helper::exe('Logger', 'index'); ?>
*/?>

<div class="hero-unit">
  <h1>Hello! My name is Ilya Rubinchik and this is my website!</h1>
</div>
<div class="row">
  <div class="span3 offset1">
    <a href="<?=Helper::url('Cv')?>">
      <div class="img-text" >
        <div class="text extra-big invert" >CV</div>
        <img src="<?=HTTP_ROOT ?>images/ilfate.png" width="300px" height="300px" class="img-rounded">
      </div>
    </a>
  </div>
  <div class="span3 offset1">
    <a href="<?=Helper::url('Game_Main')?>" data-target=".main-content-well">
      <div class="img-text" >
        <div class="text invert" >Game</div>
        <img src="<?=HTTP_ROOT ?>images/game/tank1_s.jpg" width="300px" height="300px" class="img-rounded">
      </div>
    </a>
  </div>
  
</div>


