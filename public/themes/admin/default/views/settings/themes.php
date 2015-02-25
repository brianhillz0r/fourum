<?= View::make('meta') ?>
<?= View::make('header') ?>

<div class="row">
    <div class="col-md-12">
        <h3>Settings</h3>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <?= View::make('settings.sidebar') ?>
    </div>
    <div class="col-md-9" style="height:1000px;">
        <h4 style="margin-bottom:20px;">Themes</h4>

        <?= View::make('settings.form', array('settings' => $settings)) ?>
    </div>
</div>

<?= View::make('footer') ?>
