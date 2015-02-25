<header class="navbar navbar-admin navbar-fixed-top" role="banner">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="<?= url('/admin') ?>" class="navbar-brand"><?= forum_name() ?></a>
        </div>
        <nav class="collapse navbar-collapse" role="navigation">
            <ul class="nav navbar-nav">
                <?php foreach ($menu->getItems() as $item): ?>
                <li>
                    <a href="<?= url($item->getTarget()) ?>"><?= ucwords($item->getName()) ?></a>
                </li>
                <?php endforeach ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="<?= url('/') ?>">Front</a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= user()->getUsername() ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= url('/auth/logout') ?>">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</header>

<div class="container" style="margin-top:50px;">
