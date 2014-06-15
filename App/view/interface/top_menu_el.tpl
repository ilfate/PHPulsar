

<li
  <?= isset($element['active'])?'class="active"':'' ?>
  >
    <a href="<?= App\Helper::url($element['class'], $element['method'])?>"><?= $element['text']?></a>
</li>