<ul class="nav fourum-admin-sidenav"  data-spy="affix" data-offset-top="65">
    <?php foreach ($menu->getItems() as $item): ?>
    <li><a href="<?= $item->getTarget() ?>"><?= ucwords($item->getName()) ?></a></li>
    <?php endforeach ?>
</ul>
