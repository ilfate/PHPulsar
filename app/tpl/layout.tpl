<?= Csrf::createInput() ?>
<?= $this->render('menu.tpl') ?>



<div class="container main">
    <div class="row">
        <div class="col-md-9">
            <div class="main-content-well well well-small ">
                <?= $content ?>
            </div>
        </div>
        <div class="col-md-3">
            <?= $this->inc('sidebar.tpl')?>
        </div>
    </div>
</div>

<?= $this->render('included_templates/main.tpl') ?>
<?= Js::getHtml() ?>
