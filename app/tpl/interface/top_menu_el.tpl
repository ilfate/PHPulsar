

<li
  <?= isset($element['active'])?'class="active"':'' ?>
  >
    <a href="<?= Helper::url($element['class'], $element['method'])?>"><?= $element['text']?></a>
</li>