

<li
  <?= isset($element['active'])?'class="active"':'' ?>
  >
    <a href="<?= Helper::url($element['route'])?>"><?= $element['text']?></a>
</li>