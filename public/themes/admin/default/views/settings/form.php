<?php if (Session::get('message')): ?>
<div class="alert alert-success">
    <?= Session::get('message') ?>
</div>
<?php endif ?>

<form role="form" action="<?= url('admin/settings') ?>" method="post">
    <?= form()->token() ?>
    <?php foreach($settings as $setting): ?>
        <?= $setting->render($formatter) ?>
    <?php endforeach ?>
    <button type="submit" class="btn btn-default btn-primary">Save</button>
</form>
