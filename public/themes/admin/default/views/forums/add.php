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
                <h4>Add Forum</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <form role="form" action="<?= url('admin/forums/add') ?>" method="post">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title">
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control">
                            <?php foreach ($types as $type): ?>
                            <option value="<?= $type->id ?>">
                                <?= ucwords($type->name) ?>
                            </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Parent</label>
                        <select name="parent" class="form-control">
                            <option value="null"></option>
                            <?=
                                $tree->html(
                                    '<option value="%id%">%title%</option>',
                                    '<option value="%id%">&nbsp;&nbsp;&nbsp;%title%</option>'
                                );
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-default btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= View::make('footer') ?>
