

<div class="logger row">
  <div class="logger-block span3">
    <? foreach($variables as $var) { ?>
      <div style="border-bottom: 1px solid #348899">
        <?= $var ?>
      </div>
    <? } ?>
  </div>
  <div class="logger-block span3">
    <? if(!empty($queryes) && is_array($queryes)) { foreach($queryes as $query) { ?>
      <div style="border-bottom: 1px solid #348899">
        QUERY : "<span style="color:green"><?= $query['query']?></span>" <br>
        TIME : "<?= $query['time']?>"
      </div>
    <? }} ?>
  </div>
</div>