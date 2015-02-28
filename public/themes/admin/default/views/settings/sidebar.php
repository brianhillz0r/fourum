<ul class="nav fourum-admin-sidenav"  data-spy="affix" data-offset-top="65">
    <?php foreach (settings()->getAllNamespaces() as $namespace): ?>
        <li <?= isset($activeTab) && $activeTab == $namespace ? 'class="active"' : '' ?>><a href="<?= url('/admin/settings/' . $namespace) ?>"><?= ucwords($namespace) ?></a></li>
    <?php endforeach ?>
</ul>
