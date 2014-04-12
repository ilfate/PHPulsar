<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-6">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Ilfate</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-6">
                <ul class="nav navbar-nav">
                    <? foreach ($ilfate_menu as $menuElement) { ?>
                        <li <?= isset($menuElement['active'])? 'class="active"':''?>>
                            <a href="<?= Helper::url($menuElement['class'], $menuElement['method'])?>">
                                <?= $menuElement['text']?>
                            </a>
                        </li>
                    <? } ?>
                </ul>
            </div>
        </div>
    </div>
</nav>