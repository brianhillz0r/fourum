<?= view('meta') ?>
<?= view('header') ?>

<div class="row">
    <div class="col-md-12">
        <h3>Users</h3>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <?= view('users.sidebar') ?>
    </div>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-2">
                <h3 class="buffer-reset"><?= $user->getUsername() ?></h3>
                <div class="buffer-lg">
                    <img src="<?= gravatar($user->getEmail(), 100) ?>">
                </div>
            </div>
            <div class="col-md-10">
                <div class="btn-group pull-right">
                    <a href="<?= url('/admin/users/view/' . $user->getId()) ?>" class="btn btn-default">Ban</a>
                    <a href="<?= url('/admin/users/view/' . $user->getId()) ?>" class="btn btn-default">Message</a>
                </div>
            </div>
        </div>

        <div class="row buffer">
            <div class="col-md-12">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#profile" data-toggle="tab">Profile</a></li>
                    <li><a href="#permissions" data-toggle="tab">Permissions</a></li>
                    <li><a href="#effects" data-toggle="tab">Effects <?= count($currentEffects) ? "(".count($currentEffects).")" : '' ?></a></li>
                    <?php if ($menu->hasItems()): ?>
                    <?php foreach ($menu->getItems() as $item): ?>
                    <li><a href="<?= $item->getTarget() ?>" data-toggle="tab"><?= ucwords($item->getName()) ?></a></li>
                    <?php endforeach ?>
                    <?php endif ?>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- Tab panes -->
                <div class="tab-content">

                    <div class="tab-pane active" id="profile">
                        <div class="row">
                            <div class="col-md-12">
                                <?= view('users.form', array('user' => $user)) ?>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="permissions">
                        <?= view('users.permissions', array('user' => $user, 'permissions' => $permissions)) ?>
                    </div>

                    <div class="tab-pane" id="effects">
                        <?= view('users.effects', array('user' => $user, 'availableEffects' => $availableEffects, 'currentEffects' => $currentEffects)) ?>
                    </div>

                    <?php if ($menu->hasItems()): ?>
                    <?php foreach ($menu->getItems() as $tabItem): ?>
                    <div class="tab-pane" id="<?= $tabItem->getName() ?>">
                        <?= view($tabItem->getViewPath(), $tabItem->getData()) ?>
                    </div>
                    <?php endforeach ?>
                    <?php endif ?>

                </div>
            </div>
        </div>

    </div>
</div>

<?= view('footer') ?>
