<?= View::make('meta') ?>
<?= View::make('header') ?>

<div class="row">
    <div class="col-md-12">
        <h3>Users</h3>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <?= View::make('users.sidebar') ?>
    </div>
    <div class="col-md-9">
        <table class="table table-striped">
            <thead>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th></th>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user->getId() ?></td>
                    <td><?= $user->getUsername() ?></td>
                    <td><?= $user->getEmail() ?></td>
                    <td>
                        <div class="btn-group btn-group-sm pull-right">
                            <a href="<?= url('/admin/users/manage/' . $user->getId()) ?>" class="btn btn-default">Manage</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?= View::make('footer') ?>
