<?= View::make('meta') ?>
<?= View::make('header') ?>

<div class="row">
    <div class="col-md-12">
        <h3>Forums</h3>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <?= View::make('forums.sidebar') ?>
    </div>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-12">
                <a href="<?= url('admin/forums/add') ?>" class="btn btn-default btn-primary" style="float:right;">Add Forum</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
            <?= $tree->html('<h4>%title%</h4>', '<p style="margin-left:30px;">%title%</p>') ?>
            </div>
        </div>
    </div>
</div>

<?= View::make('footer') ?>
