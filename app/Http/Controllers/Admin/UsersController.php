<?php

namespace Fourum\Http\Controllers\Admin;

use Fourum\Http\Controllers\AdminController;
use Fourum\Menu\TabbedMenu;
use Fourum\Permission\Checker\CheckerInterface;
use Fourum\Permission\Permission;
use Fourum\Permission\UserPermissionRepositoryInterface;
use Fourum\Setting\Manager;
use Fourum\User\UserRepositoryInterface;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;

class UsersController extends AdminController
{
    /**
     * @var UserRepositoryInterface
     */
    protected $users;

    /**
     * @param Manager $settings
     * @param UserRepositoryInterface $users
     */
    public function __construct(Manager $settings, UserRepositoryInterface $users)
    {
        parent::__construct($settings);

        $this->users = $users;
    }

    public function index()
    {
        return view('users.index', ['users' => $this->users->getAll()]);
    }

    /**
     * @param UserPermissionRepositoryInterface $userPermissions
     * @param CheckerInterface $permission
     * @param Dispatcher $dispatcher
     * @param int $id
     */
    public function manage(
        UserPermissionRepositoryInterface $userPermissions,
        CheckerInterface $permission,
        Dispatcher $dispatcher,
        $id
    ) {
        $user = $this->users->get($id);
        $permissionNames = $userPermissions->getPermissionNames();

        $permissions = [];

        foreach ($permissionNames as $name) {
            $permissions[$name] = $permission->checkHard($name, $user);
        }

        $profileMenu = new TabbedMenu();
        $dispatcher->fire('admin.user.manage.menu', [$profileMenu, $user]);

        $data = [
            'user' => $user,
            'permissions' => $permissions,
            'menu' => $profileMenu
        ];

        return view('users.view', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        $user = $this->users->get($request->get('id'));
        $user->fill($request->only(['username', 'email']));

        $this->users->save($user);

        return redirect('/admin/users/manage/' . $request->get('id'));
    }

    /**
     * @param Request $request
     * @param UserPermissionRepositoryInterface $userPermissions
     * @return \Illuminate\Http\RedirectResponse
     */
    public function permissionsSave(Request $request, UserPermissionRepositoryInterface $userPermissions)
    {
        $user = $this->users->get($request->get('id'));

        foreach ($userPermissions->getPermissionNames() as $name) {
            $value = $request->get($name) ? true : false;
            $permission = new Permission($name, $value, $user);
            $userPermissions->save($permission);
        }

        return redirect('/admin/users/manage/' . $request->get('id'));
    }
}
