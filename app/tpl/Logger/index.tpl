

<div style="position: absolute; width: 300px; height: 500px; right: 0px; border: 1px solid #999;">
  <div style="border-bottom: 2px solid blue;">
    <? foreach($variables as $var) { ?>
      <div style="border-bottom: 1px solid #348899">
        <?= $var ?>
      </div>
    <? } ?>
  </div>
  <div style="border-bottom: 2px solid blue;">
    <? foreach($queryes as $query) { ?>
      <div style="border-bottom: 1px solid #348899">
        QUERY : "<span style="color:green"><?= $query['query']?></span>" <br>
        TIME : "<?= $query['time']?>"
      </div>
    <? } ?>
  </div>
</div>